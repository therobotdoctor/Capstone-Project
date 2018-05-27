
<?php   
echo '
    <div id="id02" class="modal">
    <span onclick="document.getElementById(\'id02\').style.display=\'none\'" class="close" title="Close Modal">X</span>
    <form method="POST" class="modal-content" action="LoginComplete.php">
        <div class="container">
            <h1 align=\'center\'>Sign In</h1>
            <hr>
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="emailSignIn" id="emailSignIn" required>
            <br>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pswSignIn" id="pswSignIn" required>
            <input type="hidden" id="hiddenPassSignIn" name="hiddenPassSignIn"/>
                

            <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                </label>

            <p align="center" style="font-size:15px">Forgot<a href="forgotpassword.php" style="color:dodgerblue"> Password?</a></p>
            <hr>
            <div class="clearfix">
                <button type="submit" class="signin" name="submit" onclick="Myhash()">Submit</button>
                <button type="button" onclick="document.getElementById(\'id02\').style.display=\'none\'" class="\'cancelbtn\'">Cancel</button>
            </div>
        </div>
    </form>
    
    <script src="javascript/sha256.js"></script>
    <script type="text/javascript">
            function Myhash() {
                var input = document.getElementById("pswSignIn").value;
                
                var hash = SHA256.hash(input);
                
                document.getElementById("hiddenPassSignIn").value = hash;
            }
    </script>
    </div>
    '
    ?>
