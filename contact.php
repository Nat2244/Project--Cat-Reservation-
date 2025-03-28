<!-- contact page maintaining information about how to contact the cat cafe -->

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



<!-- Banner Image -->

<div class="card text-bg-dark rounded-3 shadow-lg">
  <!-- Reduced image width to 45% -->
  <img src="https://www.fonthillanimalhospital.com/files/2012/07/Slide41-orange-tabby.jpg" class="card-img-top" alt="cat banner" style="max-width: 45%; margin: 0 auto;">

  <!-- Card Image Overlay with white text and centered content -->
  <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-white text-center p-4">
    <h5 class="card-title display-4" style="font-size: 2.5rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);">Contact Us!</h5>
    
    <p class="card-text lead" style="font-size: 1.2rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);">
      If you happen to overcome any problems, feel free to contact us! We are open from 10am to 8pm from Monday to Friday.<br><br>
      Our staff is very friendly and will ensure to fix any occurring issue.<br><br>
      Thank you!
    </p>
    
    <p class="card-text"><small>Thanks for visiting!</small></p>
  </div>
</div>

<!-- Add Responsive Media Queries for Mobile Devices -->
<style>
  @media (max-width: 768px) {
    .card-title {
      font-size: 1.8rem;
    }
    .card-text {
      font-size: 1rem;
    }
  }

  @media (max-width: 480px) {
    .card-title {
      font-size: 1.5rem;
    }
    .card-text {
      font-size: 0.9rem;
    }
  }
</style>



</body>

