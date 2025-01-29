<?php
session_start();
require_once('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session
$product_id = $_POST['product_id']; // Get product ID from the form
$quantity = $_POST['quantity']; // Get quantity from the form

// Check if the product already exists in the cart
$check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // If the product is already in the cart, update the quantity
    $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $update_query);
} else {
    // If the product is not in the cart, insert it
    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
    mysqli_query($conn, $insert_query);
}

// Redirect to the cart page after adding the product
header("Location: cart.php");
exit();
?>
