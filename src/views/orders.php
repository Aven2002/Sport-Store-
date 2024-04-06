<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successfully Placed!</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/orders.css?ver=<?php echo filemtime('../../css/orders.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php
    session_start();
    $orders = [];
    $UID = !isset($_SESSION["UID"]) ? null : $_SESSION["UID"];
    if (!$UID) {
        header("Location: index.php");
        exit();
    } else {
        include("../../database.php");
        try {
            $sql_orders = "SELECT * FROM orders WHERE userID = ?";
            $stmt_orders = mysqli_prepare($conn, $sql_orders);
            mysqli_stmt_bind_param($stmt_orders, "i", $UID);
            mysqli_stmt_execute($stmt_orders);
            $result_orders = mysqli_stmt_get_result($stmt_orders);

            while ($order = mysqli_fetch_assoc($result_orders)) {
                $orderID = $order['orderID'];
                $order['products'] = [];
                $sql_products = "SELECT * FROM order_product WHERE orderID = ?";
                $stmt_products = mysqli_prepare($conn, $sql_products);
                mysqli_stmt_bind_param($stmt_products, "i", $orderID);
                mysqli_stmt_execute($stmt_products);
                $result_products = mysqli_stmt_get_result($stmt_products);

                while ($product = mysqli_fetch_assoc($result_products)) {
                    $productID = $product['productID'];
                    $qty = $product['quantity'];
                    $sql_product_details = "SELECT * FROM product WHERE productID = ?";
                    $stmt_product_details = mysqli_prepare($conn, $sql_product_details);
                    mysqli_stmt_bind_param($stmt_product_details, "i", $productID);
                    mysqli_stmt_execute($stmt_product_details);
                    $result_product_details = mysqli_stmt_get_result($stmt_product_details);

                    $product_details = mysqli_fetch_assoc($result_product_details);
                    $product_details['quantity'] = $qty;
                    $order['products'][] = $product_details;
                    mysqli_stmt_close($stmt_product_details);
                }

                $orders[] = $order;

                mysqli_stmt_close($stmt_products);
            }
            mysqli_stmt_close($stmt_orders);
            mysqli_close($conn);
            echo "<script>console.log(" . json_encode($orders) . ");</script>";
        } catch (Exception $e) {
            echo '' . $e->getMessage() . '';
            $errorMessage = urlencode($e->getMessage());
            header("Location: errorPage.php?error=$errorMessage");
        }
    }
    ?>
    <?php include("../../src/includes/header.php"); ?>
    <?php include("../../src/includes/navigation.html"); ?>
    <main class="page-margin">
        <h1> Orders</h1>
        <?php foreach ($orders as $order) : ?>
            <div class="order-box">
                <div class="info">
                    <div>
                    <h3><strong>Order ID# <?php echo $order['orderID']; ?></strong></h3>
                    <p>Date: <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                    </div>
                    <p>Total Price: RM <?php echo number_format($order['totalPrice'], 2, ".", ""); ?></p>
                </div>


                <table width="100%">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['products'] as $product) : ?>
                            <tr>
                                <td class="product-name"><?php echo $product['productName']; ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td>RM <?php echo number_format($product['productPrice'], 2, ".", ""); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <hr>
        <?php endforeach; ?>
    </main>
    <?php include("../../src/includes/footer.html") ?>
</body>

</html>