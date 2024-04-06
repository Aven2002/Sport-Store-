<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart List</title>
    <link rel="stylesheet" href="../../css/styles.css?ver=<?php echo filemtime('../../css/styles.css'); ?>">
    <link rel="stylesheet" href="../../css/cart.css?ver=<?php echo filemtime('../../css/cart.css'); ?>">
    <link rel="stylesheet" href="../../css/dialog.css?ver=<?php echo filemtime('../../css/dialog.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<?php
session_start();

$isGuest = true;
$username = "";
$cart = [];
$totalPrice = 0;

if (isset($_SESSION["UID"])) {
    include("../../database.php");
    $UID = $_SESSION["UID"];
    $isGuest = false;
    $cart = getCartList($conn, $UID);
    for ($i = 0; $i < count($cart); $i++) {
        $totalPrice += $cart[$i]["productPrice"] * $cart[$i]["quantity"];
    }
    mysqli_close($conn);
}

/**
 * get cart list from database by user's ID
 * @param mixed $conn
 * @param int $UID
 * @return array
 */
function getCartList($conn, $UID)
{
    $cart = [];
    $sql = "SELECT * FROM cart INNER JOIN product ON cart.productID = product.productID WHERE userID = ? ORDER BY cartID ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $UID);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $cart = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo "<script>const cart = " . json_encode($cart) . "</script>";
        echo "<script>console.log(cart);</script>";
    } else {
        // Log error instead of echoing directly
        echo "Error fetching cart: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    return $cart;
}



/**
 * update cart list from database by user's ID
 * @param int $userID
 * @param array $cart
 */
function updateCart($userID, $cart)
{
    include("../../database.php");
    $sql_delete = "DELETE FROM cart WHERE userID = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $userID);

    if (!mysqli_stmt_execute($stmt_delete)) {
        echo "Error deleting cart items: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_delete);

    $sql_insert = "INSERT INTO cart (userID, productID, quantity) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    foreach ($cart as $item) {
        $productID = $item['productID'];
        $quantity = $item['quantity'];
        if ((int) $quantity > 0) {
            mysqli_stmt_bind_param($stmt_insert, "iii", $userID, $productID, $quantity);

            if (!mysqli_stmt_execute($stmt_insert)) {
                echo "Error inserting cart items: " . mysqli_error($conn);
            }
        }
    }

    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);
    echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
    exit();
}


/**
 * process data and route to other page
 * @param mixed $conn
 * @param array $info
 * @param array $cart
 */
