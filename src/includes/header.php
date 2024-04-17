<link rel="stylesheet" href="../../css/header.css?ver=<?php echo filemtime('../../css/header.css'); ?>" />
<header>
  <div class="left-section">
    <a href="Home.php">
      <img class="logo" src="/Sport-Store-/assets/img/ComLogo.png" alt="Company Logo" />
    </a>
    <h1>Sport Store Web</h1>
  </div>
  <div class="right-section">
    <div class="dropdown">
      <button class="dropbtn">
        <img src="../../assets/person.png" alt="Account Image">
        &#9662;</button>
      <div class="dropdown-content">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }
        $UID = !isset($_SESSION["UID"]) ? null : $_SESSION["UID"];
        if (!empty($UID)) {
          include("../../database.php");
          try {
            $sql_orders = "SELECT COUNT(*) FROM orders WHERE userID = ?";
            $stmt_orders = mysqli_prepare($conn, $sql_orders);
            mysqli_stmt_bind_param($stmt_orders, "i", $UID);
            mysqli_stmt_execute($stmt_orders);
            mysqli_stmt_bind_result($stmt_orders, $count);
            mysqli_stmt_fetch($stmt_orders);
            mysqli_stmt_close($stmt_orders);

            $sql_cart = "SELECT COUNT(*) FROM cart WHERE userID = ?";
            $stmt_cart = mysqli_prepare($conn, $sql_cart);
            mysqli_stmt_bind_param($stmt_cart, "i", $UID);
            mysqli_stmt_execute($stmt_cart);
            mysqli_stmt_bind_result($stmt_cart,$cart_count);
            mysqli_stmt_fetch($stmt_cart);
            mysqli_stmt_close($stmt_cart);

            mysqli_close($conn);
          } catch (Exception $e) {
            echo '' . $e->getMessage() . '';
            $errorMessage = urlencode($e->getMessage());
            header("Location: errorPage.php?error=$errorMessage");
          }
        }
        ?>
        <?php if (isset($_SESSION["username"])) : ?>
          <p>
            Username:
            <?php echo $_SESSION["username"]; ?>
          </p>
          <p>
            <a href="../views/orders.php" class="m-0">
              My Orders: <?php echo $count; ?>
            </a>
          </p>
          <p>
            <a href="../views/Cart.php" class="m-0">
              My Cart: <?php echo$cart_count; ?>
            </a>
          </p>
          <form action="../includes/logout.php" method="post">
            <button type="submit" danger>Logout</button>
          </form>
        <?php else : ?>
          <p>Not logged in</p>
          <a href="../views/Login.php"><button primary>Login</button></a>
          <a href="../views/SignUp.php"><button secondary>Sign Up</button></a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</header>