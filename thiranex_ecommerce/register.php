<?php
session_start();
include 'db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Username already exists!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body style="font-family: Arial; text-align: center; padding: 50px;">
    <h2>Register User</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="register" style="padding: 10px;">Register</button>
    </form>
    <br><a href="login.php">Already have an account? Login</a>
</body>
</html>