function placeOrder($info, $cart)
{
    include("../../database.php");
    try {
        if(count($cart) == 0) {
            throw new Exception("no products in cart!");
        }
        $totalPrice = 0.0;
        foreach ($cart as $item) {
            $totalPrice += $item['productPrice'] * $item['quantity'];
        }
        $sql_new_order = "INSERT INTO orders (userID, address1, address2, city, postcode, state, country, paymentMethod, totalPrice) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_insert = "INSERT INTO `order_product` (orderID, productID, quantity) VALUES (?, ?, ?)";
        $sql_delete = "DELETE FROM cart WHERE userID = ?";
        $stmt_new_order = mysqli_prepare($conn, $sql_new_order);
        mysqli_stmt_bind_param($stmt_new_order, "isssssssd", $info['UID'], $info['address1'], $info['address2'], $info['city'], $info['postcode'], $info['state'], $info['country'], $info['paymentMethod'], $totalPrice);
        mysqli_stmt_execute($stmt_new_order);
        $newOrderID = mysqli_stmt_insert_id($stmt_new_order);
        mysqli_stmt_close($stmt_new_order);
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        foreach ($cart as $item) {
            $productID = $item['productID'];
            $quantity = $item['quantity'];
            if ((int) $quantity > 0) {
                mysqli_stmt_bind_param($stmt_insert, "iii", $newOrderID, $productID, $quantity);
                mysqli_stmt_execute($stmt_insert);
            }
        }
        mysqli_stmt_close($stmt_insert);
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $info['UID']);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);
    } catch (Exception $e) {
        echo '' . $e->getMessage() . '';
        $errorMessage = urlencode($e->getMessage());
        header("Location: errorPage.php?error=$errorMessage");
    }
    mysqli_close($conn);
    header("Location: successPage.php");
    exit();
}
$info = array(
    'UID' => $UID,
    'address1' => null,
    'address2' => null,
    'city' => null,
    'postcode' => null,
    'state' => null,
    'country' => null,
    'paymentMethod' => null,
);
$address1Err = $cityErr = $postcodeErr = $stateErr = $countryErr = $paymentMethodErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['UID'])) {
        echo "<script>console.log('POST" . $_POST['subject'] . " request received');</script>";
        $UID = $_SESSION['UID'];

        switch ($_POST['subject']) {
            case 'SAVE CHANGE':
                $productData = [];

                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'quantity-') === 0) {
                        $productID = substr($key, strlen('quantity-'));
                        $productData[] = array(
                            'productID' => $productID,
                            'quantity' => $value
                        );
                    }
                }
                updateCart($UID, $productData);

                break;
            case 'Place Order':
                echo "<script>console.log('request received');</script>";
                $info['address1'] = trim($_POST["address1"]);
                $info['address2'] = trim($_POST["address2"]);
                $info['city'] = trim($_POST["city"]);
                $info['postcode'] = trim($_POST["postcode"]);
                $info['state'] = trim($_POST["state"]);
                $info['country'] = trim($_POST["country"]);
                $info["paymentMethod"] = trim($_POST["paymentMethod"]);
                $postcodePattern = '/^\d{5}$/';
                if (empty($info['address1'])) {
                    $address1Err = "<small class='errorText'>* Address 1 is required</small><br>";
                }
                if (empty($info['city'])) {
                    $cityErr = "<small class='errorText'>* City is required</small><br>";
                }
                if (empty($info['postcode'])) {
                    $postcodeErr = "<small class='errorText'>* Postcode is required</small><br>";
                } elseif (!preg_match($postcodePattern, $info['postcode'])) {
                    $postcodeErr = "<small class='errorText'>* Invalid postcode</small><br>";
                } else {
                    $info['postcode'] = strval($info['postcode']);
                }
                if (empty($info['state'])) {
                    $stateErr = "<small class='errorText'>* State is required</small><br>";
                }
                if (empty($info['country'])) {
                    $countryErr = "<small class='errorText'>* Country is required</small><br>";
                }
                if (empty($info["paymentMethod"])) {
                    $paymentMethodErr = "<p class='errorText text-center'>* Please select a payment method</p>";
                }
                if (empty($address1Err) && empty($cityErr) && empty($postcodeErr) && empty($stateErr) && empty($countryErr) && empty($paymentMethodErr)) {
                    placeOrder($info, $cart);
                }
                break;
            default:
                break;
        }
    }
}
?>

