<?php
    // The Modal (contains the Sign Up form)
    echo '    
        <div id="id01" class="modal">
        <span onclick="document.getElementById(\'id01\').style.display=\'none\'" class="close" title="Close Modal">X</span>
        <form method="POST" class="modal-content" action="RegisterComplete.php">
            <div class="signupcontainer">
                <h1 align=\'center\'>Sign Up</h1>
                <p align=\'center\'>Please fill in this form to create an account.</p>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>

                <label for="psw"><b>Password</b></label>
                <input id="psw" type="password" placeholder="Enter Password" name="psw"required>
                <input type="hidden" id="hiddenPass" name="hiddenPass"/>
                <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

                <p style="font-size:12px">By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                <div class="clearfix">
                    <button type="submit" class="signup" onclick="MyRegisterHash()" >Sign Up</button>
                    <button type="button" onclick="document.getElementById(\'id01\').style.display=\'none\'" class="cancelbtn">Cancel</button>
                </div>
            </div>
        </form>
        
        <script src="javascript/sha256.js"></script>
        <script type="text/javascript">
                function MyRegisterHash() {
                    
                    var input = document.getElementById("psw").value;
                    
                    var hash = SHA256.hash(input);
                    
                    document.getElementById("hiddenPass").value = hash;
                    
                }
        </script>
        </div>
        '
?>
