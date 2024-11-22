<?php
// Include database connection
include('../config/db_connection.php');

// Get the product ID from the URL
$product_id = $_GET['id'];

// Prepare and execute the delete query
$sql = "DELETE FROM product WHERE product_id = :product_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_id', $product_id);

if ($stmt->execute()) {
    session_start();
    $_SESSION['message'] = 'Product deleted successfully!';
    header('Location: index.php');
} else {
    echo "Error: Could not delete product.";
}
?>
