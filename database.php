<?php
// Database connection parameters
$db_server = "localhost"; 
$db_user = "root"; 
$db_password = ""; 
$db_name = "Sport_Store"; 

try {
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

    if (!$conn) {
        throw new Exception("Failed to connect to database: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
