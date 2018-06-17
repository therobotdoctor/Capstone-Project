<?php
    session_start();
?>
<html lang="en">
<head>
    <?php include('fullHeader.php');?>
</head>

<body>

    <main>

        <!--This is the section for the Google Maps-->
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
        <!--The script to interface with DB-->
        <script src="https://sdk.amazonaws.com/js/aws-sdk-2.7.16.min.js"></script>
        <script>
            function loadMapData(map) {
                document.getElementById('textarea').innerHTML += "getting user|";
                
                
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
                            document.getElementById('textarea').innerHTML += car.CarID + ": Lat " + car.Lat + " - Long " + car.Long + "\n";
                            var markerTemp = { lat: (car.Lat * 1), lng: (car.Long * 1) };
                            var marker = new google.maps.Marker({
                                position: markerTemp,
                                map: map
                            });
                        
                        
                        // create info window
                        var contentString = '<div id="content">'+
                          '<div id="siteNotice">'+
                          '</div>'+
                          '<h1 id="firstHeading" class="firstHeading">'+car.CarID+'</h1>'+
                          '<div id="bodyContent">'+
                          '<p>Car Details'+
                          '<br/>Make: '+ car.Make+
                          '<br/>Model: '+car.Model+
                          '<br/>Colur: '+car.Colour+
                          '</p>'+
                          '<p>Book from your account page</p>'+
                          '</div>'+
                          '</div>';
                    
                          var infowindow = new google.maps.InfoWindow({
                            content: contentString
                          });
                        
                          marker.addListener('click', function() {
                            infowindow.open(map, marker);
                          });
                        });
                        

                        // Continue scanning if we have more movies (per scan 1MB limitation)
                        document.getElementById('textarea').innerHTML += "Scanning for more..." + "\n";

                        if (params.ExclusiveStartKey != data.LastEvaluatedKey) {
                            params.ExclusiveStartKey = data.LastEvaluatedKey;
                            docClient.scan(params, onScan);
                        }
                    }
                }
                
            }
        </script>

        <textarea hidden readonly id="textarea"></textarea>




        <!--end section-->




    </main>

</body>



<div id="footer" class="main_footer_navigation">
    <?php include('footermenu.php'); ?>
</div>

</html>
