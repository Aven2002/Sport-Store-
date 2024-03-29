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
    <a href="javascript:history.go(-1);" class="back-btn">
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
include("../../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
?>
        <script>alert("Please enter your username.");</script>
<?php
    } elseif (empty($_POST["password"])) {
?>
        <script>alert("Please enter your password.");</script>
<?php
    } else {
        // Process form submission
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO user_account (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        mysqli_stmt_execute($stmt);

        // Check if user account was created successfully
        if (mysqli_stmt_affected_rows($stmt) > 0) {
?>
            <script>alert("User account created successfully.");</script>
<?php
        } else {
?>
            <script>alert("Error creating user account.");</script>
<?php
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

