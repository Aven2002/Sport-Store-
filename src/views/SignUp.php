<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="../../css/SignUp.css?ver=<?php echo filemtime('../../css/SignUp.css'); ?>">
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <form id="signupForm" action="SignUp.php" method="post">
        <a href="index.php" class="back-btn">
        <i class="fas fa-angle-double-left"></i>
        </a>
        <h2>Register Account</h2>
        <hr> <br>
        <div class="section-left">
            <h3>Personal Information:</h3>
            <label>Full name:</label>
            <input type="text" name="fullName" placeholder="Full Name"/><br>
            <label>Email:</label>
            <input type="email" name="email" placeholder="sample_email@outlook.com"/><br>
            <label>Contact Number:</label>
            <input type="tel" name="contactNum" placeholder="xxx-xxx-xxxx"/><br>
            <label>Home Address:</label>
            <input type="text" name="address" placeholder="Address"/><br>
        </div>
        <div class="section-right">
            <h3>Account Information:</h3>  
            <label>Username:</label>
            <input type="text" name="username" placeholder="Username"/><br>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Password"/><br>
        </div>
        <div class="button-container">
            <button type="reset" primary value="cancel">Reset</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>

<?php
// Obtain Connection
include("../../database.php");

// Call Method & Validate input
if($_SERVER["REQUEST_METHOD"]=="POST") 
{
    // Check if all fields are set and not empty
    if(!empty($_POST["username"]) && !empty($_POST["password"]) &&
    !empty($_POST["fullName"]) && !empty($_POST["email"]) &&
    !empty($_POST["contactNum"]) && !empty($_POST["address"])) 
    {
        // Process form submission
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $fullName = mysqli_real_escape_string($conn, $_POST["fullName"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $contactNum = mysqli_real_escape_string($conn, $_POST["contactNum"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO user_account (username, password, fullName, email, contactNum, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $hashed_password, $fullName, $email, $contactNum, $address);
        mysqli_stmt_execute($stmt);

        // Check if user account was created successfully
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<script>alert("User account created successfully.");</script>';
            echo '<script>window.location.href = "../../index.php";</script>'; 
            exit();
        } else {
            echo '<script>alert("Error creating user account.");</script>';
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        echo '<script>alert("Kindly fill up all the information.");</script>';
        echo '<script>history.go(-1);</script>';
    }
}
?>



