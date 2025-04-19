<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your cart.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$sql = "SELECT C.cart_item_id, P.product_id, P.product_name, P.image, P.price, C.quantity
        FROM CartItems C
        JOIN Products P ON C.product_id = P.product_id
        WHERE C.user_id = $user_id";
$result = $conn->query($sql);
?>

<h2>Your Shopping Cart</h2>
<?php if ($result->num_rows == 0): ?>
  <p>Your cart is empty.</p>
<?php else: ?>
  <table>
    <tr>
      <th>Product</th>
      <th>Unit Price</th>
      <th>Quantity</th>
      <th>Subtotal</th>
      <th>Action</th>
    </tr>
    <?php 
    $total = 0;
    while($row = $result->fetch_assoc()): 
      $subtotal = $row['price'] * $row['quantity'];
      $total += $subtotal;
    ?>
      <tr>
        <td>
          <img src="<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" width="50">
          <?php echo htmlspecialchars($row['product_name']); ?>
        </td>
        <td>$<?php echo number_format($row['price'],2); ?></td>
        <td>
          <form action="update_cart.php" method="post">
            <input type="hidden" name="cart_item_id" value="<?php echo $row['cart_item_id']; ?>">
            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
            <input type="submit" value="Update">
          </form>
        </td>
        <td>$<?php echo number_format($subtotal,2); ?></td>
        <td>
          <a href="remove_from_cart.php?cart_item_id=<?php echo $row['cart_item_id']; ?>">Remove</a>
        </td>
      </tr>
    <?php endwhile; ?>
    <tr>
      <td colspan="3"><strong>Total:</strong></td>
      <td colspan="2"><strong>$<?php echo number_format($total,2); ?></strong></td>
    </tr>
  </table>
  <button onclick="window.location.href='clear_cart.php'">Clear Cart</button>
  <button onclick="window.location.href='checkout.php'" <?php if($total <= 0) echo "disabled"; ?>>Place Order</button>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
