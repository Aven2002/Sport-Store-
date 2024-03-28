<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/Sport-Store-/css/Login.css">
    <link rel="stylesheet" href="/Sport-Store-/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <a href="../../index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
</body>
</html>



<?php
    include("../../database.php");
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty($_POST["username"]) || empty($_POST["password"])) {
            echo "Both username and password are required.";
        } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Statements
        $sql = "INSERT INTO user_account (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters 
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        mysqli_stmt_execute($stmt);

        // Validation
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo "User account created successfully.";
        } else {
            echo "Error creating user account: " . mysqli_error($conn);
        }

        // Close connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
} else {
    echo "Invalid request method.";
}
?>


