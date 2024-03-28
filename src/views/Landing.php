<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <style>
         body {
            position: relative;
            min-height: 100vh;

            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
        }
        main {
            padding: 50px; 
        }

        p {
            color: #666; 
            margin-bottom: 20px;
        }

        li {
            list-style-type: none; 
            margin-bottom: 10px; 
        }
        button {
            background-color: #99CCFF; 
            color: #202020; 
            font-weight: bold;
            padding: 12px 30px; 
            margin: 0 10px; 
            cursor: pointer; 
            border-radius: 10px; 
        }
        button:hover {
            background-color: #00cccc; 
        }
        #button{
            margin-left:100px;
        }
        #sport-image {
            position: absolute;
            bottom: 60px; 
            right: 0;
            width: 45%; 
            height: auto; 
        }
        @media screen and (max-width: 600px) {
        #sport-image {
            position: relative; 
            width: 80%;
            height: auto;
        text-align:center;
            margin:50px;
        }
        #button {
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <?php include("../includes/header.html"); ?>
    
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
    </main>
        <div id="button">
            <a href="Login.html"><button>Login</button></a>
            <a href="SignUp.html"><button>Sign up</button></a>
        </div>

     <img id="sport-image" src="/Sport-Store-/assets/img/Sport.png" alt="Sport Image"/>
    
    <?php include("../includes/footer.html")?>
</body>
</html>
