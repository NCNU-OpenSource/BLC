<?php
  $isLogin = $_SESSION['isLogin'];
  if (!$isLogin) 
    header("Location: login.html");
?>
<?php
//取消追蹤的PHP
    include("connDB.php");
    $em=$_SESSION["user"];
    if (isset($_GET["email"])) { 
        $follow = $_GET["email"];
        if (!isset($_SESSION["user"][$follow])){ 
            $sql = "DELETE from followers where email='$em' and fEmail='$follow'";  //加入資料表的指令
            mysqli_query($db_link, $sql);
            echo "<span style='color:darkblue; font-size: 20pt'> Stop Following Him.</span>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>BLC - Find Out Your Prince Charming!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,700,800" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.php">BLC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="solutions.php" class="nav-link">Location</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="room.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Functions</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="portfolio.php">Have A Crush!</a>
                  <a class="dropdown-item" href="portfolio-single.php">Following</a>
                </div>
            </li>
            <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
            <li class="nav-item active"><a href="contact.php" class="nav-link">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->
    
    <section class="home-slider owl-carousel ftco-degree-bg">
      <div class="slider-item bread-wrap" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">
            <div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span class="mr-2"><a href="portfolio.php">Functions</a></span></p>
              <h1 class="mb-3">Following</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
      <div class="container">
        <div class="row no-gutters">
          <div class="block-3 d-md-flex ftco-animate" align="center">
            <h2 class="mb-3">#Click pictures to unfollow them!</h2>
          </div>
          <?php
            #拿取資料PHP
            include("connDB.php");
            $sql_query = "SELECT `fEmail`, `name`, `intro`, `type` FROM `customers`, `followers` where followers.email = '$em' and followers.fEmail = customers.email";
            $result = mysqli_query($db_link,$sql_query);
            $i=0;
            while ($rs=mysqli_fetch_assoc($result)) {  //有幾位使用者就跑幾次
              if($i % 2 == 1)
                $msg=" order-2";
              else
                $msg="";
                
          ?>
              <div class="block-3 d-md-flex ftco-animate">
              <a href="portfolio-single.php?email=<?php echo $rs["fEmail"];?>" class="image<?php echo $msg;?>" style="background-image: url('pictures/<?php echo $rs["fEmail"];?>.jpg');"></a>
                <div class="text">
                 <h2 class="heading"><?php echo $rs['name'];?></h2>
                  <!-- <h4 class="subheading"><?php echo $rs['intro'];?></h4> -->
                  <h4 class="subheading">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h4>
                  <p><?php echo $rs['fEmail'];?></p>
                  <p>Type：<?php echo $rs['type'];?></p>
                </div>
              </div>
          <?php
              $i++;
            } 
          ?>

          
        </div>
        <div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Company</h2>
              <p>We are BLC founders. Hope you can enjoy our service!</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Quick Links</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Home</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Location</a></li>
                <li><a href="#" class="py-2 d-block">Functions</a></li>
                <li><a href="#" class="py-2 d-block">Contact</a></li>
                <li><a href="#" class="py-2 d-block">Privacy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Contact Information</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block"> Chi-Nan University</a></li>
                <li><a href="#" class="py-2 d-block">+886 916065549</a></li>
                <li><a href="#" class="py-2 d-block">tingting2733682@email.com</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>