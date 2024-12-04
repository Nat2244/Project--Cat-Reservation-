<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not authenticated
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if (isset($_POST['upload'])) {
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        // Get file details
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Allowed file types (images)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Generate a unique filename
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFolder = 'uploads/';
            $uploadPath = $uploadFolder . $newFileName;

            // Move the file to the server's upload folder
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                // Update profile image in the database
                $sql = "UPDATE users SET profile_image='$newFileName' WHERE id='$user_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Profile image uploaded successfully!";
                    header('Location: dashboard.php'); // Redirect to dashboard
                } else {
                    echo "Error updating profile image: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only images are allowed.";
        }
    } else {
        echo "No file uploaded or error in file upload.";
    }
}

$conn->close();
?>

