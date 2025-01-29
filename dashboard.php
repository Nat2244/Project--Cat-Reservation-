<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "root"; // Replace with your database password (if any)
$dbname = "cat_cafe";

// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// If the form is submitted to upload a new profile picture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $target_dir = "uploads/";

    // Check if the directory exists, create it if not
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Generate a unique file name to avoid overwriting
    $target_file = $target_dir . uniqid($user_id . "_") . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if there were any errors during file upload
    if ($file["error"] != 0) {
        $error = "Error uploading file: " . $file["error"];
    }

    // Check if the file type is valid
    if (empty($error) && in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            // Update the user's profile picture in the database
            $sql = "UPDATE user SET profile_picture = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                $stmt->bind_param("si", $target_file, $user_id);

                if ($stmt->execute()) {
                    $success = "Profile picture updated successfully!";
                } else {
                    $error = "Failed to update profile picture in the database: " . $stmt->error;
                }
            }
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}

// Fetch user data
$sql = "SELECT username, profile_picture FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();

// Check if query execution was successful
$result = $stmt->get_result();
if ($result === false) {
    die("Error executing query: " . $stmt->error);
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Welcome, <?php echo htmlspecialchars($user['username']); ?></h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($success)) echo "<p class='alert alert-success'>$success</p>"; ?>
                        <?php if (!empty($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>

                        <h4>Your Profile Picture</h4>
                        <?php if ($user['profile_picture']): ?>
                            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="img-fluid" style="max-width: 150px;">
                        <?php else: ?>
                            <p>No profile picture uploaded.</p>
                        <?php endif; ?>

                        <h4 class="mt-3">Upload Profile Picture</h4>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="file" name="profile_picture" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>

                        <div class="mt-3">
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                            <a href="index.php" class="btn btn-secondary">Back to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
