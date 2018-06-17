<?php
    session_start();
?>
<html lang="en">

<head>
    <?php include('fullHeader.php');?>
</head>


<main>
    <?php
        $date = $_POST['bookDate'];
        
        $date = str_replace("-",".",$date);
       
        
        $_SESSION['bookingDetails'][1] = $date;
        
        $carID = $_SESSION['bookingDetails'][0];
        
        require 'aws/aws.phar';
        
        date_default_timezone_set('UTC');
        
        use Aws\DynamoDb\Exception\DynamoDbException;
        use Aws\DynamoDb\Marshaler;
        
        $sdk = new Aws\Sdk([
            'region'   => 'us-west-2',
            'version'  => 'latest',
            'profile' => 'default',
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
                    
                    $startTimes[] = $book['StartTime'];
                    $endTimes[] = $book['EndTime'];
                    
                    
                }
                
                if (isset($result['LastEvaluatedKey'])) {
                    $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                } else {
                    break;
                }
            }
            
            
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
        
        
        //filter by elements in booking times
        $total = count($startTimes);
        
        for($i = 0;$i<$total;$i++){
            $first = array_search($startTimes[$i], $validStartTimes);
            $last = array_search($endTimes[$i], $validEndTimes);
            
            
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
        
        //OnSelect build new option list, stopping on BOOKED value or EO array
        
        ?>
        
        <script type='text/javascript'>
            function buildEndSelect(){
                //destroy select and rebuild
                
                var mySelect = document.getElementById("endSelect");
                var x = mySelect.length;
                for(var j=x; j>0; j--){
                    mySelect.remove(j);
                }
                
                
                var jsEndArrayValue= <?php echo json_encode($validEndTimes); ?>;
                var jsEndArrayDisplay= <?php echo json_encode($validDisplayEndTimes); ?>;
                
                var currentStartTime = document.getElementById("startSelect").value;
                
                var reachedEnd = 0;
                
                //rebuild select, only satrt once into valid time, end on booking or end of list
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
                
                //  https://stackoverflow.com/questions/17001961/javascript-add-select-programmatically


            }
        </script>
        
        <?php
        //using JSON to share array with JS
        
        echo'<p style="margin: 0 auto; text-align:center;">End Time:</p>
        <select required name="end" id="endSelect">
            
            <option value="" selected disabled hidden>Select Finish Time</option>';
            
        echo '</select>
        <button type="submit">Review</button>
        </form>
        </div>';
                    

    ?>

</main>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>
