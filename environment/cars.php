<!DOCTYPE php>
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
        <h2>Our Fleet</h2>

        <div class="carscontainer">
            <div class="row">
                <div class="column">
                    <div id="standard">
                        <img id="car1" src="img/standard.png" alt="Standard Car">
                    </div>
                    <div style="font-size:35px;">
                        <b>Toyota Yaris</b>
                    <br>
                    <i>Standard</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Features include:</b>
                    </div>
                    <div id="car-features">
                        <br> &#x2611; Seats 5
                        <br> &#x2611; 6 SRS Airbag
                        <br> &#x2611; ABS Brakes
                        <br> &#x2611; 5 star ANCAP Safety Rating
                        <br> &#x2611; Reverse Camera
                        <br> &#x2611; Touch Screen Audio System
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="suv">
                        <img id="car2" src="img/suv.png" alt="SUV">
                    </div>
                    <div style="font-size:35px;">
                        <b>Mitsubishi Motors</b>
                        <i>SUV</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Features include:</b>
                    </div>
                    <div id="car-features">
                        <br> &#x2611; Comfortably Seats 5
                        <br> &#x2611; Eco Drive Mode to Save Fuel and Emissions
                        <br> &#x2611; ABS Brakes, Electronic Stability Control, Downhill Brake Control and Hill-Start Assist
                        <br> &#x2611; 5 star ANCAP Safety Rating
                        <br> &#x2611; Reverse Camera
                        <br> &#x2611; Touch Screen Audio System
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="luxury">
                        <img id="car3" src="img/luxury.png" alt="Luxury Car">
                    </div>
                    <div style="font-size:30px;">
                        <b>BMW 4 Series Convertible Atlanta</b>
                        <br>
                        <i>Luxury</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Features include:</b>
                    </div>
                    <div id="car-features">
                        <br> &#x2611; Seats 4
                        <br> &#x2611; Power Roof
                        <br> &#x2611; Cruise Control
                        <br> &#x2611; Parking Assist Self-Parking System
                        <br> &#x2611; Dakota Leather Seats Upholstery
                        <br> &#x2611; Touch Screen Audio System
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="van">
                        <img id="car4" src="img/van.png" alt="Van">
                    </div>
                    <div style="font-size:35px;">
                        <b>Peugeot Essex Van</b>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Features include:</b>
                    </div>
                    <div id="car-features">
                        <br> &#x2611; Seats 2 or 3
                        <br> &#x2611; 6 SRS Airbag
                        <br> &#x2611; ABS Brakes, Electronic Stability Control and Hill Start Assist
                        <br> &#x2611; 4 star ANCAP Safety Rating
                        <br> &#x2611; Space 6 Cubic Metres
                        <br> &#x2611; Internal Cargo Space: 2.930m Long, 1.545m Wide, 1.335m High
                    </div>
                </div>
            </div>
        </div>
        <div>


    </main>

</body>

<main>
    <!-- Button to open the modal -->


    <!-- The Modal (contains the Sign Up form) -->
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

    <!-- The Modal (contains the Sign In Form -->
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

                <p align="center" style="font-size:15px">Forgot<a href="forgotpassword.php" style="color:dodgerblue"> Password?</a></p>
                <hr>
                <div class="clearfix">
                    <button type="submit" class="signin">Submit</button>
                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </div>
        </form>
    </div>

</main>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>



</html>
