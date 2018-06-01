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
    
    
    $tableName = 'Users';
    
    $key = $marshaler->marshalJson('
    {
        "email": "' . $_SESSION['user'] . '"
    }
    ');
    
    
    
    $eav = $marshaler->marshalJson('
        {
            ":name": "'.$_POST['updateName'].'" 
        }
    ');
    
    
    
    
    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' => 'set #nm = :name',
        'ExpressionAttributeNames'=>['#nm' => 'name'],
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];
    
    
    
    try {
        $result = $dynamodb->updateItem($params);
        
        $_SESSION['userName'] = $_POST['updateName'];
        echo "<script type=\"text/javascript\">alert(\"Update Successful\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='account.php'\" />";
        
    } catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }
    
    
?>