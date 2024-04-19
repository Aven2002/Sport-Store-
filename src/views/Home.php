<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/Home.css?ver=<?php echo filemtime('../../css/Home.css'); ?>">
    <script src="../../js/Home.js"></script>
</head>
<?php
session_start();
if (isset($_SESSION['UID']) && isset($_POST['addToCart'])) {
    include("../../database.php");

    try {
        $UID = $_SESSION["UID"];
        $productID = $_POST['productID'];
        $quantity = 1;

        $sql_check = "SELECT quantity FROM cart WHERE userID = ? AND productID = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ii", $UID, $productID);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            mysqli_stmt_bind_result($stmt_check, $oriQty);
            mysqli_stmt_fetch($stmt_check);
            $newQty = $oriQty + $quantity;
            mysqli_stmt_close($stmt_check);

            $sql_update = "UPDATE cart SET quantity = ? WHERE userID = ? AND productID = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "iii", $newQty, $UID, $productID);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);
        } else {
            mysqli_stmt_close($stmt_check); 

            $sql_insert = "INSERT INTO cart (userID, productID, quantity) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt, "iii", $UID, $productID, $quantity);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    } catch (Exception $e) {
        echo '' . $e->getMessage() . '';
        $errorMessage = urlencode($e->getMessage());
        header("Location: ../views/errorPage.php?error=$errorMessage");
        exit();
    }
    mysqli_close($conn);
    echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
    exit();
}
?>

<body>
    <?php include("../includes/header.php"); ?>
        <?php include("../includes/navigation.php"); ?>
    <main>
        <div class="carousel">
            <div class="carousel-items">
                <img src="../../assets/img/carousel/carousel_1.jpg" alt="Slide 1">
                <img src="../../assets/img/carousel/carousel_2.jpg" alt="Slide 2">
                <img src="../../assets/img/carousel/carousel_3.jpg" alt="Slide 3">
                <img src="../../assets/img/carousel/carousel_4.jpg" alt="Slide 4">
                <img src="../../assets/img/carousel/carousel_5.jpg" alt="Slide 5">
                <img src="../../assets/img/carousel/carousel_6.jpg" alt="Slide 6">
                <img src="../../assets/img/carousel/carousel_7.jpg" alt="Slide 7">
            </div>
            <button class="prev-btn">&#10094;</button>
            <button class="next-btn">&#10095;</button>
        </div>

        <hr>

        <div class="product-grid">
            <?php
            // Include the database connection
            include("../../database.php");

            // Retrieve random product data from the database
            $sql = "SELECT * FROM product ORDER BY RAND() LIMIT 6";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-card' onclick='route(".$row["productID"].")'>";
                    echo "<div class='card-front'>";
                    echo "<img class='product-image' src='" . $row["productImagePath"] . "' alt='" . $row["productName"] . "'/>";
                    echo "</div>";
                    echo "<div class='card-back'>";
                    echo "<h2 class='product-name'>" . $row["productName"] . "</h2>";
                    echo "<p class='product-price'>$" . $row["productPrice"] . "</p>";
                    // Add to Cart button
                    if(isset($_SESSION['UID'])){
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='productID' value='" . $row["productID"] . "'>";
                        echo "<button type='submit' secondary name='addToCart'>Add to Cart</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No products found.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </main>

    <?php include("../includes/footer.html"); ?>
</body>
<script>
    const route = (id) => {
        window.location.href = `ItemDetails?id=${id}`
    };
</script>
</html>