<?php
include 'header.php';
session_start();
require('db.php');

// If the form is submitted or not
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Assigning posted values to variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Checking if the values exist in the database
    $query = "SELECT * FROM user WHERE username='$username' and password='$password'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    // If the posted values are equal to the database values, then session will be created for the user
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id']; // Store the user_id in session
        $_SESSION['username'] = $username; // Store the username in session
        
        // Redirect to the page the user originally came from, or default to index.php
        if (isset($_SESSION['redirect_to'])) {
            $redirect_to = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']); // Clear the redirect after using it
            header("Location: $redirect_to");
            exit();
        } else {
            header("Location: index.php"); // Redirect to homepage if no specific page was set
            exit();
        }
    } else {
        $fmsg = "Invalid Login Credentials."; // Show an error message if credentials don't match
    }
}

// Display login form if user is not logged in
if (!isset($_SESSION['user_id'])) {
    ?>
    <html>
    <head>
        <title>User Login Using PHP & MySQL</title>
        <meta name="robots" content="noindex" />
    </head>
    <body>
    <div class="container">
        <form class="form-signin" method="POST">
            <?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"><?php echo $fmsg; ?> </div><?php } ?>
            <h2 class="form-signin-heading">Please Login</h2>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>
