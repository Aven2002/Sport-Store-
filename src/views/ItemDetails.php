<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Products</title>
	<link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
	<link rel="stylesheet" href="../../css/dialog.css?ver=<?php echo filemtime('../../css/dialog.css'); ?>">
	<link rel="stylesheet" href="../../css/itemDetails.css?ver=<?php echo filemtime('../../css/itemDetails.css'); ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<?php
session_start();
include("../../database.php");
$UID = null;
if (isset($_SESSION["UID"])) {
	$UID = $_SESSION["UID"];
}
$product = null;
$quantity = 1;
$quantityErr = "";
$requstURI = $_SERVER['REQUEST_URI'];
$PID = isset($_GET['id']) ? trim($_GET['id']) : null;
if (!empty($PID) && is_numeric(trim($_GET['id']))) {
	$sql = "SELECT * FROM product WHERE productID = $PID";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$product = mysqli_fetch_array($result);
		echo "<script>console.log(" . json_encode($product) . ")</script>";
	}
	mysqli_free_result($result);
	mysqli_close($conn);
}

if (!empty($UID) && !empty($PID) && $_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<script>console.log(1111 )</script>";
	if (!is_numeric($quantity)) {
		$quantityErr = "Invalid Number";
	} else {
		include("../../database.php");
		$sql_check = "SELECT quantity FROM cart WHERE userID = ? AND productID = ?";
		$stmt_check = mysqli_prepare($conn, $sql_check);
		mysqli_stmt_bind_param($stmt_check, "ii", $UID, $PID);
		if (!mysqli_stmt_execute($stmt_check)) {
			echo "Error updating quantity: " . mysqli_error($conn);
			mysqli_close($conn);
			exit();
		}
		mysqli_stmt_store_result($stmt_check);
		$num_rows = mysqli_stmt_num_rows($stmt_check);

		if ($num_rows > 0) {
			$oriQty  = 0;
			mysqli_stmt_bind_result($stmt_check, $qty);
			while (mysqli_stmt_fetch($stmt_check)) {
				$oriQty  = $qty;
			}
			$newQty = $oriQty + $quantity;
			echo "<script>console.log(" . $newQty . "" . $quantity . " )</script>";
			$sql_update = "UPDATE cart SET quantity = ? WHERE userID = ? AND productID = ?";
			$stmt_update = mysqli_prepare($conn, $sql_update);
			mysqli_stmt_bind_param($stmt_update, "iii", $newQty, $UID, $PID);
			if (mysqli_stmt_execute($stmt_update)) {
				echo "<script>window.location.href = '" . $requstURI . "';</script>";
			} else {
				echo "Error updating quantity: " . mysqli_error($conn);
			}
			mysqli_stmt_close($stmt_update);
		} else {
			$sql_insert = "INSERT INTO cart (userID, productID, quantity) VALUES (?, ?, ?)";
			$stmt = mysqli_prepare($conn, $sql_insert);
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "iii", $UID, $PID, $quantity);
				if (!mysqli_stmt_execute($stmt)) {
					echo "Error: " . mysqli_error($conn);
				} else {
					echo "<script>window.location.href = '" . $requstURI . "';</script>";
				}
				mysqli_stmt_close($stmt);
			} else {
				echo "Error: " . mysqli_error($conn);
			}
		}
		mysqli_close($conn);
		exit();
	}
} elseif (empty($UID) && $_SERVER["REQUEST_METHOD"] == "POST") {
	header("Location: Login.php");
}
?>

<body>
	<?php include("../../src/includes/header.php"); ?>
	<?php include("../../src/includes/navigation.html"); ?>
	<main class="page-margin">
		<?php if ($product) : ?>
			<div class="product-container">
				<div class="img-container">
					<img src="<?php echo $product['productImagePath'] ?? 'https://picsum.photos/500/500'; ?>" alt='<?php echo $product['productName']; ?>' title='<?php echo $product['productName']; ?>'>
				</div>
				<section class="main-section">
					<div>
						<h1 class="product-title"><?php echo $product['productName']; ?></h1>
						<p class="product-brand"><?php echo $product['productBrand']; ?></p>
						<h2 class="product-price">RM
							<?php echo number_format($product['productPrice'], 2, '.', ''); ?>
						</h2>
					</div>

					<form action="" method="post">
						<div class="qty-box">
							<button type="button" secondary transparent no-shadow class='quantity-btn m-0' product-id='<?php echo $product['productID']; ?>' operation='minus'>-</button>
							<input inputmode="numeric" type="text" class="qtyInput" size="5" value="<?php echo $quantity; ?>">
							<button type="button" secondary transparent no-shadow class='quantity-btn m-0' product-id='<?php echo $product['productID']; ?>' operation='plus'>+</button>
						</div>

						<button primary class="submitBtn" type="submit">
							<?php if ($UID) : ?>
								<?php echo "Add To Cart"; ?>
							<?php else : ?>
								<?php echo "Login To Purchase" ?>
							<?php endif; ?>
						</button>

					</form>
				</section>
				<section class="secondary-section">
					<?php if ($product['productCategory']) : ?>
						<div class="info-box">
							<p class="m-0">Category: <?php echo $product['productCategory']; ?></p>
						</div>
					<?php endif; ?>
					<?php if ($product['productType']) : ?>
						<div class="info-box">
							<p class="m-0">Type: <?php echo $product['productType']; ?></p>
						</div>
					<?php endif; ?>
					<p class="product-desc"><?php echo $product['productDetails']; ?></p>
				</section>
			</div>
		<?php else : ?>
			<div class="no-products">
				<img src="../../assets/img/empty-box.png" alt="">
				<div>
					<h2>Product Not Found!</h2>
					<small>
						The page you're looking for doesn't exist. Please check the URL or return to the <a class="link" href="ItemList.php">product listing</a> to browse our products. We apologize for any inconvenience.</small>
				</div>
			</div>
		<?php endif; ?>
	</main>
	<?php include("../../src/includes/footer.html") ?>
</body>
<script>
	document.querySelectorAll('.quantity-btn').forEach(button => {
		button.addEventListener('click', function() {
			const productID = this.getAttribute('product-id');
			const operation = this.getAttribute('operation');
			const quantityElement = document.querySelector(`.qtyInput`);
			let quantity = parseInt(quantityElement.value);

			if (operation === 'plus') {
				quantity++;
			} else if (operation === 'minus') {
				if (quantity > 1) {
					quantity--;
				}
			}
			quantityElement.value = quantity;
		});
	});

	document.querySelectorAll('.qtyInput').forEach(input => {
		input.addEventListener('change', function() {
			let value = input.value;
			if (isNaN(value) || value <= 0) {
				input.value = this.defaultValue
				return
			}
			input.value = parseInt(value)
		});
	});
</script>

</html>