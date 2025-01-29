<?php
// Include your database connection file
include 'db.php';

// Check if the database connection is working
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if the 'id' is passed via the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Validate and sanitize the input
    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        echo "<p>Invalid product ID.</p>";
        exit;
    }

    // Prepared statement to fetch product details
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("i", $product_id);
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

    $stmt->close();
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Display product image -->
                <img src="images/<?php echo isset($product['image']) ? htmlspecialchars($product['image']) : 'default.png'; ?>" 
                     class="img-fluid" 
                     alt="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'No name available'; ?>">
            </div>
            <div class="col-md-6">
                <!-- Display product details -->
                <h2><?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'No name available'; ?></h2>
                <p><strong>Description:</strong> 
                    <?php echo isset($product['description']) ? nl2br(htmlspecialchars($product['description'])) : 'No description available.'; ?>
                </p>
                <p><strong>Price:</strong> $<?php echo isset($product['price']) ? number_format($product['price'], 2) : '0.00'; ?></p>
                
                <!-- Add to cart button -->
                <a href="cart.php?add=<?php echo isset($product['id']) ? $product['id'] : ''; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  


</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
