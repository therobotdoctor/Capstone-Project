<?php

    session_start(); 
    
    //start DB connection
    require 'aws/aws.phar';
    
    $user = $_SESSION['user'];
    
    
    date_default_timezone_set('UTC');
    
    use Aws\DynamoDb\Exception\DynamoDbException;
    use Aws\DynamoDb\Marshaler;
    
    $sdk = new Aws\Sdk([
        //'endpoint'   => 'dynamodb.us-west-2.amazonaws.com',
        'region'   => 'us-west-2',
        'version'  => 'latest',
        'credentials' => [
            'key'    => 'AKIAIAGHSUW7LN42DWBQ',
            'secret' => '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',
        ],
    ]);
    
    
    $dynamodb = $sdk->createDynamoDb();
    $marshaler = new Marshaler();
?>
<!DOCTYPE html>
    
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
    <script type="text/javascript" src="javascript/account.js"></script>
        <!-- Still needs to be fixed, result wanted: https://www.w3schools.com/howto/howto_js_tabs.asp -->

        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'users')">Users</button>
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'carList')">Cars</button>
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'bookings')">Bookings</button>
        </div>

        <!-- Tab content -->
        
        <div id="users" class="tabcontent">
            <div >
            <h3 style="font-size:30px; padding-left: 20px">User Management</h3>
            <p>
                <!------This is the section for User Admin----------->
                <?php
                    echo "User List <br/><br/>";
                    
                    $tableName = 'Users';
                    
                    $params = [
                        'TableName' => $tableName,
                        'ProjectionExpression' => 'email, password, #nme',
                        'ExpressionAttributeNames'=> [ '#nme' => 'name' ],
                    ];
                    
                    try {
                        $result = $dynamodb->scan($params);
                        
                        while(true){
                            foreach($result['Items'] as $i){
                                $book = $marshaler->unmarshalItem($i);
                                
                                echo 'Email: '.$book['email'].'<br/>';
                                echo 'Name: '.$book['name'].'<br/>'; 
                                echo '---------<br/>';
                            }
                            
                            if (isset($result['LastEvaluatedKey'])) {
                                $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                            } else {
                                break;
                            }
                        }
                        
                    }
                    catch (DynamoDbException $e) {
                        echo "Unable to query:\n";
                        echo $e->getMessage() . "\n";
                    }
                    
                ?>
                <!-------end section------------->
            </p>
            </div>
            <div>
                <form method="POST" action="removeUser.php">
                    <h3 style="font-size:30px; padding-left: 20px">REMOVE USER</h3> 
                    <input required type="email" id="userToRemove" name="userToRemove" placeholder="Enter User Email"></input>
                    <button type="submit" value="removeUser">REMOVE USER</button>
                </form>
            </div>
        </div>
        <div id="carList" class="tabcontent">
            <div>
            <h3 style="font-size:30px; padding-left: 20px">Car Management</h3>
            <p style="font-size:25px; text-align:centre;">
                <!------This is the section for Car Management----------->
                <br/>
                <?php
                    $tableName = 'Cars';
                    
                    $params = [
                        'TableName' => $tableName,
                        'ProjectionExpression' => 'CarID, Colour, Lat, #lng, #mk, Model, #typ',
                        'ExpressionAttributeNames'=>['#lng' => 'long', '#mk' => 'Make', '#typ' => 'Type'],
                    ];
                    
                    try {
                        $result = $dynamodb->scan($params);
                        
                        while(true){
                            foreach($result['Items'] as $i){
                                $book = $marshaler->unmarshalItem($i);
                                
                                echo 'Car ID:'.$book['CarID'].'<br/>';
                                echo 'Make: '.$book['Make'].'<br/>';
                                echo 'Model:'.$book['Model'].'<br/>';
                                echo 'Type: '.$book['Type'].'<br/>';
                                echo 'Colour: '.$book['Colour'].'<br/>';
                                
                                echo '---------<br/>';
                            }
                            
                            if (isset($result['LastEvaluatedKey'])) {
                                $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                            } else {
                                break;
                            }
                        }
                        
                    }
                    catch (DynamoDbException $e) {
                        echo "Unable to query:\n";
                        echo $e->getMessage() . "\n";
                    }
                    
                    //need to be able to view cars
                    
                    
                    //need to be able to add cars
                    
                    
                    //need to be able to remove cars
                    // remove via car ID
                    
                ?>
                </p>
                </div>
                <div>
                    <p>
                    <form action="addCar.php" method="POST">
                        <br/> ADD CAR <br/>
                        Enter Make: <input type="text" id="CarMake" name="CarMake" required>
                        Enter Model: <input type="text" id="CarModel" name="CarModel" required>
                        Enter Colour: <input type="text" id="CarColour" name="CarColour" required>
                        Select Type: 
                        <select required name="typeSelect" id="typeSelect">
                            <option value="" selected disabled hidden>Select Car Type</option>
                            <option value="standard">Standard</option>
                            <option value="van">Van</option>
                            <option value="suv">SUV</option>
                            <option value="luxury">Luxury</option>
                        </select>
                        Car Location
                        <!--
                        <input type="radio" name="locationSelect" onChange="displayLatLong()" value="manually">Enter Lat/Long
                        <input type="radio" name="locationSelect" onChange="displayGMap()" value="map">By Map<br/>
                        -->
                        <div id="inputLatLong">
                            Enter Latitude : <input type="text" id="CarLat" name="CarLat" required>
                            Enter Longitude : <input type="text" id="CarLong" name="CarLong" required>
                        </div>
                        <!-- Map for entering lat/long if I can work out how to retrive value
                        <div id="map" ></div>
                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8OtHsqDm-Xi4aOMcTh90M58PUY0zlJc8&callback=initMap"></script>
                        <script type="text/javascript">
                        function initMap() {
                            var rmit = { lat: -37.807, lng: 144.963 };
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 10,
                                center: rmit
                            });
                        }
                        </script>
                        -->
                        <button type="submit">Add Car</button>
    
                    </form>
                <!-------end section------------->
                <br> 
                </p>
                </div>
                
                <!-- Remove Car -->
                <div>
                    <p>
                    <form action="removeCar.php" method="POST">
                        <br/> REMOVE CAR <br/>
                        Enter Car ID: <input type="text" id="CarToRemove" name="CarToRemove" required>
                        <button type="submit">Remove Car</button>
    
                    </form>
                <!-------end section------------->
                    <br> 
                    </p>
                </div>
        </div>
        <div id="bookings" class="tabcontent">
            <h3 style="font-size:30px; padding-left: 20px">View All Bookings</h3>
            <p style="font-size:25px;">
                <!------This is the section to View Bookings----------->
                <?php
                    $tableName = 'Bookings';
                    
                    $params = [
                        'TableName' => $tableName,
                        'ProjectionExpression' => 'carID, #dtTime, #dt, StartTime, EndTime, #usr',
                        'ExpressionAttributeNames'=> [ '#dt' => 'Date' , '#usr' => 'User', '#dtTime' => 'dateTime'],
                    ];
                    
                    try {
                        $result = $dynamodb->scan($params);
                        
                        while(true){
                            foreach($result['Items'] as $i){
                                $book = $marshaler->unmarshalItem($i);
                                
                                echo 'Car ID:'.$book['carID'].'<br/>';
                                echo 'Date: '.$book['Date'].'<br/>';
                                echo 'Start:'.$book['StartTime'].'<br/>';
                                echo 'End: '.$book['EndTime'].'<br/>';
                                echo 'User: '.$book['User'].'<br/>';
                                
                                echo '---------<br/>';
                            }
                            
                            if (isset($result['LastEvaluatedKey'])) {
                                $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                            } else {
                                break;
                            }
                        }
                        
                    }
                    catch (DynamoDbException $e) {
                        echo "Unable to query:\n";
                        echo $e->getMessage() . "\n";
                    }
                
                ?>
                
            </p>
        </div>

    </main>
    <!-- Button to open the modal -->

    <?php include('register.php'); ?>
    <?php include('login.php'); ?>
    
</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
