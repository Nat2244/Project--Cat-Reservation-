<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 text-center">
        <h1 class="text-danger">Error</h1>
        <p><?php echo htmlspecialchars($_GET['message'] ?? 'An unexpected error occurred.'); ?></p>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
</body>
</html>
