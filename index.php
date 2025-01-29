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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Cat Cafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>



<!--uploading images into database -->
<?php
error_reporting(0);

$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;

    $db = mysqli_connect("localhost", "root", "root", "geeksforgeeks");

    // Get all the submitted data from the form
    $sql = "INSERT INTO image (filename) VALUES ('$filename')";

    // Execute query
    mysqli_query($db, $sql);

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>&nbsp; Image uploaded successfully!</h3>";
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
    }
}
?>




			
		</header>

		<section class="container">
    <div class="row">
        <div class="col-md-9 content">
            <p class="text-justify">Welcome!</p>

            <!-- code for displaying cat information  -->
            <?php
include 'db.php'; // Include your database connection

// Fetch cats from the database
$query = "SELECT cat_id, name, image_url FROM cats";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .cat-card {
            display: inline-block;
            margin: 15px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            width: 220px;
            background-color: #f8f8f8;
        }
        .cat-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cat-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .cat-card button {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-transform: uppercase;
        }
        .cat-card button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Meet Our Cats</h1>
    <div>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="cat-card">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <?php
                // Check if image_url exists and is not empty
                $image_url = !empty($row['image_url']) ? $row['image_url'] : 'images/default_image.jpg';
                ?>
                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <form action="cat_detail.php" method="GET">
                    <input type="hidden" name="cat_id" value="<?php echo $row['cat_id']; ?>">
                    <button type="submit">View Details</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>


 <!-- code end for cat list -->

            <!-- Displaying Products from MySQL Database -->
            
            <section class="container">
    <h3>Our Products</h3>
    <div class="row">
        <?php
        // Assuming you've already connected to the database
        // Example: $conn = mysqli_connect("hostname", "username", "password", "database");

        // Fetch products from the database
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        // Check if products are available
        if (mysqli_num_rows($result) > 0) {
            // Loop through each product and display it
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4">';  // Add spacing between product cards
                echo '<div class="card" style="width: 18rem;">';  // Use card layout for product
                
                // Ensure image exists and is correctly loaded
                $image_path = "images/" . $row['image'];  // Assuming the image file path is stored in 'image' column
                if (file_exists($image_path)) {
                    echo '<img src="' . $image_path . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                } else {
                    echo '<img src="images/default.jpg" class="card-img-top" alt="Default image">';  // Default image if not found
                }
                
                // Display product details
                echo '<div class="card-body">';
                echo '<h4 class="card-title">' . htmlspecialchars($row['name']) . '</h4>';
                echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><strong>Price: $' . htmlspecialchars($row['price']) . '</strong></p>';
                echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                echo '</div>';  // Closing card-body
                echo '</div>';  // Closing card div
                echo '</div>';  // Closing col-md-4
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>  <!-- Closing row -->
</section>

<footer class="container">
    <?php include 'footer.php'; ?>
</footer>





		<!--  calnendar for reservation -->


		<?php
// Include database connection file
include('db.php');

// Handle reservation form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['reservation_time']);

    $sql = "INSERT INTO reservations (user_name, reservation_date, reservation_time) VALUES ('$user_name', '$reservation_date', '$reservation_time')";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Reservation successful!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Get current date for calendar view
$current_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$month = date('m', strtotime($current_date));
$year = date('Y', strtotime($current_date));

// Get reservations for the current month
$reservations = [];
$sql = "SELECT * FROM reservations WHERE MONTH(reservation_date) = '$month' AND YEAR(reservation_date) = '$year'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[$row['reservation_date']][] = $row['reservation_time'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Cafe Reservation</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .calendar-table td {
            height: 80px;
            width: 80px;
            text-align: center;
            vertical-align: top;
            cursor: pointer;
        }
        .reserved {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Cat Cafe Reservation Calendar</h2>
        
        <!-- Calendar navigation (Previous & Next month) -->
        <div class="mb-3">
            <a href="calendar.php?date=<?php echo date('Y-m-d', strtotime('-1 month', strtotime($current_date))); ?>" class="btn btn-secondary">Previous</a>
            <span class="ml-3"><?php echo date('F Y', strtotime($current_date)); ?></span>
            <a href="calendar.php?date=<?php echo date('Y-m-d', strtotime('+1 month', strtotime($current_date))); ?>" class="btn btn-secondary ml-3">Next</a>
        </div>

        <!-- Display the calendar -->
        <table class="calendar-table table table-bordered">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Create the calendar for the current month
                $first_day_of_month = strtotime("$year-$month-01");
                $last_day_of_month = strtotime("$year-$month-" . date('t', $first_day_of_month));

                $first_weekday = date('w', $first_day_of_month); // Day of the week the month starts on
                $days_in_month = date('t', $first_day_of_month); // Number of days in the month

                $day_counter = 1;
                $calendar_html = '';
                
                for ($week = 0; $week < 6; $week++) { // max 6 rows for a calendar
                    $calendar_html .= '<tr>';

                    for ($day = 0; $day < 7; $day++) {
                        // Skip empty cells before the first day of the month
                        if (($week == 0 && $day < $first_weekday) || $day_counter > $days_in_month) {
                            $calendar_html .= '<td></td>';
                        } else {
                            $date_str = "$year-$month-" . str_pad($day_counter, 2, '0', STR_PAD_LEFT);
                            $is_reserved = isset($reservations[$date_str]);
                            $reserved_class = $is_reserved ? 'reserved' : '';

                            $calendar_html .= "<td class='$reserved_class' data-toggle='tooltip' title='Click to reserve' data-date='$date_str'>$day_counter</td>";
                            $day_counter++;
                        }
                    }

                    $calendar_html .= '</tr>';
                }

                echo $calendar_html;
                ?>
            </tbody>
        </table>

        <!-- Reservation form -->
        <div class="mt-5">
            <h3>Make a Reservation</h3>
            <form action="calendar.php" method="POST">
                <div class="form-group">
                    <label for="user_name">Your Name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                </div>
                <div class="form-group">
                    <label for="reservation_date">Reservation Date</label>
                    <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
                </div>
                <div class="form-group">
                    <label for="reservation_time">Reservation Time</label>
                    <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
                </div>
                <button type="submit" name="reserve" class="btn btn-primary">Reserve</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Tooltip functionality for the calendar -->
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
    </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>

	</body>
</html>