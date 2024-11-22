<?php
// Include database connection
include('../config/db_connection.php');

// Fetch product ID to delete
$product_id = $_GET['id'];

// Delete product
if ($product_id) {
    try {
        // Delete query
        $sql = "DELETE FROM product WHERE product_id = :product_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        echo "<p>Product deleted successfully!</p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>No product ID provided.</p>";
}

echo "<p><a href='index.php'>Back to Product List</a></p>";
?>
