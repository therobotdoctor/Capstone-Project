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
                        //document.getElementById("dateForm").submit();
                    }
                        
        </script>

    </form>
        <!--
      <li><a href="bookdetails.php" style="color: #777">1</a></li>
      <li><a href="bookdetails.php" style="color: #777">2</li>
      <li><a href="bookdetails.php" style="color: #777">3</li>
      <li><a href="bookdetails.php" style="color: #777">4</a></span></li>
      <li><a href="bookdetails.php" style="color: #777">5</li>
      <li><a href="bookdetails.php" style="color: #777">6</li>
      <li><a href="bookdetails.php" style="color: #777">7</li>
      <li><a href="bookdetails.php" style="color: #777">8</li>
      <li><a href="bookdetails.php" style="color: #777">9</li>
      <li><a href="bookdetails.php" style="color: #777">10</li>
      <li><a href="bookdetails.php" style="color: #777">11</li>
      <li><a href="bookdetails.php" style="color: #777">12</li>
      <li><a href="bookdetails.php" style="color: #777">13</li>
      <li><a href="bookdetails.php" style="color: #777">14</li>
      <li><a href="bookdetails.php" style="color: #777">15</li>
      <li><a href="bookdetails.php" style="color: #777">16</li>
      <li><a href="bookdetails.php" style="color: #777">17</li>
      <li><a href="bookdetails.php" style="color: #777">18</li>
      <li><a href="bookdetails.php" style="color: #777">19</li>
      <li><a href="bookdetails.php" style="color: #777">20</li>
      <li><a href="bookdetails.php" style="color: #777">21</li>
      <li><a href="bookdetails.php" style="color: #777">22</li>
      <li><a href="bookdetails.php" style="color: #777">23</li>
      <li><a href="bookdetails.php" style="color: #777">24</li>
      <li><a href="bookdetails.php" style="color: #777">25</li>
      <li><a href="bookdetails.php" style="color: #777">26</li>
      <li><a href="bookdetails.php" style="color: #777">27</li>
      <li><a href="bookdetails.php" style="color: #777">28</li>
      <li><a href="bookdetails.php" style="color: #777">29</li>
      <li><a href="bookdetails.php" style="color: #777">30</li>
      <li><a href="bookdetails.php" style="color: #777">31</li>
      -->
    </ul>

    </main>

    <?php include 'register.php'; ?>
    <!-- The Modal (contains the Sign Up form)
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">X</span>
        <form class="modal-content" action="/action_page.php">
            <div class="container">
                <h1 align='center'>Registration</h1>
                <p align='center'>Please fill in this form to create an account.</p>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                </label>
                <hr>

                <p style="font-size:12px">By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                <div class="clearfix">
                    <button type="submit" class="signup">Sign Up</button>
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </div>
        </form>
    </div>
     -->

    <? php include 'login.php'; ?>
    <!-- The Modal (contains the Sign In Form 
    <div id="id02" class="modal">
        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">X</span>
        <form class="modal-content" action="/action_page.php">
            <div class="container">
                <h1 align='center'>Sign In</h1>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                </label>

                <p align="center" style="font-size:15px">Forgot<a href="forgotpassword.html" style="color:dodgerblue"> Password?</a></p>
                <hr>
                <div class="clearfix">
                    <button type="submit" class="signin">Submit</button>
                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    -->


</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
