<?php
	require('db.php');
	include 'header.php';
	//Check if a user is logged in or not
	session_start();
	if (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		//Display a message for logged-in users only
		echo "<center><h3>Hello " . $username . "!</h3></center>";
		echo "<center><div><p><a href='dashboard.php'> Dashboard</a><a href='logout.php'> Logout</a></p></div></center>";
	} else {
		//Display different text if a user is not logged in.
		echo "<center><h3>Welcome to this Cat Cafe</h3></center>";
		echo '<center><div>New user? Please <a href="login.php">Login</a> or <a href="register.php">Register</a></div></center>';
	}
?>

<html>
<body>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Londrina+Sketch&family=Roboto+Slab:wght@100..900&family=Sixtyfour+Convergence&display=swap" rel="stylesheet">





	<header>
		<div class="container">
			<h3>About This Project</h3>

			<?php
			//If the user is logged-in
			if (isset($_SESSION['username'])){
				$username = $_SESSION['username'];
				echo '
				<nav class="navbar navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">My Awesome Website</a>
						</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="index.php">
								<span class="glyphicon glyphicon-home"></span> Home</a></li>
							<li><a href="#contact">Contact</a></li>
							<li><a href="dashboard.php"> Dashboard</a></li>
							<li><a href="logout.php"> Logout</a></li>';
			} else {
				echo '
				<nav class="navbar navbar-inverse navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">Cat Cafe</a>
						</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="index.php">
								<span class="glyphicon glyphicon-home"></span> Home</a></li>
							<li><a href="#contact">Contact</a></li>
							<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
							<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>';
			}
			?>       
			</div>

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
        .cat-card {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }
        .cat-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1>Meet Our Cats</h1>
    <div>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="cat-card">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
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
            
                    <!-- Product card content goes here (but seems unnecessary in the first static card) -->
                </div>
            </div>
            <h3>Our Products</h3>
            <div class="row">
                <?php
                // Assuming you've already connected to the database
                // Example: $conn = mysqli_connect("hostname", "username", "password", "database");

                // Fetch products from the database
                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        // Corrected echoing PHP variables inside HTML
                        echo '<div class="col-md-4 mb-4">';  // Add spacing between product cards
                        echo '<div class="card" style="width: 18rem;">';  // Use card layout for product
                        echo '<img src="images/' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">' . $row['name'] . '</h4>';
                        echo '<p class="card-text">' . $row['description'] . '</p>';
                        echo '<p><strong>Price: $' . $row['price'] . '</strong></p>';
                        echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                        echo '</div>';  // Closing card-body
                        echo '</div>';  // Closing card div
                        echo '</div>';  // Closing col-md-4
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>



		<footer class="container">
			<?php include 'footer.php'; ?>
		</footer>




		<!--  calnendar for reservation -->


		<?php
// Include database connection file
include('db_connect.php');

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
