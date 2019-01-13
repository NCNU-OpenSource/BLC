import MySQLdb

db = MySQLdb.connect(
    host="",  #DB的所在位址IP
    user="",  #使用者名稱
    port=3306,
    passwd="", #使用者名稱密碼
    db=""  #DB的名稱
)
cursor = db.cursor()
