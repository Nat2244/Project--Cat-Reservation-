<?php
session_start();
require_once('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch products from the cart
$cart_query = "SELECT cart.quantity, products.name, products.price 
               FROM cart 
               JOIN products ON cart.product_id = products.id 
               WHERE cart.user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Add Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Cart</h2>

    <?php if (mysqli_num_rows($cart_result) > 0) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($cart_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="alert alert-warning">Your cart is empty.</p>
    <?php endif; ?>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
    </div>
</div>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
