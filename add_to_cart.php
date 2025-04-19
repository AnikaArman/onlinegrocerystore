<?php
session_start();
include 'includes/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Please log in first."]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['product_id']);

// Check if item is already in cart
$sql = "SELECT quantity FROM CartItems WHERE user_id = $user_id AND product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newQuantity = $row['quantity'] + 1;
    $conn->query("UPDATE CartItems SET quantity = $newQuantity WHERE user_id = $user_id AND product_id = $product_id");
} else {
    $conn->query("INSERT INTO CartItems(user_id, product_id, quantity) VALUES($user_id, $product_id, 1)");
}

$countRes = $conn->query("SELECT SUM(quantity) as count FROM CartItems WHERE user_id = $user_id");
$countRow = $countRes->fetch_assoc();
$_SESSION['cart_count'] = $countRow['count'];

echo json_encode(["success" => true, "cartCount" => $_SESSION['cart_count']]);
?>
