<!-- this code runs the function of adding the product to a cart button once the user is logged in.  -->

<?php
session_start();
require_once('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate and sanitize inputs
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("Product ID or Quantity is missing.");
}

$product_id = intval($_POST['product_id']); // Ensure it's an integer
$quantity = intval($_POST['quantity']); // Ensure it's an integer

if ($product_id <= 0 || $quantity <= 0) {
    die("Invalid product or quantity.");
}

// Check if the product exists in the cart
$check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Update quantity if product already in cart
    $update_query = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $user_id, $product_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Error updating cart: " . mysqli_error($conn));
    }
} else {
    // Insert new product into the cart
    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "iii", $user_id, $product_id, $quantity);
    if (!mysqli_stmt_execute($stmt)) {
        die("Error inserting into cart: " . mysqli_error($conn));
    }
}

// Debugging: Check if the cart was updated
$cart_check = "SELECT * FROM cart WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $cart_check);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$cart_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($cart_result) > 0) {
    echo "Cart updated successfully!";
} else {
    echo "Cart is still empty!";
}

// Redirect to the cart page
header("Location: cart.php");
exit();
?>
