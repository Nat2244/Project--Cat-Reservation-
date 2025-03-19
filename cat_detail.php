<!-- details of the cats displayed on the home page, when the cat is clicked on this code will run fetching the details about the selected cat -->

<?php
include 'db.php'; // Include your database connection

// Check if cat_id is provided and is a valid integer
if (!isset($_GET['cat_id']) || !filter_var($_GET['cat_id'], FILTER_VALIDATE_INT)) {
    die("Invalid cat ID.");
}

$cat_id = intval($_GET['cat_id']);

// Prepare a SQL query to fetch cat details
$query = "SELECT name, breed, age, description, image_url FROM cats WHERE cat_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("i", $cat_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the cat exists
if ($result->num_rows === 0) {
    die("Cat not found.");
}

$cat = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cat['name']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2><?php echo htmlspecialchars($cat['name']); ?></h2>
            </div>
            <div class="card-body text-center">
                <img src="images/<?php echo htmlspecialchars($cat['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($cat['name']); ?>" 
                     class="img-fluid rounded shadow" 
                     style="max-width: 400px; height: auto;">
                <p class="mt-3"><strong>Breed:</strong> <?php echo htmlspecialchars($cat['breed']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($cat['age']); ?> years</p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($cat['description'])); ?></p>
                <a href="index.php" class="btn btn-secondary mt-3">Back to Cat List</a>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