<body>
    <?php include("../../src/includes/header.php"); ?>
    <?php include("../../src/includes/navigation.html"); ?>
    <main>
        <?php if (!empty($cart)) : ?>
            <h1 class="text-center">Your Cart</h1>
            <form id="cart-form" method="post" action="">
                <p class="text-center m-0 form-title">Product list</p>
                <table class='table-list'>
                    <thead class="table-head">
                        <tr>
                            <th>Product(s)</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $index => $item) : ?>
                            <tr class="item-row" row-index="<?php echo $index; ?>">
                                <td class="item-info">
                                    <div class="item-img">
                                        <img loading='lazy' src='<?php echo $item['productImagePath'] ?? 'https://picsum.photos/id/237/500/500'; ?>' alt='<?php echo $item['productName']; ?>' title='<?php echo $item['productName']; ?>'>
                                    </div>
                                    <h4 class="item-name">
                                        <?php echo $item['productName']; ?>
                                    </h4>
                                </td>
                                <td class="item-price">
                                    RM
                                    <?php echo $item['productPrice']; ?>
                                </td>
                                <td class='item-qty'>
                                    <div>
                                        <button type="button" secondary transparent class='quantity-btn m-0' product-id='<?php echo $item['productID']; ?>' operation='minus'>-</button>
                                        <input inputmode="numeric" type="text" class="qtyInput" name="quantity-<?php echo $item['productID']; ?>" product-id='<?php echo $item['productID']; ?>' size="5" value="<?php echo $item['quantity']; ?>" ori-qty="<?php echo $item['quantity']; ?>">
                                        <button type="button" secondary transparent class='quantity-btn m-0' product-id='<?php echo $item['productID']; ?>' operation='plus'>+</button>
                                    </div>
                                </td>
                                <td class="total" totalprice-product-id='<?php echo $item['productID']; ?>'>
                                    RM
                                    <?php echo number_format($item['productPrice'] * $item['quantity'], 2, '.', ''); ?>
                                </td>
                                <td>
                                    <button danger type="button" class="removeBtn m-0" onclick="removeRow(<?php echo $index . ',\'' . $item['productName'] . '\''; ?>)">-</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="text-align: right;">
                    <input name="subject" value="SAVE CHANGE" hidden>
                    <button success type="submit" id="updateBtn" hidden>SAVE CHANGE</button>
                </div>
            </form>

            <form action="" id="info-form" method="post">
                <div class="address-container">
                    <p class="text-center m-0 form-title">Address Info</p>
                    <?php echo $address1Err; ?>
                    <input type="text" name="address1" class="address1" placeholder="Address 1"><br>
                    <input type="text" name="address2" class="address2" placeholder="Address 2">
                    <?php echo $cityErr; ?>
                    <?php echo $postcodeErr; ?>
                    <div class="pair-container">
                        <input type="text" name="city" class="city" placeholder="City">
                        <input type="number" name="postcode" class="postcode" maxlength="5" placeholder="Postcode">
                    </div>
                    <?php echo $stateErr; ?>
                    <?php echo $countryErr; ?>
                    <div class="pair-container">
                        <input type="text" name="state" class="state" placeholder="State">
                        <input type="text" name="country" class="country" placeholder="Country">
                    </div>
                </div>
                <div class="payment-container">
                    <p class="text-center m-0 form-title">Payment Method</p>
                    <?php echo $paymentMethodErr; ?>
                    <input type="radio" id="creditCard" name="paymentMethod" value="Credit Card">
                    <label for="creditCard">Credit Card</label><br>

                    <input type="radio" id="onlineBanking" name="paymentMethod" value="Online Banking">
                    <label for="onlineBanking">Online Banking</label><br>

                    <input type="radio" id="touchNGo" name="paymentMethod" value="Touch 'n Go">
                    <label for="touchNGo">Touch 'n Go</label><br>

                    <input type="radio" id="boost" name="paymentMethod" value="Boost">
                    <label for="boost">Boost</label><br>

                    <input type="radio" id="grabPay" name="paymentMethod" value="GrabPay">
                    <label for="grabPay">GrabPay</label><br>

                    <input type="radio" id="atome" name="paymentMethod" value="Atome">
                    <label for="atome">Atome</label><br>
                </div>
                <input name="subject" value="Place Order" hidden>
            </form>
            <div class="page-margin text-center">
                <button primary class="placeOrderBtn" name="submit">Place Order (RM
                    <?php echo number_format($totalPrice, 2, '.', '');; ?>)
                </button>
            </div>

        <?php elseif ($isGuest) : ?>
            <div class="guestPage">
                <img src="../../assets/img/ComLogo.png" alt="">
                <p>Please <a href="Login.php">login</a> or <a href="SignUp.php">sign up</a> to view your
                    cart list</p>
            </div>
        <?php else : ?>
            <h1 class="text-center">Your Cart</h1>
            <table class='table-list empty-cart'>
                <thead class="table-head">
                    <tr>
                        <th>Product(s)</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="empty-class">
                            Cart is empty!
                            <a primary class="homeBtn" href="Home.php">Explore More
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="#ffffff" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="48" d="M268 112l144 144-144 144M392 256H100" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <dialog id="delete-dialog">
        <p class="delete-dialog-text"></p>
        <div class="button-group">
            <button id="dialog-close" primary value="cancel">Cancel</button>
            <button id="dialog-proceed" danger-hover secondary value="yes">sure</button>
        </div>
    </dialog>
    <dialog id="place-order-dialog">
        <strong>
            <p class="dialog-text m-0">Are you sure you want to proceed with the order?</p>
        </strong>
        <small>Please note that once confirmed, order cannot be modified or cancelled.</small>
        <div class="button-group">
            <button id="dialog-close" secondary value="cancel">Cancel</button>
            <button id="dialog-proceed" success-hover primary value="yes">sure</button>
        </div>
    </dialog>
    <?php include("../../src/includes/footer.html") ?>
