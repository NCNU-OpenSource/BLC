# Execute RFID

import time
import RPi.GPIO as GPIO
import MFRC522
import signal
import os

GPIO.setmode(GPIO.BOARD)

Buzzer  = 7
LED1    = 11
counter = 0


GPIO.setup(Buzzer,GPIO.OUT)
GPIO.setup(LED1,GPIO.OUT)


continue_reading = True

def getLoc(cID):
    from connDB import db, cursor

    # get the location state of this cID
    sql = "SELECT `location` FROM `customers` WHERE cID ='"+cID+"'"
    cursor.execute(sql)
    result = cursor.fetchone()
    loc = int(result[0])
    return loc

def changeLoc(cID, loc):
    from connDB import db, cursor

    # get the location state of this cID
    sql = "UPDATE `customers` SET `location`="+str(loc)+ " WHERE `cID`='"+cID+"'"
    cursor.execute(sql)
    db.commit()

def end_read(signal,frame):
    global continue_reading
    print "Ctrl+C captured, ending read."
    continue_reading = False
    GPIO.cleanup()

def ok_sign():
    global Buzzer
    GPIO.output(Buzzer,GPIO.HIGH)
    time.sleep(0.5)
    GPIO.output(Buzzer,GPIO.LOW)

def fail_sign():
    global Buzzer, LED1
    GPIO.output(LED1,GPIO.HIGH)
    GPIO.output(Buzzer,GPIO.HIGH)
    time.sleep(0.2)
    GPIO.output(Buzzer,GPIO.LOW)
    time.sleep(0.1)
    GPIO.output(Buzzer,GPIO.HIGH)
    time.sleep(1)
    GPIO.output(LED1,GPIO.LOW)
    GPIO.output(Buzzer,GPIO.LOW)

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# Welcome message
print "Welcome to the MFRC522 data read example"
print "Press Ctrl-C to stop."


while continue_reading:
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)

    # If a card is found
    if status == MIFAREReader.MI_OK:
        print "Card detected"
    
    # Get the UID of the card
    (status,uid) = MIFAREReader.MFRC522_Anticoll()

    # If we have the UID, continue
    if status == MIFAREReader.MI_OK:

        # Print UID
        print "Card read UID: "+str(uid[0])+","+str(uid[1])+","+str(uid[2])+","+str(uid[3])
    
        # This is the default key for authentication
        key = [0xFF,0xFF,0xFF,0xFF,0xFF,0xFF]
        
        # Select the scanned tag
        MIFAREReader.MFRC522_SelectTag(uid)

        # Authenticate
        status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)

        if status == MIFAREReader.MI_OK:
            result = MIFAREReader.MFRC522_Read(8)
            MIFAREReader.MFRC522_StopCrypto1()
            ok_sign()

            # get cID
            cID = str(uid[0])+","+str(uid[1])+","+str(uid[2])+","+str(uid[3])
            
            # get location
            loc = getLoc(cID)
            
            # change location
            changeLoc(cID,loc+1)

            # send msg to trackers
            from telegram_bot import IO_msg
            IO_msg(cID, loc+1)
            print("send msg to followers")
        else:
            print "Authentication error"
            fail_sign()