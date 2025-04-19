<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$cart_item_id = intval($_GET['cart_item_id']);
$user_id = $_SESSION['user_id'];

$conn->query("DELETE FROM CartItems WHERE cart_item_id = $cart_item_id AND user_id = $user_id");

header("Location: cart.php");
exit;
?>
