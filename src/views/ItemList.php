<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/dialog.css?ver=<?php echo filemtime('../../css/dialog.css'); ?>">
    <link rel="stylesheet" href="../../css/listing.css?ver=<?php echo filemtime('../../css/listing.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<?php
session_start();
include("../../database.php");
$isGuest = true;
$username = "";
$category = isset($_GET['cat']) ? trim($_GET['cat']) : null;
$brands = [];
$UID ='';
if ($category) {
    $brands = getBrands($conn, $_GET['cat']);
}
$products = [];
$requstURI = $_SERVER['REQUEST_URI'];
if (isset($_SESSION["UID"])) {
    $UID = $_SESSION["UID"];
    $username = getUsername($conn, $UID);
    $isGuest = false;
}
$sqlKeyValue = array(
    'productCategory' => $category,
    'productBrand' => isset($_GET['brand']) ? $_GET['brand'] : null,
    'max' => isset($_GET['max']) ? (int) $_GET['max'] : null,
    'min' => isset($_GET['min']) ? (int) $_GET['min'] : null
);
$get = [];
$SelectWhere = "WHERE ";
foreach ($sqlKeyValue as $key => $value) {
    if (!empty($value)) {
        if ($key === 'max' && ($value === 0 || (!empty($sqlKeyValue['min']) && $value < $sqlKeyValue['min'])))
            continue;
        switch ($key) {
            case 'max':
                $get[] = "productPrice <= $value";
                break;
            case 'min':
                $get[] = "productPrice >= $value";
                break;
            case 'productBrand':
                $brandConditions = [];
                foreach ($value as $brand) {
                    $brandConditions[] = "$key = '$brand'";
                }
                $get[] = "(" . implode(" OR ", $brandConditions) . ")";
                break;
            default:
                $get[] = "$key = '$value'";
                break;
        };
    };
};

$sql = "SELECT * FROM product";
if (count($get) > 0) {
    $sqlWHEREs = implode(" AND ", $get);
    $SelectWhere = $SelectWhere . $sqlWHEREs;
    $sql = "SELECT * FROM product " . $SelectWhere . "";
}
$productResult = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($productResult)) {
    $products[] = $row;
}
// print_r($sql);
mysqli_close($conn);


if (isset($_POST['addCart'])) {
    include("../../database.php");
    $productID = $_POST['productID'];
    $quantitiy = $_POST['quantity'];
    // echo "<script>console.log('POST" . $_POST['productID'] . " request received');</script>";

    $sql_check = "SELECT quantity FROM cart WHERE userID = ? AND productID = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $UID, $productID);
    if (!mysqli_stmt_execute($stmt_check)) {
        echo "Error updating quantity: " . mysqli_error($conn);
        echo "<script>window.location.href = '" . $requstURI . "';</script>";
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
        $newQty = $oriQty + $quantitiy;
        $sql_update = "UPDATE cart SET quantity = ? WHERE userID = ? AND productID = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "iii", $newQty, $UID, $productID);
        if (mysqli_stmt_execute($stmt_update)) {
            echo " Success add to cart.";
            echo "<script>window.location.href = '" . $requstURI . "';</script>";
        } else {
            echo "Error updating quantity: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_update);
    } else {
        $sql_insert = "INSERT INTO cart (userID, productID, quantity) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iii", $UID, $productIDs, $quantities);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . mysqli_error($conn);
            } else {
                echo "Success add to cart.";
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

function getUsername($conn, $UID)
{
    $username = "";
    $sql = "SELECT username FROM user_account WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $UID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $name);
            mysqli_stmt_fetch($stmt);
            $username = $name;
        }
    } else {
        echo "Error fetch username: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    return $username;
}

function getBrands($conn, $cat)
{
    $brands = [];
    $sql = "SELECT DISTINCT productBrand FROM product WHERE productCategory = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $cat);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $productBrand);
            while (mysqli_stmt_fetch($stmt)) {
                $brands[] = $productBrand;
            }
        } else {
        }
    } else {
        echo "Error executing statement: " . mysqli_error($conn);
    }
    return $brands;
}
?>

