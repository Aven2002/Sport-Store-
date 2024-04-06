<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successfully Placed!</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/success_error.css?ver=<?php echo filemtime('../../css/success_error.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION["UID"]) || !isset($_SESSION["SuccessOrder"])) {
        header("Location: index.php");
    }
    if (isset($_SESSION["SuccessOrder"])){
        unset($_SESSION['SuccessOrder']);
    }
    ?>
    <?php include("../../src/includes/header.php"); ?>
    <?php include("../../src/includes/navigation.html"); ?>
    <main class="page-margin">
        <h1>Order Successfully Placed!</h1>
        <p>Thank you for your order. Your order has been successfully placed.</p>
        <div>
            <a href="orders.php">
                <button secondary>View Your Orders</button>
            </a>
            <a href="ItemList.php">
                <button primary>Continue Shopping</button>
            </a>
        </div>
    </main>
    <?php include("../../src/includes/footer.html") ?>
</body>

</html>