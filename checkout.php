<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to checkout.";
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<h2>Delivery Details</h2>
<form action="process_order.php" method="post">
  <label>Recipient's Name: <input type="text" name="recipient_name" required></label><br>
  <label>Street Address: <input type="text" name="street" required></label><br>
  <label>City/Suburb: <input type="text" name="city" required></label><br>
  <label>State:
    <select name="state" required>
      <option value="">Select</option>
      <option value="NSW">NSW</option>
      <option value="VIC">VIC</option>
      <option value="QLD">QLD</option>
      <option value="WA">WA</option>
      <option value="SA">SA</option>
      <option value="TAS">TAS</option>
      <option value="ACT">ACT</option>
      <option value="NT">NT</option>
      <option value="Others">Others</option>
    </select>
  </label><br>
  <label>Mobile Number: <input type="tel" name="mobile" required pattern="[0-9]{10}"></label><br>
  <label>Email: <input type="email" name="email" required></label><br>
  <input type="submit" value="Submit Order">
</form>

<?php include 'includes/footer.php'; ?>
