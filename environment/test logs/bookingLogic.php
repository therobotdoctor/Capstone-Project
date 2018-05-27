<?php

    require 'aws/aws.phar';
    
    putenv("AWS_ACCESS_KEY_ID=AKIAIAGHSUW7LN42DWBQ");
    putenv("AWS_SECRET_ACCESS_KEY=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");
    
    
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
    
    $tableName = 'Bookings';
    
    $carId = $_POST['carid'];
    
    $eav = $marshaler->marshalJson('
        {
            ":CarID: "'.$carId.'"
        }
    ');
    
    $params = [
        'TableName' => $tableName,
        'ProjectionExpression' => 'CarId, Date, FinishTime, StartTime, UserId',
        'FilterExpression' => 'CardId = :CarID',
        'ExpressionAttributeValues'=> $eav
    ];
    
    try {
        $result = $dynamodb->scan($params);
        
        while(true){
            foreach($result['Items'] as $i){
                $book = $marsheller->unmarshalItem($i);
                
                echo $book['Date']; //find date
                echo $book['StartTime']; 
                echo $book['EndTime'];
                
                
            }
            
            
            
            
            if (isset($result['LastEvaluatedKey'])) {
                $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
            } else {
                break;
            }
        }
        
        
        /*
        Booking key id should be carID
        scan based i car
        
        get time and dates
        
        find date and time turn off selection
        
        mark which are valid
        
        then need to actually book!
        */
    }
    catch(DynamoDbException $e){
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
        
    }
  
?>