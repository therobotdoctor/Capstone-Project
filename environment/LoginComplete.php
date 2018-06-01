<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<body>
  <?php
      require 'aws/aws.phar';
    
      
      $email = $_POST['emailSignIn'];
      $password = $_POST['hiddenPassSignIn'];
      
      
      $same = 0;
      
      date_default_timezone_set('UTC');
  
      use Aws\DynamoDb\Exception\DynamoDbException;
      use Aws\DynamoDb\Marshaler;
      
      $sdk = new Aws\Sdk([
          'profile' => 'default',
          'region'   => 'us-west-2',
          'version'  => 'latest',
      ]);

      
      
    $dynamodb = $sdk->createDynamoDb();
    $marshaler = new Marshaler();
    
    $tableName = 'Users';
    
    $eav = $marshaler->marshalJson('
        {
            ":email": "'.$email.'",
            ":password": "'.$password.'"
        }
    ');
    
    $params = [
        'TableName' => $tableName,
        'ProjectionExpression' => 'email, password, #nm',
        'KeyConditionExpression' => 'email = :email',
        'ExpressionAttributeNames'=>['#nm' => 'name'],
        'FilterExpression' => 'password = :password',
        'ExpressionAttributeValues'=> $eav
    ];
    
    try {
      $result = $dynamodb->query($params);
  
      if($result['Count'] *1 >= 1){
        $same = 1;
      }
  
    } catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }
    
    if($same == 1){
      if(strcmp(strtolower($email), "admin@admin") != 0){
        $_SESSION['user'] = $result['Items'][0]['email']['S'];
        $_SESSION['userName'] = $result['Items'][0]['name']['S'];
        $_SESSION['admin'] = false;
        echo "<script type=\"text/javascript\">alert(\"Log In Successful\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='account.php'\" />";

      }
      else{
        echo "<script type=\"text/javascript\">alert(\"Log In Successful\")</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0; URL='adminAccount.php'\" />";
        $_SESSION['user'] = $email;
        $_SESSION['admin'] = true;
      }
    }
    else{
      
      echo "<script type=\"text/javascript\">alert(\"Log In Fail\")</script>";
      echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
    }

      
    ?>
</body>
</html>