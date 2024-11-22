<?php
// Include database connection file
include('config/db_connection.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sylvester's Bike Shop</title>
</head>
<body>
    <h1>Welcome to Sylvester's Bike Shop</h1>

    <?php
    // If connected successfully, show this message
    if (isset($pdo)) {
        echo "<p>Database connection established successfully!</p>";
    } else {
        echo "<p>Failed to connect to the database.</p>";
    }
    ?>
</body>
</html>
