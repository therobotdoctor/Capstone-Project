<?php
    session_start();
?>
<html lang="en">
<head>
    <?php include('fullHeader.php');?>
</head>

<body>

    <main>

<!-- put 'pay now' button to confirmation.php, to exchange the 'confirm' button
after user press pay now, it will redirect to their sandbox personal, and make the payment,
if payment successful, it should direct them to 'makeBooking.php' where booking is successfully made -->

    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
        
        <!--PayPayl Variables -->
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="5K5FFLZJWB546">
        <input type="hidden" name="business_name" value="RideOn Car Sharing">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="quantity" value='<? php echo $totalTime; ?>'/>
        <input type="hidden" name="item_name" value='<? php echo $carName; ?>'/>
        <input type="hidden" name="amount" value='<? php echo $totalCost; ?>'>
        
        <input type="hidden" name="currency_code" value="AUD">
        <input type="image" src="https://www.sandbox.paypal.com/en_AU/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
    </form>

        <!--end section-->




    </main>

</body>

<!-- Button to open the modal -->

    
        

<!-- The Modal (contains the Sign Up form) -->

<!-- The Modal (contains the Sign In Form -->

    


<div id="footer" class="main_footer_navigation">
    <?php include('footermenu.php'); ?>
</div>

</html>
