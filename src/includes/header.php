<link
  rel="stylesheet"
  href="../../css/header.css?ver=<?php echo filemtime('../../css/header.css'); ?>"
/>
<header>
  <div class="left-section">
    <a href="Home.php">
      <img
        class="logo"
        src="/Sport-Store-/assets/img/ComLogo.png"
        alt="Company Logo"
      />
    </a>
    <h1>Sport Store Web</h1>
  </div>
  <div class="right-section">
    <div class="dropdown">
      <button class="dropbtn">Account &#9662;</button>
      <div class="dropdown-content">
        <?php if(isset($_SESSION["userID"])) { ?>
        <p>
          User ID:
          <?php echo $_SESSION["userID"]; ?>
        </p>
        <?php } else { ?>
        <p>User ID: Not logged in</p>
        <?php } ?>
        <?php if(isset($_SESSION["username"])) { ?>
        <p>
          Username:
          <?php echo $_SESSION["username"]; ?>
        </p>
        <?php } else { ?>
        <p>Username: Not logged in</p>
        <?php } ?>
        <a href="../views/index.php">Logout</a>
      </div>
    </div>
  </div>
</header>
