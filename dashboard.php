<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file type
    if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            $success = "Profile picture updated successfully!";
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}

// Fetch user data
$sql = "SELECT username, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
    <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    
    <h3>Your Profile Picture</h3>
    <?php if ($user['profile_picture']): ?>
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="max-width: 150px;">
    <?php else: ?>
        <p>No profile picture uploaded.</p>
    <?php endif; ?>

    <h3>Upload Profile Picture</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_picture" required>
        <button type="submit">Upload</button>
    </form>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
