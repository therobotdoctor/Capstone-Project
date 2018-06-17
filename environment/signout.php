<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    
    echo "<script type=\"text/javascript\">alert(\"Successfully Logged Out\")</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0; URL='index.php'\" />";
?>