<?php
// Include database connection
include('../config/db_connection.php');

// Check if the supplier ID is provided in the URL
if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    try {
        // Prepare and execute the delete query
        $sql = "DELETE FROM supplier WHERE supplier_id = :supplier_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplier_id', $supplier_id);
        
        $stmt->execute();

        echo "<p>Supplier deleted successfully!</p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Supplier ID is missing.";
}
?>
