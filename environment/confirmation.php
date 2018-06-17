<?php
    session_start();
?>
<html lang="en">

<head>
    <?php include('fullHeader.php');?>
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
        <input type="hidden" name="return" value="https://[YOUR WEBSITE ADDRESS]/makeBooking.php">
      
        <input type="hidden" name="currency_code" value="AUD">
        <button type="submit" value="CONFIRM">PAY (via PayPal)</button>
    </form>
    </div>
</main>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>