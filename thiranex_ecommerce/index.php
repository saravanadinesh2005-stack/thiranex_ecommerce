<?php
session_start();
include 'db.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart logic
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    
    // Add item to session array
    $_SESSION['cart'][] = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price
    ];
    echo "<script>alert('Item added to cart!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Commerce Store</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .product { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; width: 300px; }
        .nav { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="nav">
        <h1>Thiranex Tech Store</h1>
        <a href="cart.php">View Cart (<?php echo count($_SESSION['cart']); ?> items)</a>
    </div>

    <h2>Product Catalog</h2>
    
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p><strong>$" . $row['price'] . "</strong></p>";
            
            // Add to cart form
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
            echo "<input type='hidden' name='product_name' value='" . $row['name'] . "'>";
            echo "<input type='hidden' name='product_price' value='" . $row['price'] . "'>";
            echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "No products available.";
    }
    ?>
</body>
</html>