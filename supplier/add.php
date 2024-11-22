<?php
// Include database connection
include('../config/db_connection.php');

// Define variables for the form
$supplier_name = $supplier_contact_info = "";
$error_message = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'];
    $supplier_contact_info = $_POST['supplier_contact_info'];

    try {
        // Prepare and execute the insert query
        $sql = "INSERT INTO supplier (supplier_name, supplier_contact_info)
                VALUES (:supplier_name, :supplier_contact_info)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':supplier_contact_info', $supplier_contact_info);
        
        $stmt->execute();
        
        // Redirect or success message
        echo "<p>Supplier added successfully!</p>";
        echo "<a href='index.php'>Back to Supplier List</a>";  // Back link
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Supplier</title>
</head>
<body>
    <h2>Add New Supplier</h2>

    <?php if ($error_message): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="supplier_name">Supplier Name:</label><br>
        <input type="text" id="supplier_name" name="supplier_name" required><br><br>

        <label for="supplier_contact_info">Phone:</label><br>
        <input type="text" id="supplier_contact_info" name="supplier_contact_info" required><br><br>

        <button type="submit">Add Supplier</button>
        <a href="index.php"><button type="button">Cancel</button></a> <!-- Cancel button -->
    </form>
</body>
</html>
