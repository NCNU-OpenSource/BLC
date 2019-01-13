<?php
    $host = '192.168.1.66'; #資料庫的UP位址
    $user = 'root'; #使用者帳號
    $passw = '123456789';  #使用者密碼
    $dbName = 'blc';  #資料庫名稱

    $db_link=@mysqli_connect($host, $user, $passw, $dbName);
    if(!$db_link) 
        die("Could not connect : " . mysqli_error());  
    mysqli_set_charset($db_link,"utf8");

?>
