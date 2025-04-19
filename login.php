<?php
include 'includes/db_connect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT user_id, name, password, is_admin FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
       if (password_verify($pass, $user['password'])) {
           $_SESSION['user_id'] = $user['user_id'];
           $_SESSION['user_name'] = $user['name'];
           $_SESSION['is_admin'] = $user['is_admin'];
           header("Location: index.php");
           exit;
       } else {
           $error = "Invalid password.";
       }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" action="login.php">
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Password: <input type="password" name="password" required></label><br>
  <input type="submit" value="Login">
</form>
</body>
</html>
