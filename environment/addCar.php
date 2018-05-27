<?php
    session_start(); 
    
    //start DB connection
    require 'aws/aws.phar';
    
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
    
    $tableName = "Cars";
    
    
    
    $CarMake = $_POST['CarMake'];
    $CarModel = $_POST['CarModel'];
    $CarColour = $_POST['CarColour'];
    $CarType = $_POST['typeSelect'];
    $CarLat = $_POST['CarLat'];
    $CarLong = $_POST['CarLong'];
    
    
    $key = $marshaler->marshalJson('
        {
            "CarID": "CarIDReference" 
        }
    ');
    
    
    $eav = $marshaler->marshalJson('
        {
            ":val": 1
        }
    ');
    
    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' => 'set IDRef = IDRef + :val',
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];
    
    try {
        $result = $dynamodb->updateItem($params);
        $idRef = ($result['Attributes']['IDRef'][N]);
        
    } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
    
    $CarID = "Car".$idRef;
    
   
    $item = $marshaler->marshalJson('
    {
      "CarID": "' . $CarID . '",
      "Colour": "' . $CarColour . '",
      "Lat": "' . $CarLat . '",
      "Long": "' . $CarLong . '",
      "Make": "' . $CarMake . '",
      "Model": "' . $CarModel . '",
      "Type": "' . $CarType . '"
    }
    ');
    
    
  
    $params = [
        'TableName' => $tableName,
        'Item' => $item
    ];
    
    
    try {
        
        $result = $dynamodb->putItem($params);
        
    } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
    
    echo "<script type=\"text/javascript\">alert(\"Car Registered.\")</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0; URL='adminAccount.php'\" />";
    
?>
