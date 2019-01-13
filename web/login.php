<?php 
    include "connDB.php";
    $_SESSION["isLogin"] = false;
    $user=addslashes($_POST['email']);
    $pwd=addslashes($_POST['psword']);
    $sql_query = "SELECT * FROM `customers` where email='$user' and psword='$pwd'";
    $result = mysqli_query($db_link, $sql_query) or die("Query Fail! ".mysqli_error($db_link));
    $numRow = mysqli_num_rows($result);
    if ($numRow ==0) {
        echo "Login fail!";
        $_SESSION["isLogin"] = false;
        header("Location: login.html"); 
    } else {
        $_SESSION["user"] = $user;
        $_SESSION["isLogin"] = true;
        header("Location: portfolio.php");  
    }
?>