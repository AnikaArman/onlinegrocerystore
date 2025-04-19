<?php
session_start();
include 'includes/db_connect.php';

// Check if user is admin
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1){
    die("Access denied. Admins only.");
}

// Query all orders with user details
$sql = "SELECT O.order_id, O.order_date, O.total, U.name, U.email
        FROM Orders O JOIN Users U ON O.user_id = U.user_id
        ORDER BY O.order_date DESC";
$result = $conn->query($sql);
include 'includes/header.php';
?>

<h2>Admin Dashboard - All Orders</h2>
<table border="1" cellpadding="5">
  <tr>
    <th>Order ID</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Total ($)</th>
  </tr>
  <?php while ($order = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $order['order_id']; ?></td>
      <td><?php echo $order['order_date']; ?></td>
      <td><?php echo htmlspecialchars($order['name']); ?> (<?php echo $order['email']; ?>)</td>
      <td><?php echo number_format($order['total'], 2); ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
