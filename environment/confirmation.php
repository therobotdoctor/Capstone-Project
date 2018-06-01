<?php
    session_start();
?>
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
<main>
    <div> 
    
    <?php
        //temp formating
        $sTime = $_POST['start'];
        $eTime = $_POST['end'];
        $_SESSION['bookingDetails'][2] = $sTime;
        $_SESSION['bookingDetails'][3] = $eTime;
        
        //calculate total cost = hours * type cost/hour
        $costs = [
            "Standard" => "10.45",
            "SUV" => "14.45",
            "Luxury" => "20.50",
            "Van" => "14.45",
            ];
        
        //time
        $half = 0;
        $totalTime = $eTime - $sTime;
        if($totalTime % 100 != 0){
            $half = 1;
        }
        $totalTime = $totalTime / 100;
        $totalTime = floor($totalTime);
        if($half){
            $totalTime = $totalTime + .5;
        }
        
        //calc cost
        $totalCost = $totalTime * $costs[$_SESSION['bookingDetails'][4]];
        $totalCost = sprintf("%.2f", $totalCost);
        $_SESSION['totalCost'] = $totalCost;
        
        //format output times
        $sTime = substr_replace($sTime, ':', 2, 0);
        $eTime = substr_replace($eTime, ':', 2, 0);
        echo '
        <p style="padding: 30px; font-size:30px;"> You Are Going To Book: </p>
        <div id="standard">
        <img style="width:30%; text-align:center; margin:0 auto; id="'.$_SESSION['bookingDetails'][0].'" src="img/'.strtolower($_SESSION['bookingDetails'][4]).'.png" alt="Car">
        </div>
        Car: '.$_SESSION['bookingDetails'][0].'<br/>
            Date: '.$_SESSION['bookingDetails'][1].'<br/>
            Start Time: '.$sTime.'<br/>
            Finish Time: '.$eTime.'<br/>
            Total Time: '.$totalTime.'hours<br/>
            Total Cost: $'.$totalCost.'<br/>';
            
    ?>
    
    
    
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
        
        <!--PayPal Variables -->
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="rideon-test@aperturemail.com">
        <input type="hidden" name="business_name" value="RideOn Car Sharing">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="quantity_x" value="<?php echo $totalTime; ?>"/>
        <input type="hidden" name="item_name" value="Selected Car"/>
        <input type="hidden" name="amount" value= "<?php echo $totalCost; ?>">
        <input type="hidden" name="return" value="https://aa19114af4a04984afeb9ba9c5452ab0.vfs.cloud9.us-west-2.amazonaws.com/makeBooking.php">
      
        <input type="hidden" name="currency_code" value="AUD">
        <button type="submit" value="CONFIRM">PAY (via PayPal)</button>
    </form>
    </div>
</main>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>