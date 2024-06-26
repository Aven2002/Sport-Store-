<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="../../css/styles.css";/>
    <link rel="stylesheet" href="../../css/index.css?ver=<?php echo filemtime('../../css/index.css'); ?>">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $UID = !isset($_SESSION["UID"]) ? null : $_SESSION["UID"];
  if (!empty($UID)) {
    header("Location: ../views/Home.php");
  }
?>
<body>
    <?php include("../includes/header.php"); ?>
    <main>
        <h2>Experience the Excellence of Sport Store Web</h2>
        <p>
            Experience the Convenience, Reliability, and Versatility of Our Platform. 
            Whether browsing through various product options or staying updated on the latest trends, enhance your shopping experience.
        </p>
        <ul>
            <li>🌐 Seamless Product Exploration</li>
            <li>⏱️ Personalized Product Recommendations</li>
            <li>💼 Extensive Product Catalog</li>
            <li>🌍 Simplify Your Decision-making Process</li>
        </ul>

        <div id="button">
            <a href="Login.php"><button primary>Login</button></a>
            <a href="SignUp.php"><button secondary>Sign up</button></a>
        </div>
        <img id="sport-image" src="../../assets/img/Sport.png" alt="Sport Image"/>
    </main>    
    <?php include("../includes/footer.html")?>
</body>
</html>
