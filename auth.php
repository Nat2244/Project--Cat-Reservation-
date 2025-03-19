<!-- this code identifies the identity of a user -->
 
<?php
	session_start();
	if(!isset($_SESSION['username'])){
	   header("Location:login.php");
	}
	?>
    