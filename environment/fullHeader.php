<?php
echo '<meta charset="utf-8">';
echo '<meta name="description" content="RideOn Main Homepage">';
echo '<meta name="keywords" content="Homepage">';

echo '<title>RideOn Car Share</title>';
echo '<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">';
echo '<link rel="stylesheet" href="css/style.css">';

echo '<div>';
echo '<div id="logo-banner">';
echo '<a href="index.php">';
echo '<img id="logo" src="img/Logo v1.png" alt="RideOn Logo">';
echo '</a>';
echo '</div>';
echo '</div>';


echo '<!--- main nav--->';
echo '<div id="header" class="main_navigation">';
?>
<?php include('navmenu.php'); ?>
<?php
echo '<div id="btnreg" class="btn">';
echo '<button class="bttn-material-flat bttn-md bttn-primary" onclick="document.getElementById(\'id01\').style.display=\'block\'">Register</button>';
echo '</div>';
echo '<div id="btnsign">';
echo '<button class="bttn-material-flat bttn-md bttn-primary" onclick="document.getElementById(\'id02\').style.display=\'block\'">Sign In</button>';
echo '</div>';
echo '</div>';

echo '<!-- Include Regester Modal -->';
?>
<?php include('register.php');?>
<?php

echo '<!-- Inlcude Sign In Modal -->';
?>
<?php include('login.php');?>
<?php
echo '<!--- end of main nav--->';

echo '<!-- Place Picture of Cars as Header Banner -->';
echo '<div id="cars-banner">';
echo '<img id="cars" src="img/cars_banners.png" alt="RideOn Logo">';
echo '</div>'; 
?>
