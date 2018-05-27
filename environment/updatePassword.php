<?php
    session_start();
    
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
    
    
    $tableName = 'Users';
    
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
    }
    else {
        $username = $_POST['email'];
    }
    
    $key = $marshaler->marshalJson('
    {
        "email": "' . $username . '"
    }
    ');
    
    
    
    $eav = $marshaler->marshalJson('
        {
            ":pass": "'.$_POST['hiddenUpdatePass'].'" 
        }
    ');
    
    
    
    
    $params = [
        'TableName' => $tableName,
        'Key' => $key,
        'UpdateExpression' => 'set password = :pass',
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
    ];
    
    
    
    try {
        $result = $dynamodb->updateItem($params);
        
        echo "<script type=\"text/javascript\">alert(\"Update Successful\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
        
    } catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }
    

?>
