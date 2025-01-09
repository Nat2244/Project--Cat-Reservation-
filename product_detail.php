<?php
// Include your database connection file
// Assuming you have a connection file like "db_connect.php"

// Check if the 'id' is passed via the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id); // 'i' stands for integer (id is an integer)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        // Fetch the product details
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid product ID.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Add Bootstrap CSS or your custom styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Display product image -->
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <!-- Display product details -->
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                
                <!-- You can add a purchase button, contact form, or whatever you need -->
                <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>

    <!-- Add Bootstrap JS if you need it -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close database connection (optional, as PHP will close it automatically when the script ends)
$conn->close();
?>
