BLC
===

#### 所需材料
web Server: BLC會員網站 登入會員。 

dataBase: 存放會員資料(到現場、手動登入)。 

一個健康快樂愛生活的會場:讓會員們可以在裡面交流、看書。 

RFID: 進入會場前需要逼卡。

RFID接線Raspberry Pi
紅：SDA     接24  

橘：SCK     接23  

黃：MOSI    接19 

綠：MISO    接21  

藍：GND     接20  

紫：RST     接22  

黑：3.3V    接1




#### 逼卡之後
當您心儀的對象進入我們Club時，會自動通知您的telegram，叫您趕快來唷。 

未完成目標：為了因應變態問題。當有您不想再連絡的對象時，我們可以幫你封鎖到他那兒的訊息唷。

#### 網站內容
前置作業：

開啟session-->php.ini中把session.auto_start改1 

php-–>/etc/apache2/mods-enabled/php7.2.conf中php_admin_value engine 改On

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
##### 方法
sudo apt install apache2  

更改

apache2：用userdir的module讀取家目錄中public_html的內容  
sudo a2enmod rewrite
sudo a2enmod userdir  

#### DataBase (MySQL)
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
    * 會員自我介紹 (intro)  //有字數限制
    * 在不在會場(location)  //  %2=1的話表示在會場，%2=0的話表示不在場
    
    
    -->table:followers
    * 第幾筆追蹤
    * 追蹤者的email-正在登入的帳號  (email)
    * 被追蹤者的email-點擊頭貼的對象  (fEmail)
    
### telegram bot
/start:將對方的chatID抓進資料庫。 如果沒有註冊過，會要求對方到現場來註冊。
會員追蹤的人進入會場後會發訊息通知!

### 分工

蔡佳軒:題目發想，RFID、telegram bot

莊詠婷:題目發想，RFID、網站、DB架設

#### 參考資料
< python相關 >
https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/364537/
http://www.runoob.com/python/python-mysql.html
https://blog.gtwang.org/programming/python-mysqldb-connect-mysql-database-tutorial/
https://segmentfault.com/q/1010000007979637

< RFID >
https://blog.csdn.net/qq_26093511/article/details/51385079
https://sites.google.com/site/jonasdigiclass/gong-zuo-ji-lu/rfidxieruziliaodaokapian
https://github.com/mxgxw/MFRC522-python

< Telegram_bot >
https://core.telegram.org/bots/api
https://core.telegram.org/bots
https://www.instructables.com/id/Set-up-Telegram-Bot-on-Raspberry-Pi/
https://blog.sean.taipei/2017/05/telegram-bot


