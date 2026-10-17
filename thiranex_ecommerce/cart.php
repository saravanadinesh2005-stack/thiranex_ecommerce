<?php
session_start();
include 'db.php';

// Handle Checkout Logic
if (isset($_POST['checkout'])) {
    if (count($_SESSION['cart']) > 0) {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'];
        }

        // Insert order into database
        $stmt = $conn->prepare("INSERT INTO orders (total_amount) VALUES (?)");
        $stmt->bind_param("d", $total);
        
        if ($stmt->execute()) {
            $_SESSION['cart'] = []; // Clear cart after checkout
            echo "<script>alert('Order placed successfully! Total: $" . $total . "'); window.location.href='index.php';</script>";
        } else {
            echo "Error placing order.";
        }
    } else {
        echo "<script>alert('Your cart is empty!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 50%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <a href="index.php">Back to Store</a><br><br>

    <?php if (count($_SESSION['cart']) > 0): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
            </tr>
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $item): 
                $total += $item['price'];
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <th>Total</th>
                <th>$<?php echo number_format($total, 2); ?></th>
            </tr>
        </table>

        <form method="POST" action="">
            <button type="submit" name="checkout" style="padding: 10px 20px; background: blue; color: white; border: none;">Proceed to Checkout</button>
        </form>
    <?php else: ?>
        <p>Your cart is currently empty.</p>
    <?php endif; ?>

</body>
</html>