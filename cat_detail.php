<?php
include 'db.php'; // Include your database connection

// Validate and get the cat ID from the URL
if (!isset($_GET['cat_id']) || !is_numeric($_GET['cat_id'])) {
    die("Invalid cat ID.");
}
$cat_id = intval($_GET['cat_id']);

// Fetch cat details from the database
$query = "SELECT name, breed, age, description, image_url FROM cats WHERE cat_id = $cat_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Cat not found.");
}

$cat = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cat['name']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($cat['name']); ?></h1>
    <img src="<?php echo htmlspecialchars($cat['image_url']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" style="width: 300px; height: 300px;">
    <p><strong>Breed:</strong> <?php echo htmlspecialchars($cat['breed']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($cat['age']); ?> years</p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($cat['description']); ?></p>
    <a href="index.php">Back to Cat List</a>
</body>
</html>