<body>
    <?php include("../../src/includes/header.html"); ?>
    <?php include("../../src/includes/navigation.html"); ?>
    <main class="page-margin">
        <h1>Products</h1>
        <div class="gridLayout">
            <form action="" method="get" id="filterForm">
                <input type="text" name="cat" hidden value="<?php echo $category; ?>">
                <h4 class="m-0">Price Range</h4>
                <div class="price-range">
                    <input type="number" name="min" id="min" placeholder="Min Price" value="<?php echo isset($_GET['min']) ? (int)$_GET['min'] : ''; ?>">
                    <div class="vertical-line"></div>
                    <input type="number" name="max" id="max" placeholder="Max Price" value="<?php echo isset($_GET['max']) ? (int)$_GET['max'] : ''; ?>">
                </div>
                <?php if (count($brands) > 0) : ?>
                    <h4 class="m-0">Brands</h4>
                    <div class="filter-container">
                        <?php foreach ($brands as $brand) : ?>
                            <div>
                                <input type='checkbox' name='brand[]' value='<?php echo $brand; ?>' <?php echo (isset($_GET['brand']) && in_array($brand, $_GET['brand'])) ? 'checked' : ''; ?>>
                                <label class="brands-title"><?php echo $brand; ?></label><br>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <button type="submit" primary>Filter</button>
            </form>
            <?php if (count($products) > 0) : ?>
                <div class="product-container">
                    <?php foreach ($products as $product) : ?>
                        <form action="" method="post">
                            <div class="product" onclick="route('<?php echo $product['productID']; ?>')">
                                <div class="img-container">
                                    <img class="product-image" src='<?php echo $product['productImagePath'] ?? 'https://picsum.photos/500/500'; ?>' alt='<?php echo $product['productName']; ?>' title='<?php echo $product['productName']; ?>'>
                                </div>
                                <div class="product-body">
                                    <h5 class="product-title">
                                        <?php echo $product["productName"]; ?>
                                    </h5>
                                    <h6 class="product-subtitle">
                                        <?php echo $product["productBrand"]; ?>
                                    </h6>
                                    <div class="price-container">
                                        <p class="product-price">RM
                                            <?php echo number_format($product['productPrice'], 2, '.', ''); ?>
                                        </p>
                                        <input type="text" hidden name="productID" value="<?php echo $product['productID']; ?>">
                                        <input type="text" name="quantity" hidden value=1>
                                        <?php if ($UID) : ?>
                                            <button type="submit" name="addCart" class="m-0 addCart" primary>
                                                <div class="addCart">Add To Cart</div>
                                                <span>+</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="no-products-list">
                    <img src="../../assets/img/empty-box.png" alt="">
                    <div>
                        <h2>It is empty!</h2>
                        <small>Explore different filtering options to find matching products</small>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include("../../src/includes/footer.html") ?>
</body>
<script>
    const route = (id) => {
        window.location.href = `ItemDetails?id=${id}`
    };

    const form = document.getElementById('filterForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new URLSearchParams(new FormData(form)).toString();
        console.log(formData);
        window.location.href = '?' + formData;
    });

    const minInput = document.getElementById('min');
    const maxInput = document.getElementById('max');

    minInput.addEventListener('change', function() {
        if(parseInt(minInput.value) > parseInt(maxInput.value)) {
            maxInput.value = parseInt(minInput.value) + 1;
        }
    });

    maxInput.addEventListener('change', function() {
        if(parseInt(maxInput.value) < parseInt(minInput.value)) {
            minInput.value = parseInt(maxInput.value) - 1;
        }
    });

    const checkMinMax = ()=>{
        if(parseInt(minInput.value) > parseInt(maxInput.value)) {
            maxInput.value = parseInt(minInput.value) + 1;
            form.submit();
        }
    };

    checkMinMax();

</script>

</html>