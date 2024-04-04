<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="/Sport-Store-/css/styles.css";/>
    <link rel="stylesheet" href="css/Landing.css?ver=<?php echo filemtime('css/Landing.css'); ?>">
    <link rel="stylesheet" href="css/footer.css?ver=<?php echo filemtime('css/footer.css'); ?>">
</head>
<body>
    <?php include("./src/includes/header.html"); ?>
    <?php include("./src/includes/navigation.html");?>
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
            <a href="src/views/Login.php"><button primary>Login</button></a>
            <a href="src/views/SignUp.php"><button secondary>Sign up</button></a>
        </div>
        <img id="sport-image" src="/Sport-Store-/assets/img/Sport.png" alt="Sport Image"/>
    </main>    
    <?php include("./src/includes/footer.html")?>
</body>
</html>
