<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: Login-index.php"); // Redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../../public/css/Payment-Style.css">
</head>
<body>
    <?php include('partials/Navigation-Index.php'); ?>

    <div class="container">
        <div class="card-container">
            <div class="front">
                <div class="image">
                    <img src="/images/chip.png" alt="">
                    <img src="/images/visa.png" alt="">
                </div>
                <div class="card-number-box">################</div>
                <div class="flexbox">
                    <div class="box">
                        <span>card holder</span>
                        <div class="card-holder-name">full name</div>
                    </div>
                    <div class="box">
                        <span>expires</span>
                        <div class="expiration">
                            <span class="exp-month">mm</span>
                            <span class="exp-year">yy</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"></div>
                    <img src="/images/visa.png" alt="">
                </div>
            </div>
        </div>

        <form action="../../app/Controllers/paymentcontroller.php" method="POST" onsubmit="return validateCreditCard()">
            <?php if (!empty($cards)) { ?>
                <div class="inputBox">
                    <span>Select an existing card or add a new card</span>
                    <select name="selectedCard" class="card-select-input" onchange="toggleNewCardInputs(this)">
                        <option value="new">Add a new card</option>
                        <?php foreach ($cards as $card) { 
                            list($expMonth, $expYear) = explode('/', $card['expiredate']);
                            $isExpired = new DateTime("$expYear-$expMonth-01") < new DateTime(); 
                        ?>
                            <option value="<?= htmlspecialchars($card['_id']) ?>" 
                                <?= $isExpired ? 'class="expired" disabled' : '' ?>>
                                <?= htmlspecialchars($card['maskedNumber']) ?> (expires: <?= htmlspecialchars($card['expiredate']) ?>) 
                                <?= $isExpired ? ' - expired' : '' ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="inputBox">
                <span>card number</span>
                <input type="text" name="frontcardnumber" maxlength="16" class="card-number-input">
            </div> 
            <div class="inputBox">
                <span>card holder</span>
                <input type="text" name="cardholdername" class="card-holder-input">
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span>expiration mm</span>
                    <select name="expiremonth" class="month-input" id="month-input">
                        <option value="month" selected disabled>month</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>expiration yy</span>
                    <select name="expireyear" class="year-input" id="year-input">
                        <option value="year" selected disabled>year</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>cvv</span>
                    <input type="text" name="cvv" maxlength="4" class="cvv-input">
                </div>
            </div>
            <input type="submit" value="Pay" class="pay-btn">
        </form>
    </div>

    <script src="../../public/js/Payment-JavaScript.js"></script>
</body>
</html>
