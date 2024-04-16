<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/success_error.css?ver=<?php echo filemtime('../../css/success_error.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php include("../../src/includes/header.php"); ?>
    <?php include("../../src/includes/navigation.php"); ?>
    <main class="page-margin">
        <h1>Error Page</h1>
        <div>
            <?php
            if (isset($_GET['error'])) {
                $errorMessage = urldecode($_GET['error']);
                echo "<p>Error: $errorMessage</p>";
            } else {
                echo "<p>An error occurred.</p>";
            }
            ?>
            <div>
            <a href="Home.php">
                <button primary>Home Page</button>
            </a>
        </div>
        </div>
    </main>
    <?php include("../../src/includes/footer.html") ?>
</body>

</html>