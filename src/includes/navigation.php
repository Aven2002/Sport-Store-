<style>
  nav {
    background-color: #333;
  }

  .navbar {
    margin: 0 auto;
    overflow: hidden;
    width: max-content;
  }

  .navbar a {
    float: left;
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .nav {
    float: left;
    overflow: hidden;
  }

  .nav .navDropBtn {
    border-radius: 5px;
    border: none;
    outline: none;
    color: white;
    padding: 10px 15px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
  }

  .navbar a:hover,
  .nav:hover .navDropBtn,
  .nav-content {
    background-color: #555;
  }

  .nav-content {
    display: none;
    position: absolute;
    min-width: 160px;
    color: var(--color-font);
    z-index: 1;
  }

  .nav-content a {
    float: none;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    border-radius: 0;
    text-align: left;
    text-transform: capitalize;
  }

  .nav-content a:hover {
    background-color: var( --color-font-shadow);
  }

  .nav:hover .nav-content {
    display: block;
  }
</style>
<?php
include("../../database.php");
$sql = "SELECT DISTINCT productCategory FROM product";
$cats = [];
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $value = trim($row["productCategory"]);
  if (!in_array($value, $cats)) {
    $cats[] = $row['productCategory'];
  }
}
mysqli_free_result($result);
echo "<script>const cats = " . json_encode($cats) . "</script>";
echo "<script>console.log(cats);</script>";
?>
<nav>
  <div class="navbar">
    <a href="Home.php">Home</a>
    <div class="nav">
      <div class="navDropBtn m-0">Products <?php if (!empty($cats)) echo '&#9662'; ?></div>
      <?php if (!empty($cats)) : ?>
      <div class="nav-content">
        <?php foreach ($cats as $cat) : ?>
          <a href="../views/ItemList.php?cat=<?php echo $cat ?>"><?php echo $cat ?></a>
          <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <a href="Contact.php">Contact</a>
  </div>
</nav>