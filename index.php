<?php
include 'includes/db_connect.php';
include 'includes/header.php';

$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
?>

<h1>Welcome to Our Online Grocery Store</h1>
<div class="product-grid">
  <?php while($row = $result->fetch_assoc()): ?>
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

<?php include 'includes/footer.php'; ?>
