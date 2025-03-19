<!-- main index page code, other known as home page which displays the cats, products, and reservation where the user can submit the reservation -->

<?php
// Start session and include necessary files
session_start();
require_once('db.php');
include 'header.php'; // Assuming header.php is included once at the top

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;

// Include Bootstrap once
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
        .cat-card, .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .cat-card:hover, .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .cat-card img, .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .cat-card, .product-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .cat-card h3, .product-card h4 {
            font-weight: 700;
            color: #333;
        }
        .cat-card p, .product-card p {
            color: #777;
        }
        .product-card .btn-primary {
            background-color: #ffc107;
            border: none;
        }
        .navbar-nav .nav-link {
            font-size: 16px;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        .footer a {
            color: #ffc107;
        }
        .footer a:hover {
            text-decoration: underline;
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

    

        




<h1 class="text-center my-5">Welcome to our Cat Cafe Sleepy Claws!</h1> <break>


<h1 class="text-center my-5">About us</h1>

<p class="text-center my-5"> We are a cat cafe who welcome everybody to meet our little furry friends</p>

<!-- Cat Listing Section -->
<h1 class="text-center my-5">Meet our Cats</h1>
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        $query = "SELECT cat_id, name, image_url FROM cats";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col">
                    <div class="card cat-card shadow-sm">
                        <?php
                        // Check if the image_url is not empty and use it, otherwise fallback to default image
                        $imageSrc = !empty($row['image_url']) ? 'images/' . htmlspecialchars($row['image_url']) : 'images/default_image.jpg';
                        ?>
                        <img src="<?php echo $imageSrc; ?>" alt="Cat Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h3 class="card-title text-center"><?php echo htmlspecialchars($row['name']); ?></h3>
                            <div class="text-center">
                                <form action="cat_detail.php" method="GET">
                                    <input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
                                    <button type="submit" class="btn btn-warning btn-block mt-3">View Details</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        } else {
            echo "<p class='col-12 text-center'>No cats found!</p>";
        }
        ?>
    </div>
</div>



<!-- Products Section -->
<h3 class="text-center my-5">Our Products</h3>
<div class="container">
    <div class="row">
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="product-card card shadow">';
                // Added class for resizing images
                echo '<img src="images/' . $row['image'] . '" class="card-img-top product-img" alt="' . htmlspecialchars($row['name']) . '">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title text-center">' . htmlspecialchars($row['name']) . '</h4>';
                echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><strong>Price: $' . htmlspecialchars($row['price']) . '</strong></p>';
                echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btn btn-primary btn-block">View Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p class='col-12 text-center'>No products found.</p>";
        }
        ?>
    </div>
</div>

<!-- Add custom CSS for resizing the images -->
<style>
    .product-img {
        height: 200px;
        object-fit: cover;
    }
</style>



<!-- Reservation Section -->
<h2 class="text-center my-5">Make a Reservation</h2>
<div class="container">
    <form action="calendar.php" method="POST" class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user_name">Your Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="reservation_date">Reservation Date</label>
                <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="reservation_time">Reservation Time</label>
                <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <button type="submit" name="submit" class="btn btn-warning btn-block w-100">Reserve</button>
        </div>
    </form>
</div>






<!-- Footer -->


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<iframe width="781" height="506" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=781&amp;height=506&amp;hl=en&amp;q=Grove%20Park%20Rd,%20Wrexham%20LL12%207AB%20Wrexham+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://mapswebsite.net/'>google maps html widget</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=5c5171098e8f4458546c4a578830b560dc0da13c'></script>

</body>
</html>
