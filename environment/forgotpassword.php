<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('fullHeader.php');?>
    </head>
    <body>
        <main>
            <form method="POST" action="updatePassword.php" >
                <label for="psw"><b>Reset Password</b></label>
                <br/>
                <?php
                    if(isset($_SESSION['user'])){
                        echo 'Password Reset for "'.$_SESSION['user'].'"';
                    }
                    else{
                        echo '
                        <br/>
                        <label for="email"><b>Enter Email Address</b></label>
                        <input type="email" placeholder="Enter Email" name="email" id="email" required>
                        ';
                        
                    }
                ?>
                <br/><br/>
                <label for="psw"><b>Enter New Password</b></label>
                <input id="updatepsw" type="password" placeholder="Enter Password" name="updatepsw"required>
                <input type="hidden" id="hiddenUpdatePass" name="hiddenUpdatePass"/>
                
                <button type="submit" class="signup" onclick="MyUpdateHash()" >Reset Password</button>
                
                <script src="javascript/sha256.js"></script>
                <script type="text/javascript">
                    function MyUpdateHash() {
                        var input = document.getElementById("updatepsw").value;
                        
                        var hash = SHA256.hash(input);
                        
                        document.getElementById("hiddenUpdatePass").value = hash;
                        
                    }
                </script>
            </form>
        </main>
    </body>
    
    <div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
    </div>

</html>