<!-- database connection code -->
 
<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "cat_cafe";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	?>
	