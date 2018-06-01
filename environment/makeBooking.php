<?php  
    session_start();
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
    
        
    $item = $marshaler->marshalJson('
    {
      "carID": "' . $_SESSION['bookingDetails'][0] . '",
      "dateTime": "' . $_SESSION['bookingDetails'][1]. $_SESSION['bookingDetails'][2] . $_SESSION['bookingDetails'][3] . '",
      "Date": "' . $_SESSION['bookingDetails'][1]. '",
      "StartTime": "' . $_SESSION['bookingDetails'][2] . '",
      "EndTime": "' . $_SESSION['bookingDetails'][3] . '",
      "User": "' . $_SESSION['user'] . '"
    }
    ');
    
    
  
    $params = [
        'TableName' => $tableName,
        'Item' => $item
    ];
    
    
    try {
        
        $result = $dynamodb->putItem($params);
        
        echo "<script type=\"text/javascript\">alert(\"Booking Successful.\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='account.php'\" />";
        
    } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
    
?>