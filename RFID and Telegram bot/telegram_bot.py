import sys
import telepot
import MySQLdb


bot = telepot.Bot('731117699:AAGjKzCCC-GHoMJDVEQ29XFAVrQTH9_yimQ') # put your telegram_bot token


# Telegram send msg to cID's tracker
# cID: bi's card ID
# loc: his place 
#       * odd: in 
#       * even: out
def IO_msg(cID, loc):

    from connDB import db, cursor

    # find cID's trackers's chatID in dataBase --> chatIDs[]
    sql = "SELECT b.`name`, `customers`.`chatID` FROM `customers`, `followers`,(SELECT `name`,`email` as beF from customers where cID ='"+ cID +"') as b WHERE customers.email = followers.email and b.beF = followers.fEmail"
    cursor.execute(sql)
    chatIDs = cursor.fetchall()

    # if 0 (even: out)
    if(loc%2 == 0):
        # send msg(name[cID] leave the club) to trackers[]
        for tracker in chatIDs:
            bot.sendMessage(tracker[1],tracker[0]+" leave the club")
    # if 1 (odd: in)
    elif(loc%2 == 1):
        # send msg(name[cID] is in the club) to trackers[]
        for tracker in chatIDs:        
            bot.sendMessage(tracker[1],tracker[0]+" is in the club")




