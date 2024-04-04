<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/Sport-Store-/css/Login.css">
    <link rel="stylesheet" href="/Sport-Store-/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <form action="Login.php" method="post">
        <a href="../../index.php" class="back-btn">
            <i class="fas fa-angle-double-left"></i>
        </a>
        <h2>LOGIN</h2>
        <label>Username:</label>
        <input type="text" name="username" placeholder="username" /><br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="password" /><br>
        <div class="button-container">
            <button type="reset">Reset</button>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>

<?php
// Include database connection file
include("../../database.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if both username and password are provided
    if (!empty($username) && !empty($password)) {
        // Query to retrieve hashed password from the database
        $sql = "SELECT userID, password FROM user_account WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Check if user exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $UID ,$hashed_password);
            mysqli_stmt_fetch($stmt);

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, redirect to authenticated page
                session_start([
                    'cookie_lifetime' => 86400,
                ]);
                $_SESSION["UID"]  = $UID;
                header("Location: Home.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('User does not exist.');</script>";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Username or password is empty, display alert
        echo '<script>alert("Kindly fill up all the information.");</script>';
        echo '<script>history.go(-1);</script>';
    }

    // Close connection
    mysqli_close($conn);
}
?>



