<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<html lang="en">

<head>
   <?php include('fullHeader.php');?>
</head>



<body>


    <main>
        <h2>FAQ</h2>
        <div class="faq-content">
            <button class="accordion">What is RideOn Car Sharing Services?</button>
            <div class="panel">
                RideOn is operated by CarShare Australia, formed to bring car sharing services to Australia. Founded in 2018, the company has developed a range of business and IT systems that enable the delivery of consulting, technical services and the provision of
                on-the-ground car share facilities
            </div>

            <button class="accordion">How does RideOn work?</button>
            <div class="panel">
                As a member, you will be able to locate nearby available cars, book it according to car types, date, time and location.
            </div>

            <button class="accordion">How can I book a car?</button>
            <div class="panel">
                To book a car, you need to become a member by <a id='faq' href="register.php">creating an account</a> with us.
            </div>

            <button class="accordion">How much does it cost?</button>
            <div class="panel">
                Please refer to <a id='faq' href='pricing.php'>Pricing</a> page for our rates.
            </div>
            <button class="accordion">What type of cars do you offer?</button>
            <div class="panel">
                We have various of car types to choose from. Please refer to <a id='faq' href='cars.php'>Cars</a> page to check out our cars.
            </div>

        </div>

        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].onclick = function() {
                    this.classList.toggle("active");
                    this.nextElementSibling.classList.toggle("show");
                }
            }
        </script>

    </main>

</body>


<div id="footer" class="main_footer_navigation">
    <?php include 'footermenu.php'; ?>
</div>


</html>
