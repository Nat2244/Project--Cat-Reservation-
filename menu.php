<!-- products from the menu displaying from the database  -->

<?php
// Start session and include necessary files
session_start();
require_once('db.php');
include 'header.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Cafe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
        .cat-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php
$isLoggedIn = isset($_SESSION['user_id']); 

$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="index.php">🐱 Cat Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>" href="menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger logout-hover" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="register.php">Register</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="card text-white border-0 shadow-lg">
    <div class="position-relative">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/046/775/764/small_2x/three-orange-kittens-are-looking-at-the-camera-photo.jpeg" class="card-img" alt="cat_banner">
        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-center bg-dark bg-opacity-50">
            <h1 class="card-title fw-bold">🐾 Welcome to Our Menu 🐾</h1>
            <p class="card-text fs-5">Enjoy delicious coffee, cakes, and tea in the company of adorable cats!</p>
            <p class="card-text"><small class="text-light">Relax, sip, and purr! 😺☕</small></p>
            <a href="index.php" class="btn btn-warning mt-3 px-4">⬅️ Back Home</a>
        </div>
    </div>
</div>

<?php
// Include the database connection
include('db.php'); 

// Fetch meals and drinks from the database
$sql = "SELECT * FROM menu"; // Removed the category filter
$result = $conn->query($sql);

// Check if query execution was successful
if ($result === false) {
    die("Error executing query: " . $conn->error); // Error handling if the query fails
}
?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Our Menu</h1>

    <div class="row">
        <?php
        // Check if there are results from the query
        if ($result->num_rows > 0): 
            // Loop through each row and display the menu item
            while ($row = $result->fetch_assoc()):
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Debugging: Display the image path -->
                        <p>Image Path: <?php echo htmlspecialchars($row['image']); ?></p> <!-- Debugging: Display the image path -->

                        <!-- Display image if available -->
                        <img src="images/<?php echo isset($row['image']) && !empty($row['image']) ? htmlspecialchars($row['image']) : 'default_image.jpg'; ?>" class="card-img-top" alt="<?php echo isset($row['name']) && !empty($row['name']) ? htmlspecialchars($row['name']) : 'No name available'; ?>">

                        <div class="card-body">
                            <h5 class="card-title"><?php echo isset($row['name']) && !empty($row['name']) ? htmlspecialchars($row['name']) : 'No name available'; ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <p class="card-text"><strong>$<?php echo number_format($row['price'], 2); ?></strong></p>
                            <a href="#" class="btn btn-warning">Order Now</a>
                        </div>
                    </div>
                </div>
        <?php 
            endwhile; 
        else:
            // If no items are found
            echo "<p class='text-center'>No menu items found. Please check back later!</p>";
        endif;
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
