<?php
// Include database connection
include('../config/db_connection.php');

// Define variables for the form
$supplier_name = $supplier_contact_info = "";
$error_message = "";

// Get the supplier ID from the URL
if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    // Fetch supplier details
    $sql = "SELECT * FROM supplier WHERE supplier_id = :supplier_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':supplier_id', $supplier_id);
    $stmt->execute();
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($supplier) {
        // Pre-fill the form fields with the existing supplier data
        $supplier_name = $supplier['supplier_name'];
        $supplier_contact_info = $supplier['supplier_contact_info'];
    } else {
        echo "Supplier not found.";
        exit;
    }
}

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'];
    $supplier_contact_info = $_POST['supplier_contact_info'];

    try {
        // Prepare and execute the update query
        $sql = "UPDATE supplier SET supplier_name = :supplier_name, supplier_contact_info = :supplier_contact_info
                WHERE supplier_id = :supplier_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':supplier_contact_info', $supplier_contact_info);
        $stmt->bindParam(':supplier_id', $supplier_id);
        
        $stmt->execute();

        echo "<p>Supplier updated successfully!</p>";
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
    <title>Edit Supplier</title>
</head>
<body>
    <h2>Edit Supplier</h2>

    <?php if ($error_message): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="supplier_name">Supplier Name:</label><br>
        <input type="text" id="supplier_name" name="supplier_name" value="<?php echo $supplier_name; ?>" required><br><br>

        <label for="supplier_contact_info">Phone:</label><br>
        <input type="text" id="supplier_contact_info" name="supplier_contact_info" value="<?php echo $supplier_contact_info; ?>" required><br><br>

        <button type="submit">Update Supplier</button>
        <a href="index.php"><button type="button">Cancel</button></a> <!-- Cancel button -->
    </form>
</body>
</html>
