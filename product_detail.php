<?php
// Include your database connection file
include 'db_connect.php'; // Update with your actual DB connection file

// Define a function to log errors
function log_error($error_message) {
    $log_file = 'error_log.txt'; // File to store errors
    $current_time = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$current_time] $error_message\n", FILE_APPEND);
}

// Check if the 'id' is passed via the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Validate and sanitize the input
    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        log_error("Invalid product ID: $product_id");
        header("Location: error.php?message=Invalid product ID");
        exit;
    }

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        log_error("Product not found for ID: $product_id");
        header("Location: error.php?message=Product not found");
        exit;
    }
} else {
    log_error("Product ID not provided");
    header("Location: error.php?message=Product ID not provided");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Display product image -->
                <img src="images/<?php echo htmlspecialchars(isset($product['image']) ? $product['image'] : 'default.png'); ?>" 
 
                     class="img-fluid" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <!-- Display product details -->
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'] ?? 'No description available.')); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($product['price'] ?? 0, 2); ?></p>
                
                <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
