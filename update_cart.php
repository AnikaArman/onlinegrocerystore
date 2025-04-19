<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$cart_item_id = intval($_POST['cart_item_id']);
$quantity = intval($_POST['quantity']);

if ($quantity > 0) {
    $conn->query("UPDATE CartItems SET quantity = $quantity WHERE cart_item_id = $cart_item_id AND user_id = {$_SESSION['user_id']}");
} else {
    $conn->query("DELETE FROM CartItems WHERE cart_item_id = $cart_item_id AND user_id = {$_SESSION['user_id']}");
}

header("Location: cart.php");
exit;
?>
