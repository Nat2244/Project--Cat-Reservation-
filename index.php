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
            <p class="text-justify"> Welcome! </p>

            <!-- Displaying Products from MySQL Database -->
			<div class="card" style="width: 18rem;">
            <img src="hoodie.jpg" class="card-img-top" alt="...">
            <div class="card-body">
            
         </div>
     </div>
            <h3>Our Products</h3>
            <div class="row">
            <?php
            // Fetch products from the database
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // Corrected echoing PHP variables inside HTML
                    echo '<div class="col-md-4">';
                    echo '<div class="product">';
                    echo '<img src="images/' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                    echo '<h4>' . $row['name'] . '</h4>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<p><strong>Price: $' . $row['price'] . '</strong></p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                    echo '</div>';
                    echo '</div>';
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

	</body>
</html>
