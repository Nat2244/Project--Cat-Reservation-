<!-- uploading images from user for their profile picture icon only when the user is logged in -->

<?php
session_start();
require_once('db.php'); // Assuming db.php contains your database connection setup

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Check if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $file = $_FILES['profile_picture'];

        // Set the allowed file types and size
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 5 * 1024 * 1024; // 5MB

        // Get file information
        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Extract file extension
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check file type and size
        if (in_array($file_extension, $allowed_extensions) && $file_size <= $max_file_size) {
            // Create a unique filename to avoid name conflicts
            $new_file_name = 'profile_' . $user_id . '.' . $file_extension;
            $upload_dir = 'uploads/profile_pictures/';
            
            // Make sure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Move the file to the designated folder
            $upload_path = $upload_dir . $new_file_name;
            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                // Update the user's profile picture in the database
                $query = "UPDATE users SET profile_picture = '$new_file_name' WHERE user_id = $user_id";
                if (mysqli_query($conn, $query)) {
                    echo "Profile picture uploaded successfully!";
                } else {
                    echo "Error updating profile picture in database: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload the file.";
            }
        } else {
            echo "Invalid file type or file too large.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>
