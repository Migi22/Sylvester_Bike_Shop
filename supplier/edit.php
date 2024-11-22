<?php
// Include database connection
include('../config/db_connection.php');

// Get the supplier ID from the URL
if (!isset($_GET['id'])) {
    die("Error: Supplier ID is required.");
}

$supplier_id = $_GET['id'];

// Fetch the current supplier details
$sql = "SELECT * FROM supplier WHERE supplier_id = :supplier_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':supplier_id', $supplier_id);
$stmt->execute();

$supplier = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$supplier) {
    die("Error: Supplier not found.");
}

// Define variables for the form (pre-populated with current data)
$supplier_name = $supplier['supplier_name'];
$supplier_email = $supplier['supplier_email'];
$supplier_phone = $supplier['supplier_phone'];
$supplier_address = $supplier['supplier_address'];
$error_message = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_address = $_POST['supplier_address'];

    try {
        // Prepare and execute the update query
        $sql = "UPDATE supplier 
                SET supplier_name = :supplier_name, supplier_email = :supplier_email, 
                    supplier_phone = :supplier_phone, supplier_address = :supplier_address
                WHERE supplier_id = :supplier_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':supplier_email', $supplier_email);
        $stmt->bindParam(':supplier_phone', $supplier_phone);
        $stmt->bindParam(':supplier_address', $supplier_address);
        $stmt->bindParam(':supplier_id', $supplier_id);
        
        $stmt->execute();
        
        // Redirect or success message
        echo "<p>Supplier updated successfully!</p>";
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

        <label for="supplier_email">Email:</label><br>
        <input type="email" id="supplier_email" name="supplier_email" value="<?php echo $supplier_email; ?>" required><br><br>

        <label for="supplier_phone">Phone:</label><br>
        <input type="text" id="supplier_phone" name="supplier_phone" value="<?php echo $supplier_phone; ?>" required><br><br>

        <label for="supplier_address">Address:</label><br>
        <textarea id="supplier_address" name="supplier_address" required><?php echo $supplier_address; ?></textarea><br><br>

        <button type="submit">Update Supplier</button>
    </form>
</body>
</html>
