<?php
include 'includes/header.php';
if (!isset($_SESSION['order_confirmation'])) {
    echo "No order information available.";
    exit;
}
?>
<h2>Order Confirmation</h2>
<p><?php echo $_SESSION['order_confirmation']; ?></p>
<?php
// Clear the order confirmation session variable after displaying the message
unset($_SESSION['order_confirmation']);
include 'includes/footer.php';
?>
