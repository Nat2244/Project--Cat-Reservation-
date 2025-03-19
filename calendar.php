<!-- Confirmation page for reservation with a thank you message, and inputting it into a database -->

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

// Simulating login status (Replace with your actual authentication logic)
$isLoggedIn = isset($_SESSION['user_id']); 

// Get current page filename for active link highlighting
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

<style>
/* Navbar Hover Effects */
.navbar-nav .nav-link {
    font-size: 16px;
    font-weight: 500;
    color: #fff !important;
    transition: all 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover {
    color: #ffc107 !important;
    transform: scale(1.05);
}

.navbar-nav .nav-link.active {
    color: #ffc107 !important;
    font-weight: 600;
    border-bottom: 2px solid #ffc107;
}

/* Dropdown Menu Styling */
.dropdown-menu {
    background-color: #343a40;
    border: none;
    border-radius: 10px;
}

.dropdown-menu .dropdown-item {
    color: white;
    transition: background 0.3s;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #495057;
    color: #ffc107;
}

/* Enable Hover Effect for Dropdown */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}

/* Logout Button Hover */
.logout-hover:hover {
    color: #dc3545 !important;
    font-weight: bold;
}


</style>

<!-- Bootstrap 5 JS (Include at the end of the body) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Thank You for Making a Reservation!</h1>
        <p>We appreciate your booking and look forward to seeing you soon.</p>
    </div>



    <?php
// Don't call session_start() here if it's already called in another file like header.php
// session_start(); // Remove this line

require_once('db.php'); // Include your database connection file

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['reservation_time']);
    
    // Insert data into the reservations table
    $query = "INSERT INTO reservations (user_name, reservation_date, reservation_time) 
              VALUES ('$user_name', '$reservation_date', '$reservation_time')";
    
    if (mysqli_query($conn, $query)) {
        // Reservation successful
        $message = "Reservation successfully made!";
    } else {
        // Error occurred
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Confirmation Message -->
    <div class="container my-5">
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-warning">Go Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


</body>
</html>
