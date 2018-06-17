<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <?php include('fullHeader.php');?>
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
    <form action="bookdetails.php" method='POST'>
    Select Date for Booking:<br/><br/>
    <input required type="date" name="bookDate" id="bookDate" min=
     <?php
         echo date('Y-m-d');
     ?>
     >
     <br/><br/>
     <input type="submit"></input>
     </form>

    </main>

    <?php include 'register.php'; ?>
    
    <? php include 'login.php'; ?>
    
</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
