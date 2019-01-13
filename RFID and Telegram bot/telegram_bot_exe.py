# execute your telegram_bot

import sys
import telepot
import time
import os
import MySQLdb
import re


bot = telepot.Bot('') # put yout teleram_bot token

status = 0
cng = ""
def handle(msg):
    global status, cng

    chat_id = str(msg['chat']['id'])
    command = msg['text']
    usr = msg['chat']['username']
    from connDB import db, cursor
    sql = "SELECT count(email) FROM `customers` WHERE `telegramID` ='" + usr + "'"
    cursor.execute(sql)
    num = cursor.fetchone()
    print(num[0])
    if( num[0] == 1 ):
        if( command == '/start'):
            from connDB import db, cursor
            # add chat_id
            sql = "UPDATE `customers` SET `chatID`=" + chat_id + " WHERE `telegramID` ='" + usr +"'"
            cursor.execute(sql)
            db.commit()
        elif( status == 1 ):
            from connDB import db, cursor
            status = 0
            # change data
            sql = "UPDATE `customers` SET `" +cng+ "`='" + re.escape(command) + "' WHERE `telegramID` ='" + usr +"'"
            cursor.execute(sql)
            db.commit()
            bot.sendMessage(chat_id , "successfully changed the " +cng+ " !")
        elif( command == '/name'):
            bot.sendMessage(chat_id , "Please input your new name")
            status = 1
            cng = 'name'
        elif( command == '/birthday'):
            bot.sendMessage(chat_id, "Please input your birthday\nFollow this format: YYYY-MM-DD\nEx:1999-01-01")
            status = 1
            cng = 'birthday'
        elif(command == '/introduction'):
            bot.sendMessage(chat_id, "Please input your self introduction")
            status = 1
            cng = 'intro'
    else:
        bot.sendMessage(chat_id , "You haven't regisistered in our BLC, please come to our servie base to register in BLC")

bot.message_loop(handle)

while(1):
    time.sleep(10)
