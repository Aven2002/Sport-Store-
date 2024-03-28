<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        function validation($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username = validation($_POST['username']);
        $password = validation($_POST['password']);

        if (empty($username)) {
            header("Location: index.php?error=Username is required");
            exit();
        } elseif (empty($password)) {
            header("Location: index.php?error=Password is required");
            exit();
        } else {
            echo "Valid Input";
            // Add your login logic here
        }
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/Sport-Store-/css/styles.css"; />
    <link rel="stylesheet" href="/Sport-Store-/css/Login.css"; />
</head>

<body>
    <form action="Login.php" method="post">
        <h2>LOGIN</h2>
        <label>Username:</label>
        <input type="text" name="username" placeholder="username" /><br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="password" /><br>

        <button type="reset">Reset</button>
        <button type="submit">Login</button>
    </form>
</body>

</html>
