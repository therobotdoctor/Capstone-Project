<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<body>
  <?php
      require 'aws/aws.phar';
    
      //putenv("AWS_ACCESS_KEY_ID=AKIAIAGHSUW7LN42DWBQ");
      //putenv("AWS_SECRET_ACCESS_KEY=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");
      
      
      $email = $_POST['emailSignIn'];
      $password = $_POST['hiddenPassSignIn'];
      
      
      //$hash = password_hash($password, PASSWORD_DEFAULT);
      
      //$file = fopen('users.txt', "r");
      
      $same = 0;
      
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
  
      //echo "<br/><br/>".$result."<br/>Query succeeded.\n";
      //echo "-------------".$result['Count'];
      if($result['Count'] *1 >= 1){
        $same = 1;
      }
  
    } catch (DynamoDbException $e) {
        echo "Unable to query:\n";
        echo $e->getMessage() . "\n";
    }
    
    if($same == 1){
      if(strcmp(strtolower($email), "admin@admin") != 0){
        $_SESSION['user'] = $result['Items'][0]['email'][S];
        $_SESSION['userName'] = $result['Items'][0]['name'][S];
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

      /*
      foreach (file('users.txt') as $line) 
      {
        list($user,$pw) = explode(",",$line);
        $pw = trim($pw);


        if ($email == $user && $hash == $pw) 
        {
          $same = 1;
          break;
        }
      }

      if ($same == 1) 
      {
        echo "You are logged in. Welcome";
        fclose($file);
      }

      else
      {
        echo "Wrong Username/Password";
        fclose($file);
      }
      */
    
  /*
    $file = fopen('users.txt', "a+");
    $same = 0;

    foreach (file('users.txt') as $line) 
    {
      list($user,$pw) = explode(",",$line);
      $pw = trim($pw);


      if ($email == $user && $password == $pw) 
      {
        $same = 1;
        break;
      }
    }

    if ($same == 1) 
    {
      echo "You are logged in. Welcome";
      fclose($file);
    }

    else
    {

      echo "Wrong Username/Password";
      fclose($file);
    }
    */
    ?>
</body>
</html>