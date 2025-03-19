<!-- code for removing products from the cart -->
<?php
session_start();
require_once('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session
$cart_id = $_GET['id']; // Get the cart item ID to remove

// Delete the item from the cart
$sql = "DELETE FROM cart WHERE cart_id = $cart_id AND user_id = $user_id";
mysqli_query($conn, $sql);

// Redirect to the cart page
header("Location: cart.php");
exit();
?>
