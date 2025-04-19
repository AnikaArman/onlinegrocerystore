<?php
include 'includes/db_connect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    
    if(empty($name) || empty($email) || empty($pass)){
      $error = "All fields are required.";
    } else {
      // Check if email already exists
      $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();
      if($stmt->num_rows > 0){
         $error = "Email already registered.";
      } else {
         $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
         $stmt = $conn->prepare("INSERT INTO Users(name, email, password) VALUES (?, ?, ?)");
         $stmt->bind_param("sss", $name, $email, $passwordHash);
         if($stmt->execute()){
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_name'] = $name;
            header("Location: index.php");
            exit;
         } else {
            $error = "Registration error. Please try again.";
         }
      }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
</head>
<body>
<h2>Register</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" action="register.php">
  <label>Name: <input type="text" name="name" required></label><br>
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Password: <input type="password" name="password" required></label><br>
  <input type="submit" value="Register">
</form>
</body>
</html>
