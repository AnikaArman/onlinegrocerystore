<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_GET['cat']) || empty(trim($_GET['cat']))) {
    echo "<h2>Please select a category.</h2>";
    include 'includes/footer.php';
    exit;
}

$category = $conn->real_escape_string($_GET['cat']);
$sql = "SELECT * FROM Products WHERE category = '$category'";
$result = $conn->query($sql);
?>

<h2>Category: <?php echo htmlspecialchars($category); ?></h2>

<?php if ($result->num_rows > 0): ?>
  <div class="product-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="product-card" onmouseover="highlight(this)" onmouseout="removeHighlight(this)">
        <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
        <p>Unit: <?php echo $row['unit']; ?></p>
        <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
        <p><?php echo ($row['in_stock'] > 0) ? 'In Stock' : 'Out of Stock'; ?></p>
        <?php if ($row['in_stock'] > 0): ?>
           <button onclick="addToCart(<?php echo $row['product_id']; ?>)">Add to Cart</button>
        <?php else: ?>
           <button disabled class="disabled">Out of Stock</button>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p>No products found in this category.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
