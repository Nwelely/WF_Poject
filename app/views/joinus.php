<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/Plans-Style.css">
</head>

<body>
    <?php include('partials/Navigation-Index.php'); ?>

    <h2 id="title">Choose Your Plan</h2>

    <section class="plans-container">
        <div class="plan">
            <h2>Free Plan</h2>
            <p>$0/month</p>
            <ul>
                <li>No personalized trainer</li>
            </ul>
            <form action="../../app/views/Payment.php" method="POST">
                <input type="hidden" name="plan" value="Free Plan">
                <button type="submit" class="subscribebtn" id="subscribebtn1">Subscribe</button>
            </form>
        </div>

        <div class="plan">
            <h2>Standard Plan</h2>
            <p>$10/month</p>
            <ul>
                <li>Personalized trainer</li>
            </ul>
            <form action="../../app/views/Payment.php" method="POST">
                <input type="hidden" name="plan" value="Standard Plan">
                <button type="submit" class="subscribebtn" id="subscribebtn2">Subscribe</button>
            </form>
        </div>

        <div class="plan">
            <h2>Premium Plan</h2>
            <p>$20/month</p>
            <ul>
                <li>Personalized trainer with a health consultant </li>
            </ul>
            <form action="../../app/views/Payment.php" method="POST">
                <input type="hidden" name="plan" value="Premium Plan">
                <button type="submit" class="subscribebtn" id="subscribebtn3">Subscribe</button>
            </form>
        </div>
    </section>

    <script src="../../public/js/Plans-JavaScript.js"></script>
</body>

</html>
