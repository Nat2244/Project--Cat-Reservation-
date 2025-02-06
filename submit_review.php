<?php
// Include the database connection file
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to submit a review.";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // Sanitize inputs
    $rating = filter_var($rating, FILTER_VALIDATE_INT);
    $review_text = htmlspecialchars(trim($review_text));

    if ($rating && !empty($review_text)) {
        // Prepared statement to insert the review into the database
        $sql = "INSERT INTO reviews (product_id, user_id, rating, review_text, created_at) 
                VALUES (?, ?, ?, ?, NOW())";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiis", $product_id, $user_id, $rating, $review_text);
            if ($stmt->execute()) {
                echo "Review submitted successfully!";
                header("Location: product_detail.php?id=" . $product_id); // Redirect to the product page
                exit;
            } else {
                echo "Error submitting review.";
            }
            $stmt->close();
        } else {
            echo "Error preparing the statement.";
        }
    } else {
        echo "Invalid review data.";
    }
}
?>
