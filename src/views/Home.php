<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../../css/Home.css?ver=<?php echo filemtime('../../css/Home.css'); ?>">
    <script src="../../js/Home.js"></script>
</head>
<body>
    <?php include("../includes/header.php");?>
    <nav>
        <?php include("../includes/navigation.html");?>
    </nav>
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
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='product-card'>";
                        echo "<div class='card-front'>";
                        echo "<img class='product-image' src='" . $row["productImagePath"] . "' alt='" . $row["productName"] . "'/>";
                        echo "</div>";
                        echo "<div class='card-back'>";
                        echo "<h2 class='product-name'>" . $row["productName"] . "</h2>";
                        echo "<p class='product-price'>$" . $row["productPrice"] . "</p>";
                        // Add to Cart button
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='productName' value='" . $row["productName"] . "'>";
                        echo "<input type='hidden' name='productPrice' value='" . $row["productPrice"] . "'>";
                        echo "<button type='submit' secondary >Add to Cart</button>";
                        echo "</form>";
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

    <?php include("../includes/footer.html");?>
</body>
</html>
