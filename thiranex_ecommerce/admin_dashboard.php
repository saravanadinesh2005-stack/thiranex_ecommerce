<?php
session_start();
include 'db.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied! Admins only.'); window.location.href='login.php';</script>";
    exit();
}

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body style="font-family: Arial; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Admin Dashboard - Order Management</h2>
        <a href="logout.php" style="color: red;">Logout</a>
    </div>
    
    <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse;">
        <tr style="background-color: #f2f2f2;">
            <th>Order ID</th>
            <th>Total Amount ($)</th>
        </tr>
        <?php while($row = $orders->fetch_assoc()): ?>
        <tr>
            <td style="text-align: center;"><?php echo $row['id']; ?></td>
            <td style="text-align: center;"><?php echo number_format($row['total_amount'], 2); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>