<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('fullHeader.php');?>
</head>


<body>
<main>
        <h2>Vehicle and Usage Rates</h2>

        <div class="carscontainer">
            <div class="row">
                <div class="column">
                    <div id="standard">
                        <img id="car1" src="img/standard.png" alt="Standard Car">
                    </div>
                    <div style="font-size:35px;">
                        <br>
                        <b>Toyota Yaris</b>
                        <br>
                        <i>Standard</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Usage Rates:</b>
                    </div>
                    <div id="car-features">
                        <br> Hourly  |  $10.45hr
                        <br> + distance  |  $0.40/km
                        <br>
                        <br> Daily  |  $85day
                        <br> incl. 150km
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="suv">
                        <img id="car2" src="img/suv.png" alt="SUV">
                    </div>
                    <div style="font-size:35px;">
                        <br>
                        <b>Mitsubishi Motors</b>
                        <br>
                        <i>SUV</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Usage Rates:</b>
                    </div>
                    <div id="car-features">
                        <br> Hourly  |  $14.45hr
                        <br> + distance  |  $0.40/km
                        <br>
                        <br> Daily  |  $91day
                        <br> incl. 150km
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="luxury">
                        <img id="car3" src="img/luxury.png" alt="Luxury Car">
                    </div>
                    <div style="font-size:35px;">
                        <br>
                        <b>BMW 4 Series Convertible Atlanta</b>
                        <br>
                        <i>Luxury</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Usage Rates:</b>
                    </div>
                    <div id="car-features">
                        <br> Hourly  |  $20.50hr
                        <br> + distance  |  $0.40/km
                        <br>
                        <br> Daily  |  $155day
                        <br> incl. 150km
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div id="van">
                        <img id="car4" src="img/van.png" alt="Van">
                    </div>
                    <div style="font-size:35px;">
                        <br>
                        <b>Peugeot Essex</b>
                        <br>
                        <i>Van</i>
                    </div>
                </div>
                <div class="column">
                    <div style="font-size:25px">
                        <b>Usage Rates:</b>
                    </div>
                    <div id="car-features">
                        <br> Hourly  |  $14.45hr
                        <br> + distance  |  $0.40/km
                        <br>
                        <br> Daily  |  $91day
                        <br> incl. 150km
                    </div>
                </div>
            </div>
        </div>
        <div>


    </main>

</body>

<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>

</html>
