<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to place an order.");
}

$user_id = $_SESSION['user_id'];
$recipient_name = trim($_POST['recipient_name']);
$street = trim($_POST['street']);
$city = trim($_POST['city']);
$state = $_POST['state'];
$mobile = trim($_POST['mobile']);
$email = trim($_POST['email']);

$orderTotal = 0;
$sql = "SELECT C.cart_item_id, C.product_id, C.quantity, P.price, P.in_stock, P.product_name
        FROM CartItems C JOIN Products P ON C.product_id = P.product_id
        WHERE C.user_id = $user_id";
$cartResult = $conn->query($sql);

while ($item = $cartResult->fetch_assoc()) {
    if ($item['in_stock'] < $item['quantity']) {
        die("Sorry, insufficient stock for " . htmlspecialchars($item['product_name']) . ".");
    }
    $orderTotal += $item['price'] * $item['quantity'];
}

$stmt = $conn->prepare("INSERT INTO Orders(user_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $orderTotal);
$stmt->execute();
$order_id = $stmt->insert_id;

$cartResult->data_seek(0);
while ($item = $cartResult->fetch_assoc()) {
    $stmt = $conn->prepare("INSERT INTO OrderItems(order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
    $conn->query("UPDATE Products SET in_stock = in_stock - {$item['quantity']} WHERE product_id = {$item['product_id']}");
}

$conn->query("DELETE FROM CartItems WHERE user_id = $user_id");
$_SESSION['order_confirmation'] = "Order #$order_id placed successfully. A confirmation email has been sent.";

header("Location: order_confirmation.php");
exit;
?>
