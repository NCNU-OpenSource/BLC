# BLC


## 主要功能
BLC為一個男性與男性的交友網站，而它也不單單是個網站，我們也有會場供會員之間交流。

要成為BLC的會員，需先到我們的會場來現場註冊，到時會先填一些資料，且需要先加入我們BLC telegram bot的好友，也會發一張卡，作為以後進入會場時的紀錄。

而在網頁層面，您可以登入我們的網站，並且可以查找您喜歡的對象並追蹤，亦可到另外一個介面去查看您的追蹤人，或是取消追蹤。

記住！我們是一個健康、正常、促進男性與男性交流的社團！

## 實測影片
https://drive.google.com/open?id=1y0jWnlyWXwfEY9d-lTbQ3eZmlgjkXodv

## 所需材料
* web Server: BLC會員網站 登入會員。 

* dataBase: 存放會員資料(到現場、手動登入)。 

* 一個健康快樂愛生活的會場: 讓會員們可以在裡面交流、看書。 

* RFID: 進入會場前需要逼卡。

* 蜂鳴器

* LED燈

* 杜邦線: 7 + 2 + 2 (依設備而定）

###### RFID接線Raspberry Pi

|杜邦線顏色||GPIO編號|
|---|---|---|
|紅|SDA|接24|
|橘|SCK |接23|
|黃|MOSI| 接19
|綠|MISO|接21
|藍|GND|接20
|紫|RST|接22
|黑|3.3V|接1

## 網站內容
前置作業：

sudo apt install apache2  

sudo a2enmod rewrite
sudo a2enmod userdir  

開啟session-->php.ini中把session.auto_start改1 

php-–>/etc/apache2/mods-enabled/php7.2.conf中php_admin_value engine 改On

註：connDB.php可自行設定主機名稱、使用者帳號密碼

註：放會員照片時，需命名為該會員的帳號(信箱).jpg，資料夾在/web/pictures上。

* 架設網站 (使用lamp-server) 來源:https://magiclen.org/lamp/
    * 基本頁面設計 (模板來源 https://www.free-css.com/free-css-templates?start=24)
        * 主頁面Home(index.html):放最新消息
        ![](https://i.imgur.com/oGpwsKk.jpg)
        * 關於我們About us(about.html):放我們的相關資訊
         ![](https://i.imgur.com/9jwbJPI.png)
        * 服務據點(原solution.html):放我們的位置在哪。
        ![](https://i.imgur.com/gidSmlg.png)
        * 會員服務
            * (portfolio.html)放所有會員的資料，點擊圖片可追蹤。
            ![](https://i.imgur.com/cgZgGzF.png)
            * (portfolio-single.html)放會員自己有追蹤的人的列表，點擊圖片可取消追蹤
            ![](https://i.imgur.com/jjPQMVj.png)
        * 個人頁面(blog.html):可自行設計 
        * 聯繫我們(contact.html):有什麼需要告知我們的就寄信
        ![](https://i.imgur.com/7dt25iT.png)
        * 註冊:只能在現場註冊
        * 登入(login.html):在進入會員服務或個人頁面之前，若還沒登入過，必須登入
        ![](https://i.imgur.com/sCvwgfh.jpg)

## DataBase (MySQL)
註：使用者帳號要開放任意主機(%)
註：()內為在db的欄位名稱

    --> table:customers
    * 姓名(name)
    * 生日(birthday)
    * 密碼(psword)
    * 信箱 = 帳號 (email)
    * 種類 (type)
    * telegramID (telegramID)
    * 卡號 (cID)
    * telegram辨識 (chatID)
    * 會員自我介紹 (intro)  註：要有字數限制
    * 在不在會場(location)  註：%2=1的話表示在會場，%2=0的話表示不在場
    
    
    -->table:followers
    * 第幾筆追蹤 (serno)
    * 追蹤者的email-正在登入的帳號  (email)
    * 被追蹤者的email-點擊頭貼的對象  (fEmail)
## RFID
核對會員卡,確認是否擁有入場的資格,會在逼卡後更改持卡人狀態(location),並透過 telegram_bot 通知持卡人追隨者們

* 在 MFRC522-python/ 執行
    `python BLC_rfid.py`

### 前置作業
* 打開 pi 的 SPI
    raspi-config
* 重新開機 pi
* 設定 config.txt 增加 spi模組
    * sudo vim /boot/config.txt
    * 找到 dtparam=spi=on
    * 在他下面加上 dtoverlay=spi-bcm2708
    * pi 重新開機
    sudo reboot now
    * 確認是不是安裝成成功
    lsmod | grep spi
    查詢結果出現 spi_bcm2835 表示成功
* 安裝 python-dev
    sudo apt-get install python-dev
* 取得SPI-py程式碼
    * git clone https://github.com/lthiery/SPI-Py.git
    * cd SPI-Py
    * sudo python setup.py install
    * cd
* 安裝 MFRC522-python
    * git clone https://github.com/mxgxw/MFRC522-python.git

* 將 BLC_rfid.py telegram_bot.py connDB.py 放到資料夾 MFRC522-python/（~/MFRC522-python/)

* 更改 telegram_bot.py 的 telepot.Bot() 為要控制的 bot token

* 更改 connDB.py 的 host, user, psswd, db 為目標資料庫

### BLC_rfid.py
控制 RFID 的感測

* 取得卡號( 卡片 sector 0 )並驗證
* 連線資料庫,取得持卡人追隨者的 chat_ID
* 透過bot發送持卡人位置狀態給追隨者

### telegram_bot.py
建立與 telegram_bot 的連線

* 記得更改: bot = telepot.Bot( 你的telegram_bot token )

### connDB.py
連線 phpMyadmin, 須更改的參數...

* host = 目標資料庫 IP
* user = 使用者名稱
* passwd = 該使用者密碼
* db = 目標資料庫

## Telegram Bot
### 前置作業
* 在telegram 加 BotFather 好友
* 輸入 /newbot 建立新的 telegram_bot, 設定bot的 名稱 & ID
![](https://i.imgur.com/cJKsPnx.png)


## 分工

蔡佳軒：題目發想，RFID、telegram bot

莊詠婷：:題目發想，RFID、網站、DB架設

## 參考資料
< python相關 >

https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/364537/

http://www.runoob.com/python/python-mysql.html

https://blog.gtwang.org/programming/python-mysqldb-connect-mysql-database-tutorial/

https://segmentfault.com/q/1010000007979637

< RFID >

https://blog.csdn.net/qq_26093511/article/details/51385079

https://sites.google.com/site/jonasdigiclass/gong-zuo-ji-lu/rfidxieruziliaodaokapian

https://github.com/mxgxw/MFRC522-python

http://atceiling.blogspot.com/2017/02/raspberry-pi-rfid.html

< Telegram_bot >

https://core.telegram.org/bots/api

https://core.telegram.org/bots

https://www.instructables.com/id/Set-up-Telegram-Bot-on-Raspberry-Pi/

https://blog.sean.taipei/2017/05/telegram-bot


