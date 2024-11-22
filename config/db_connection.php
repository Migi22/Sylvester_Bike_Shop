<?php
// db_connect.php
$host = '127.0.0.1';        // MySQL server host (localhost)
$dbname = 'sylvester_bike_shop';   // The database name
$username = 'root';          // MySQL username
$password = '';              // MySQL password (if no setup password default is empty for XAMPP)

try {
    // PDO (PHP Data Objects) instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // PDO error mode to exception for error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Catch any exceptions and display a user-friendly error message
    echo "Connection failed: " . $e->getMessage();
}
?>
