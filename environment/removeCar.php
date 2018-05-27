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
    
    $CarToRemove = $_POST['CarToRemove'];
    //echo $userToRemove;
    //echo "test";
    //die();
    $tableName = 'Cars';
    
    $key = $marshaler->marshalJson('
        {
            "CarID": "'.$CarToRemove.'"
        }
    ');
    
    $eav = $marshaler->marshalJson('
    {
        ":car": "'.$CarToRemove.'" 
    }
');
    
    $params = [
        'TableName' => $tableName,
        'KeyConditionExpression' => 'CarID = :car',
        'ExpressionAttributeValues'=> $eav
    ];
    
    try {
        // scan for item first, if found remove otherwise display error
        
        $result = $dynamodb->query($params);
          
        
        if($result['Count'] *1 == 1){
            $params = [
                'TableName' => $tableName,
                'Key' => $key,
                'ConditionExpression' => 'CarID = :car',
                'ExpressionAttributeValues'=> $eav
            ];
            $result = $dynamodb->deleteItem($params);
        
            echo "<script type=\"text/javascript\">alert(\"Car Removed\")</script>";
            echo "<meta http-equiv=\"refresh\" content=\"0; URL='adminAccount.php'\" />";
        }
        else{
            echo "<script type=\"text/javascript\">alert(\"Car Doesn't Exist\")</script>";
            echo "<meta http-equiv=\"refresh\" content=\"0; URL='adminAccount.php'\" />";
        }
        
    }
    catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }

?>
