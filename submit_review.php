<?php
session_start();
require_once('db.php');

// Ensure the necessary fields are set
if (isset($_SESSION['user_id']) && isset($_POST['product_id']) && isset($_POST['rating']) && isset($_POST['review_text'])) {
    
    // Get the user ID and form inputs
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
    
    // Validate product ID (ensure it's an integer)
    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        echo "Invalid product ID.";
        exit;
    }

    // Fetch the user's profile picture
    $user_query = "SELECT profile_pic FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($user_query);
    if (!$stmt) {
        die("Prepared statement failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $profile_pic = $user['profile_pic'] ? 'images/profiles/' . $user['profile_pic'] : 'images/profiles/default.png';
    } else {
        $profile_pic = 'images/profiles/default.png';
    }

    // Insert the review into the database
    $query = "INSERT INTO reviews (product_id, user_id, rating, review_text) 
              VALUES ('$product_id', '$user_id', '$rating', '$review_text')";
    
    // Execute the query and check for success
    if (mysqli_query($conn, $query)) {
        // Redirect back to the product detail page after submitting the review
        header("Location: product_detail.php?id=$product_id");
        exit; // Ensure no further script execution
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
