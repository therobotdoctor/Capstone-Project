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
        <h2>Contact Us Today!</h2>
        <div class="contactcontainer">
            <form action="contactform.php">

                <label for="fname">First Name</label>
                <input type="text" style="background-color: #fff" id="fname" name="firstname" placeholder="Your name.." required>

                <label for="lname">Last Name</label>
                <input type="text" style="background-color: #fff" id="lname" name="lastname" placeholder="Your last name.." required>

                <label for="country">Country</label>
                <select id="country" name="country">
                  <option value="australia">Australia</option>
                  <option value="canada">Canada</option>
                  <option value="usa">USA</option>
    </select>

                <label for="subject">Subject</label>
                <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px" required></textarea>

                <input type="submit" value="Submit">

            </form>
        </div>

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

                <p align="center" style="font-size:15px">Forgot<a href="forgotpassword.html" style="color:dodgerblue"> Password?</a></p>
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
