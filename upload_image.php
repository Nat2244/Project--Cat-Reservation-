<?php
require('db.php'); // Database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Get the file info
    $image = $_FILES['image'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if the file was uploaded without errors
    if ($image['error'] == 0) {
        // Define the target directory to save images
        $targetDir = "uploads/";
        // Get the file extension of the uploaded image
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        // Create a unique file name
        $targetFile = $targetDir . uniqid() . '.' . $imageExtension;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Insert product data into the database
            $sql = "INSERT INTO products (name, description, price, image_url) 
                    VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssds', $name, $description, $price, $targetFile);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Product uploaded successfully!";
                } else {
                    echo "Error uploading product: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Error with file upload.";
    }
}
?>
