<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="RideOn Main Homepage">
    <meta name="keywords" content="Homepage">

    <title>RideOn Car Share</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <div>
        <div id="logo-banner">
            <a href="index.php">
        <img id="logo" src="img/Logo v1.png" alt="RideOn Logo">
        </a>
        </div>
    </div>


    <!--- main nav--->
    <div id="header" class="main_navigation">
        <?php include 'navmenu.php'; ?>
        <div id="btnreg" class="btn">
                    <button class="bttn-material-flat bttn-md bttn-primary" onclick="document.getElementById('id01').style.display='block'">Register</button>
                </div>
                <div id="btnsign">
                    <button class="bttn-material-flat bttn-md bttn-primary" onclick="document.getElementById('id02').style.display='block'">Sign In</button>
                </div>
    </div>
    
    <!--- end of main nav--->

    <!-- Place Picture of Cars as Header Banner -->
    <div id="cars-banner">
        <img id="cars" src="img/cars_banners.png" alt="RideOn Logo">
    </div>
</head>


<body>


    <main>
        <?php
            $car = $_POST['carToBook'];
            $carType = $_POST['carType'];
            
            $_SESSION['bookingDetails'][4] = $carType;
            $_SESSION['bookingDetails'][0] = $car;
            
        ?>
    <script type="text/javascript" src="javascript/booking.js"></script>
        <!-- Still needs to be fixed, result wanted: https://www.w3schools.com/howto/howto_js_tabs.asp -->

    <div class="month"> 
      <ul>
        <li class="prev">&#10094;</li>
        <li class="next">&#10095;</li>
        <li>May<br><span style="font-size:18px">2018<br><br></span></li>
        <li>Choose a date for pickup</li>
      </ul>
    </div>
    
    <ul class="weekdays">
      <li>Mo</li>
      <li>Tu</li>
      <li>We</li>
      <li>Th</li>
      <li>Fr</li>
      <li>Sa</li>
      <li>Su</li>
    </ul>
    
    <ul class="days"> 
    <form method="POST" id="dateForm" action="bookdetails.php" >
        
        <input type="hidden" name="dateToBook" id="dateToBook"/>
        
        <?php
            for($i=1;$i<32;$i++){
                echo '<li><button type="submit" style="color:#FFFFFF" onclick="setDate(\'2018.05.'.$i.'\')">'.$i.'</button></li>';
            }
        ?>
        <script type="text/javascript">
            function setDate(date){
                        document.getElementById("dateToBook").value = date;
                        
                    }
                        
        </script>

    </form>
        
    </ul>

    </main>

    <?php include 'register.php'; ?>
    
    <? php include 'login.php'; ?>
    
</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
