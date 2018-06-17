<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        echo "<script type=\"text/javascript\">alert(\"You must Login to access your account page\")</script>";
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
        die();
    }
?>
<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <?php include('fullHeader.php');?>
</head>


<body>

    <main>
    <script type="text/javascript" src="javascript/account.js"></script>
        <!-- Still needs to be fixed, result wanted: https://www.w3schools.com/howto/howto_js_tabs.asp -->

        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'findcars')">Find Cars</button>
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'myaccount')">My Account</button>
            <button class="tablinks" style="font-size:25px;" onclick="openTab(event, 'mybookings')">My Bookings</button>
        </div>

        <!-- Tab content -->
        
        <div id="findcars" class="tabcontent">
            <h3 style="font-size:30px; padding-left: 20px">Book Available Cars</h3>
            <p>
                <!------This is the section for the Google Maps----------->
                <form method="POST" action="booking.php" >
                    
                    <input type="hidden" name="carToBook" id="carToBook"/>
                    <input type="hidden" name="carType" id="carType"/>
                                      
                    <div id="map"></div>
            
                    <script>
                        function initMap() {
                            var rmit = { lat: -37.807, lng: 144.963 };
                            var map = new google.maps.Map(document.getElementById('map'), {
                               
                            });
                            // try centre on users location
                            //https://developers.google.com/maps/documentation/javascript/examples/map-geolocation
                            markerUser = new google.maps.Marker;
                            infoWindowUser = new google.maps.InfoWindow;
                      
                            //try obtain users location, will not work without permission
                            if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(function(position) {
                                        var pos = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    };
                                
                                //alert(pos);
                                markerUser = new google.maps.Marker({
                                    position : pos,
                                    map: map,
                                    icon: 'img/location.png',
                                    title: 'Your location'
                                });
                                
                                
                                map.setZoom(13);
                                map.setCenter(pos);
                                
                                
                                }, function() {
                                    handleLocationError(true, infoWindowUser, map.getCenter());
                            });
                              
                            } else {
                              // Browser doesn't support Geolocation
                              
                              handleLocationError(false, infoWindowUser, map.getCenter());
                            }
                            
                          
                    
                          function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                            infoWindow.setPosition(pos);
                            infoWindow.setContent(browserHasGeolocation ?
                                                  'Error: The Geolocation service failed.' :
                                                  'Error: Your browser doesn\'t support geolocation.');
                            infoWindow.open(map);
                            
                          }
                            loadMapData(map);
                        }
                    </script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8OtHsqDm-[YOUR GOOGLE MAPS API KEY]&callback=initMap">
                    </script>
                    <!-----The script to interface with DB------->
                    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.16.min.js"></script>
                    <script>
                        
                        
                        function loadMapData(map) {
                            document.getElementById('textarea').innerHTML += "getting user|"
                             // Initialize the Amazon Cognito credentials provider
                            AWS.config.region = 'us-west-2'; // Region
                            AWS.config.credentials = new AWS.CognitoIdentityCredentials({
                                IdentityPoolId: 'us-west-2:2ea6d792-bc4e-4546-8c9d-fd9fa1347beb',
                            });
                            var docClient = new AWS.DynamoDB.DocumentClient();
            
                            document.getElementById('textarea').innerHTML += "Scanning table." + "\n";
            
                            var params = {
                                TableName: "Cars",
                                ProjectionExpression: "#id, #lat, #lng, #make, #model, #type, #clr",
                                ExpressionAttributeNames: {
                                    "#id": "CarID",
                                    "#lat": "Lat",
                                    "#lng": "Long",
                                    "#make": "Make",
                                    "#model": "Model",
                                    "#type": "Type",
                                    "#clr": "Colour",
                                }
                            };
            
                            docClient.scan(params, onScan);
            
                            function onScan(err, data) {
                                if (err) {
                                    document.getElementById('textarea').innerHTML += "Unable to scan the table: " + "\n" + JSON.stringify(err, undefined, 2);
                                }
                                else {
                                    // Print
                                    document.getElementById('textarea').innerHTML += "Scan succeeded. " + "\n";
                                    data.Items.forEach(function(car) {
                                        if(car.Lat != null){
                                        document.getElementById('textarea').innerHTML += car.CarID + ": Lat " + car.Lat + " - Long " + car.Long + "\n";
                                        var markerTemp = { lat: (car.Lat * 1), lng: (car.Long * 1)};
                                        var marker = new google.maps.Marker({
                                            position: markerTemp,
                                            map: map
                                        });
                                    
                                        var tempCar = car.CarID;
                                        // create info window
                                        var contentString = '<div id="content">'+
                                        '<div id="siteNotice">'+
                                        '</div>'+
                                        '<h1 id="firstHeading" class="firstHeading">'+car.CarID+'</h1>'+
                                        '<div id="bodyContent">'+
                                        '<p>Car Details<br/>'+
                                        'Make: '+ car.Make+'<br/>'+
                                        'Model: '+car.Model+'<br/>'+
                                        'Colour: '+car.Colour+'<br/>'+
                                        'Type: '+car.Type+
                                        '</p>'+
                                        '<p><button type="submit" onclick="setCarValue(\''+tempCar+'\',\''+car.Type+'\')">Book car</button></p>'+
                                        '</div>'+
                                        '</div>';
                                        
                                        var infowindow = new google.maps.InfoWindow({
                                            content: contentString
                                        });
                                        
                                        marker.addListener('click', function() {
                                            infowindow.open(map, marker);
                                        });
                                    }});
                                    
            
                                    // Continue scanning if we have more movies (per scan 1MB limitation)
                                    
                                    if (params.ExclusiveStartKey != data.LastEvaluatedKey) {
                                        params.ExclusiveStartKey = data.LastEvaluatedKey;
                                        docClient.scan(params, onScan);
                                    }
                                }
                                
                            }
                            
                        }
                    </script>    
                    <script type="text/javascript">
                        function setCarValue(id,type){
                            document.getElementById("carToBook").value = id;
                            document.getElementById("carType").value = type;
                        }
                    </script>
            
                    <textarea hidden readonly id="textarea"></textarea>
                                      
                </form>
        <!-------end section------------->
        </p>
        </div>
        <div id="myaccount" class="tabcontent">
            <h3 style="font-size:30px; padding-left: 20px">Account Details</h3>
            <p style="font-size:25px; text-align:left;">
                <br> Email: <?php echo $_SESSION['user'];?>
                <br> Name: <?php echo $_SESSION['userName'];?>
                
                <br/><br/>
                <a href="forgotpassword.php" style="color:blue">RESET PASSWORD HERE</a>
                <br/><br/>
                
            </p>
            <div>
                <form action="updateUserName.php" method="POST">
                    <br/> Add/Update User Name <br/>
                        Enter Name: <input type="text" id="updateName" name="updateName" required>
                        <button type="submit">Update</button>
    
                </form>
            </div>
        </div>
        <div id="mybookings" class="tabcontent">
            <h3 style="font-size:30px; padding-left: 20px">Booking History</h3>
            <p style="font-size:25px;">
                <?php
                
                    require 'aws/aws.phar';
                    
                    $user = $_SESSION['user'];
                    
                    
                    date_default_timezone_set('UTC');
                    
                    use Aws\DynamoDb\Exception\DynamoDbException;
                    use Aws\DynamoDb\Marshaler;
                    
                    $sdk = new Aws\Sdk([
                      //'endpoint'   => 'dynamodb.us-west-2.amazonaws.com',
                      'profile' => 'default',
                      'region'   => 'us-west-2',
                      'version'  => 'latest',
                      
                    ]);

                      
                    $dynamodb = $sdk->createDynamoDb();
                    $marshaler = new Marshaler();
                    
                    $tableName = 'Bookings';
                    
                    $eav = $marshaler->marshalJson('
                        {
                            ":usr": "'.$user.'"
                        }
                    ');
                    
                    $params = [
                        'TableName' => $tableName,
                        'ProjectionExpression' => 'carID, #dtTime, #dt, StartTime, EndTime, #usr',
                        'FilterExpression' => '#usr = :usr',
                        'ExpressionAttributeNames'=> [ '#dt' => 'Date' , '#usr' => 'User', '#dtTime' => 'dateTime'],
                        'ExpressionAttributeValues'=> $eav
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

    
    
    <!-- The Modal (contains the Sign Up form)-->
    
    
    
    
    <!-- The Modal (contains the Sign In Form-->


</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
