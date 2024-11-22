<?php
// Include database connection
include('../config/db_connection.php');

// Define variables for the form
$supplier_name = $supplier_email = $supplier_phone = $supplier_address = "";
$error_message = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_address = $_POST['supplier_address'];

    try {
        // Prepare and execute the insert query
        $sql = "INSERT INTO supplier (supplier_name, supplier_email, supplier_phone, supplier_address)
                VALUES (:supplier_name, :supplier_email, :supplier_phone, :supplier_address)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':supplier_email', $supplier_email);
        $stmt->bindParam(':supplier_phone', $supplier_phone);
        $stmt->bindParam(':supplier_address', $supplier_address);
        
        $stmt->execute();
        
        // Redirect or success message
        echo "<p>Supplier added successfully!</p>";
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

        <label for="supplier_email">Email:</label><br>
        <input type="email" id="supplier_email" name="supplier_email" required><br><br>

        <label for="supplier_phone">Phone:</label><br>
        <input type="text" id="supplier_phone" name="supplier_phone" required><br><br>

        <label for="supplier_address">Address:</label><br>
        <textarea id="supplier_address" name="supplier_address" required></textarea><br><br>

        <button type="submit">Add Supplier</button>
    </form>
</body>
</html>
