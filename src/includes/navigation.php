<link rel="stylesheet" href="../../css/navBar.css?ver=<?php echo filemtime('../../css/navBar.css'); ?>" />

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
    <a href="Contact.php">Contact</a>
    <div class="nav">
      <div class="navDropBtn m-0">Products <?php if (!empty($cats)) echo '&#9662'; ?></div>
      <?php if (!empty($cats)) : ?>
      <div class="nav-content">
      <a href="../views/ItemList.php">All Categories</a> 
        <?php foreach ($cats as $cat) : ?>
          <a href="../views/ItemList.php?cat=<?php echo $cat ?>"><?php echo $cat ?></a>
          <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>