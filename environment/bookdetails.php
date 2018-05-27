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
    <?php
        $date = $_POST['dateToBook'];
        //Need to formate date to dd.mm.yyyy deliniate on .
        $_SESSION['bookingDetails'][1] = $date;
        
        $carID = $_SESSION['bookingDetails'][0];
        
        //echo $_SESSION['bookingDetails'][0].$_SESSION['bookingDetails'][1];
        
        require 'aws/aws.phar';
        
        date_default_timezone_set('UTC');
        
        use Aws\DynamoDb\Exception\DynamoDbException;
        use Aws\DynamoDb\Marshaler;
        
        $sdk = new Aws\Sdk([
            //'endpoint'   => 'dynamodb.us-west-2.amazonaws.com',
            'region'   => 'us-west-2',
            'version'  => 'latest',
            'credentials' => [
                'key'    => 'INSERT KEY HERE',
                'secret' => 'SECRET KEY',
            ],
        ]);
        
        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();
        
        $tableName = 'Bookings';
        
        
        
        $eav = $marshaler->marshalJson('
        {
            ":CarID": "'.$carID.'",
            ":SearchDate": "'.$date.'"
        }
        ');
        
        
        $params = [
            'TableName' => $tableName,
            'ProjectionExpression' => 'carID, #dtTime, #dt, StartTime, EndTime, #usr',
            'KeyConditionExpression' => 'carID = :CarID',
            'FilterExpression' => '#dt = :SearchDate',
            'ExpressionAttributeNames'=> [ '#dt' => 'Date' , '#usr' => 'User', '#dtTime' => 'dateTime'],
            'ExpressionAttributeValues'=> $eav
        ];
        
        
        try {
            
            $result = $dynamodb->query($params);
            

            $endTimes = array();
            
            while(true){
                foreach($result['Items'] as $i){
                    
                    $book = $marshaler->unmarshalItem($i);
                    //print_r($book);
                    
                    
                    $startTimes[] = $book['StartTime'];
                    $endTimes[] = $book['EndTime'];
                    
                    
                }
                
                if (isset($result['LastEvaluatedKey'])) {
                    $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                } else {
                    break;
                }
            }
            //get all
            //iterate through
            //grab start to finish times
            // build select
            // pass details to confirm page
            //confirm page injects into DB
        } catch (DynamoDbException $e) {
            echo "Unable to query:\n";
            echo $e->getMessage() . "\n";
        }
        //create start time array
        $validStartTimes = array();
        $validDisplayStartTimes = array();
        
        
        for($p=0;$p<2400;$p=$p+100){
            $formatP = sprintf("%04d", $p);
            $displayP = strval($formatP);
            $displayP = substr_replace($displayP, ':', 2, 0);
            $validStartTimes[] = $formatP;
            $validDisplayStartTimes[] = $displayP;
            
            $formatP += 30;
            $formatP = sprintf("%04d", $formatP);
            $displayP = strval($formatP);
            $displayP = substr_replace($displayP, ':', 2, 0);
            $validStartTimes[] = $formatP;
            $validDisplayStartTimes[] = $displayP;
            
        }
        
        //create end time array
        $validEndTimes = array();
        $validDisplayEndTimes = array();
        
        
        for($p=30;$p<=2400;$p=$p+100){
            $formatP = sprintf("%04d", $p);
            $displayP = strval($formatP);
            $displayP = substr_replace($displayP, ':', 2, 0);
            $validEndTimes[] = $formatP;
            $validDisplayEndTimes[] = $displayP;
            
            $formatP += 70;
            $formatP = sprintf("%04d", $formatP);
            $displayP = strval($formatP);
            $displayP = substr_replace($displayP, ':', 2, 0);
            $validEndTimes[] = $formatP;
            $validDisplayEndTimes[] = $displayP;
            
        }
        
        
        //print_r($validDisplayStartTimes);
        
        //filter by elements in booking times
        $total = count($startTimes);
        //print_r($endTimes);
        
        for($i = 0;$i<$total;$i++){
            $first = array_search($startTimes[$i], $validStartTimes);
            $last = array_search($endTimes[$i], $validEndTimes);
            
            //echo ">>>".$last;
        
            for($j=$first;$j<=$last;$j++){
                $validStartTimes[$j] = null;
                $validDisplayStartTimes[$j] = null;
                
                $validEndTimes[$j] = null;
                $validDisplayEndTimes[$j] = null;
            }
        }
        
        echo'<div class="time-container">    
                <p style="margin: 0 auto; text-align:center;">Start Time:</p>
                <form method="POST" style="text-align:center; margin: 0 auto; width: 20%;" action="confirmation.php">
                    <select required name="start" onchange="buildEndSelect()" id="startSelect">
                        <option value="" selected disabled hidden>Select Start Time</option>';
                    //print array
                        for($i=0;$i<count($validStartTimes);$i++){
                            if($validStartTimes[$i] != null){
                                echo '<option value="'.$validStartTimes[$i].'">'.$validDisplayStartTimes[$i].'</option>';
                            }
                            else{
                                echo '<option value="'.$validStartTimes[$i].'"disabled >BOOKED</option>';
                            }
                        }
        echo '</select>';
        
        
        //now for ending Times
        
        //print_r($validDisplayStartTimes);
        
        //Maybe create second select using JS
        //onselect build new option list, stopping on BOOKED value or EO array
        
        ?>
        
        <script type='text/javascript'>
            function buildEndSelect(){
                //destroy select and rebuild
                //except index 0?
                
                var mySelect = document.getElementById("endSelect");
                var x = mySelect.length;
                for(var j=x; j>0; j--){
                    mySelect.remove(j);
                }
                
                
                var jsEndArrayValue= <?php echo json_encode($validEndTimes); ?>;
                var jsEndArrayDisplay= <?php echo json_encode($validDisplayEndTimes); ?>;
                
                var currentStartTime = document.getElementById("startSelect").value;
                
                //var mySelect = document.getElementById("endSelect");
                var reachedEnd = 0;
                
                for (var i=0; i < jsEndArrayValue.length; i++){
                    if(jsEndArrayValue[i] > currentStartTime || reachedEnd == 1){
                        reachedEnd = 1;
                        
                        if(jsEndArrayValue[i] != null){
                            var option = document.createElement("option");
                            option.value = jsEndArrayValue[i];
                            option.text = jsEndArrayDisplay[i];
                            mySelect.appendChild(option);
                        }
                        else{
                            reachedEnd = 2;
                        }
                    }
                    
                    if(reachedEnd == 2){
                        break;
                    }
                }
                
                // from https://stackoverflow.com/questions/17001961/javascript-add-select-programmatically
                /*
                var myDiv = document.getElementById("myDiv");

                //Create array of options to be added
                var array = ["Volvo","Saab","Mercades","Audi"];
                
                //Create and append select list
                var selectList = document.createElement("select");
                selectList.id = "mySelect";
                myDiv.appendChild(selectList);
                
                //Create and append the options
                for (var i = 0; i < array.length; i++) {
                    var option = document.createElement("option");
                    option.value = array[i];
                    option.text = array[i];
                    selectList.appendChild(option);
                }
                */

            }
        </script>
        
        <?php
        //using JSON to share array with JS
        
        //to work on
        
        echo'<p style="margin: 0 auto; text-align:center;">End Time:</p>
        <select required name="end" id="endSelect">
            
            <option value="" selected disabled hidden>Select Finish Time</option>';
            /*print array
            for($i=0;$i<count($validEndTimes);$i++){
                if($validEndTimes[$i] != null){
                    echo '<option value="'.$validEndTimes[$i].'">'.$validDisplayEndTimes[$i].'</option>';
                }
                else{
                    echo '<option value="'.$validEndTimes[$i].'"disabled >BOOKED</option>';
                }
            }*/
        echo '</select>
        <button type="submit">Review</button>
        </form>
        </div>';
                    

    ?>
<!--
<div class="time-container">    
    <p style="text-align:left;">Start Time:</p>
    <form style="width: 20%;" action="/action_page.php">
        <select name="cars">
          <option value="time">10:00 AM</option>
          <option value="time">10:30 AM</option>
          <option value="time">11:00 AM</option>
          <option value="time">11.30 AM</option>
          <option value="time">12:00 PM</option>
          <option value="time">12:30 PM</option>
          <option value="time">01:00 PM</option>
          <option value="time">01.30 PM</option>
          <option value="time">02:00 PM</option>
          <option value="time">02:30 PM</option>
          <option value="time">03:00 PM</option>
          <option value="time">03.30 PM</option>
          <option value="time">04:00 PM</option>
          <option value="time">04:30 PM</option>
          <option value="time">05:00 PM</option>
        </select>
    <p style="text-align:left;">End Time:</p>
        <select name="cars">
          <option value="time">10:00 AM</option>
          <option value="time">10:30 AM</option>
          <option value="time">11:00 AM</option>
          <option value="time">11.30 AM</option>
          <option value="time">12:00 PM</option>
          <option value="time">12:30 PM</option>
          <option value="time">01:00 PM</option>
          <option value="time">01.30 PM</option>
          <option value="time">02:00 PM</option>
          <option value="time">02:30 PM</option>
          <option value="time">03:00 PM</option>
          <option value="time">03.30 PM</option>
          <option value="time">04:00 PM</option>
          <option value="time">04:30 PM</option>
          <option value="time">05:00 PM</option>
        </select>
    <input type="submit" value="Submit">
</form>
</div>
-->
</main>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>
