<?php
session_start(); // Start the session

// Check if the "add" action is triggered via GET
if (isset($_GET['add']) && !empty($_GET['add'])) {
    $product_id = $_GET['add'];

    // Check if the cart session exists; if not, initialize it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Fetch product details from the database
        include 'db_connect.php';
        $query = "SELECT id, name, price FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Add product to cart
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        } else {
            echo "Product not found.";
            exit;
        }
    }

    header("Location: view_cart.php");
    exit;
}
?>
