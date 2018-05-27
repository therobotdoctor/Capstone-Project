<?php  
    session_start();
    
    require 'aws/aws.phar';
    
    
    $email = $_POST['email'];
    $password = $_POST['hiddenPass'];
  
    $exist = 0;
      
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
      
      
    $tableName = 'Users';
    
    $eav = $marshaler->marshalJson('
        {
            ":email": "'.$email.'" 
        }
    ');
    
    
    $params = [
        'TableName' => $tableName,
        'KeyConditionExpression' => 'email = :email',
        'ExpressionAttributeValues'=> $eav
    ];
    
      
    
    try {
      $result = $dynamodb->query($params);
  
      
      if($result['Count'] *1 == 1){
        $exist = 1;
      }
  
    } catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }
   
      if ($exist == 1) 
      {
        echo "<script type=\"text/javascript\">alert(\"Registration Fail: User already exists\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
      }
      else
      {
        
        $item = $marshaler->marshalJson('
        {
          "email": "' . $email . '",
          "password": "' . $password . '"
        }
        ');
        
        
      
        $params = [
            'TableName' => 'Users',
            'Item' => $item
        ];
        
        
        try {
            
            $result = $dynamodb->putItem($params);
            
        } catch (DynamoDbException $e) {
            echo "Unable to add item:\n";
            echo $e->getMessage() . "\n";
        }
        
        echo "<script type=\"text/javascript\">alert(\"Registration Successful. Log in from home page\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
      }
   
   
  ?>
  
</body>
</html>