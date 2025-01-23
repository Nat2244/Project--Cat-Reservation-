<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Remove the product from the cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    // Redirect back to the cart page
    header("Location: view_cart.php");
    exit;
}
?>
