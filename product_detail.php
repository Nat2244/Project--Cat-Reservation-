<!-- details about the product, cost, title, image, as well as displaying reviews from the database and also allowing user to input a review once they are logged in -->
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
        die("Prepared statement failed: " . $conn->error);  // More detailed error message
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

    <!-- code to fetch reviews and display -->
    <?php
    session_start();
    require_once('db.php');

    // Debugging query execution
    $product_query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $product_query);
    if (!$stmt) {
        die("Prepared statement failed: " . mysqli_error($conn));  // More detailed error message
    }

    mysqli_stmt_bind_param($stmt, "i", $product_id);
    $execute = mysqli_stmt_execute($stmt);
    if (!$execute) {
        die("Query execution failed: " . mysqli_error($conn));  // Debugging line
    }

    $product_result = mysqli_stmt_get_result($stmt);
    if ($product_result === false) {
        die("Failed to get result: " . mysqli_error($conn));  // Debugging line
    }

    $product = mysqli_fetch_assoc($product_result);

    // Fetch reviews for this product and format date directly in the SQL query
    $review_query = "SELECT reviews.rating, reviews.review_text, 
                            DATE_FORMAT(reviews.created_at, '%b %d, %Y') as formatted_date,
                            user.username 
                     FROM reviews 
                     JOIN user ON reviews.user_id = user.user_id  -- Correct column name used
                     WHERE reviews.product_id = ? 
                     ORDER BY reviews.created_at DESC";
    $stmt = mysqli_prepare($conn, $review_query);
    if (!$stmt) {
        die("Prepared statement failed: " . mysqli_error($conn));  // More detailed error message
    }

    mysqli_stmt_bind_param($stmt, "i", $product_id);
    $execute = mysqli_stmt_execute($stmt);
    if (!$execute) {
        die("Query execution failed: " . mysqli_error($conn));  // Debugging line
    }

    $reviews = mysqli_stmt_get_result($stmt);
    if ($reviews === false) {
        die("Failed to get result: " . mysqli_error($conn));  // Debugging line
    }
    ?>

    <!-- Product review section -->
    <div class="container mt-5">
        <h3>Customer Reviews</h3>
        <?php if (mysqli_num_rows($reviews) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
                <div class="review p-3 mb-3 border rounded">
                    <div class="d-flex align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                            <span class="text-muted"> - <?php echo $row['formatted_date']; ?></span>
                            <br>
                            <span class="text-warning"><?php echo str_repeat("⭐", $row['rating']); ?></span>
                        </div>
                    </div>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($row['review_text'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review this product!</p>
        <?php endif; ?>
    </div>

    <!-- Leave a review form -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <hr>
        <h3>Leave a Review</h3>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="mb-3">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="review">Review:</label>
                <textarea name="review_text" id="review" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Login</a> to leave a review.</p>
    <?php endif; ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