</body>
<script>
    //handle plus and minus operation
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productID = this.getAttribute('product-id');
            const operation = this.getAttribute('operation');
            const quantityElement = document.querySelector(`input[name='quantity-${productID}']`);
            let quantity = parseInt(quantityElement.value);

            if (operation === 'plus') {
                quantity++;
            } else if (operation === 'minus') {
                if (quantity > 0) {
                    quantity--;
                }
            }
            quantityElement.value = quantity;
            updateSubtotalPrice(quantity, productID)
            updateBtnStatus();
        });
    });

    //handle changes from input
    document.querySelectorAll('.qtyInput').forEach(input => {
        input.addEventListener('change', function() {
            let value = input.value;
            if (isNaN(value) || value < 0) {
                input.value = this.defaultValue
                return
            }
            input.value = parseInt(value)
            updateSubtotalPrice(input.value, this.getAttribute('product-id'))
            updateBtnStatus();
        });
    });

    //update product subtotal price after plus or minus
    const updateSubtotalPrice = (qty, id) => {
        if (qty && id) {
            const index = cart.findIndex(item => item.productID * 1 === id * 1);
            if (index === -1) return;
            const price = cart[index].productPrice;
            cart[index].producyQuanity = qty;
            const totalPrice = price * qty
            const totalPriceHTML = document.querySelector(`[totalprice-product-id="${id}"]`)
            if (totalPriceHTML) totalPriceHTML.innerHTML = `RM ${totalPrice.toFixed(2)}`
            document.querySelector(".placeOrderBtn").innerHTML = calculateTotalPrice();
        }
    }

    //update product total price
    const calculateTotalPrice = () => {
        let result = 0;
        cart.forEach(i => {
            result += i.productPrice * i.producyQuanity
        })
        return `PLACE ORDER (RM ${result.toFixed(2)})`;
    }

    //update "save changes" button to show or hide
    const updateBtnStatus = () => {
        const updateBtn = document.getElementById('updateBtn');
        var hasChanges = false;
        document.querySelectorAll('.qtyInput').forEach(input => {
            const quantity = parseInt(input.value);
            const originalQuantity = parseInt(input.getAttribute('ori-qty'));
            if (quantity !== originalQuantity) {
                hasChanges = true;
            }
        });

        updateBtn.hidden = !hasChanges;
    }


    //Dialog control
    let selectedRow = "";
    const delteDialog = document.querySelector("dialog#delete-dialog");
    delteDialog.querySelector("#dialog-close").addEventListener("click", () => {
        delteDialog.close();
    });

    delteDialog.querySelector("#dialog-proceed").addEventListener("click", () => {
        if (selectedRow) selectedRow.remove();
        const form = document.querySelector('#cart-form');
        if (form) form.submit()
        delteDialog.close();
    });

    const removeRow = (i, productName) => {
        document.querySelector(".delete-dialog-text").innerHTML = `Are you sure to remove <strong>${productName}</strong> from cart?`;
        selectedRow = document.querySelector("tbody").children[i];
        delteDialog.showModal();
    };

    const placeOrderDialog = document.querySelector("dialog#place-order-dialog");
    placeOrderDialog.querySelector("#dialog-close").addEventListener("click", () => {
        placeOrderDialog.close();
    });

    placeOrderDialog.querySelector("#dialog-proceed").addEventListener("click", () => {
        const form = document.querySelector('#info-form');
        if (form) form.submit()
        placeOrderDialog.close();
    });

    // need to remove the submit default function and change to open the confirmation dialog
    const placeOrderBtn =  document.querySelector(".placeOrderBtn");
    if(placeOrderBtn) placeOrderBtn.addEventListener("click", () => {
        placeOrderDialog.showModal();
    })
</script>

</html>