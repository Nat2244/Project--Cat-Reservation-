<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$review_text = trim($_POST['review_text']);

// Prevent SQL Injection
$insert_query = "INSERT INTO reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "iiis", $product_id, $user_id, $rating, $review_text);

if (mysqli_stmt_execute($stmt)) {
    header("Location: product_detail.php?product_id=" . $product_id);
    exit();
} else {
    die("Error: " . mysqli_error($conn));
}
?>
