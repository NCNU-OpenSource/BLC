# Execute your telegram_bot

import sys
import telepot
import time
import os
import MySQLdb


bot = telepot.Bot('731117699:AAGjKzCCC-GHoMJDVEQ29XFAVrQTH9_yimQ') # put yout teleram_bot token

def handle(msg):
    chat_id = str(msg['chat']['id'])
    command = msg['text']
    usr = msg['chat']['username']

    from connDB import db, cursor
    sql = "SELECT count(email) FROM `customers` WHERE `telegramID` ='" + usr + "'"
    cursor.execute(sql)
    num = cursor.fetchone()

    if( command == '/start'):
        if( num[0] == 1 ):
            from connDB import db, cursor

            # add chat_id
            sql = "UPDATE `customers` SET `chatID`=" + chat_id + " WHERE `telegramID` ='" + usr +"'"
            cursor.execute(sql)
            db.commit()
        else:
            bot.sendMessage(chat_id , "You haven't regisistered in our BLC\nPlease come to our servie base to register in BLC")

bot.message_loop(handle)

while(1):
    time.sleep(10)




