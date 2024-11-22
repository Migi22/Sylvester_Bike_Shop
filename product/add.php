<?php
// Include database connection
include('../config/db_connection.php');

// Fetch all suppliers to populate the supplier dropdown
$supplier_sql = "SELECT * FROM supplier";
$supplier_stmt = $pdo->query($supplier_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Sylvester's Bike Shop</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="/Sylvester_Bike_Shop">Back to Menu</a></li>
            <li><a href="index.php">Back to Products</a></li>
        </ul>
    </nav>

    <h2>Add New Product</h2>

    <form action="add_process.php" method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="product_type">Product Type:</label>
        <input type="text" id="product_type" name="product_type">

        <label for="supplier_id">Supplier:</label>
        <select id="supplier_id" name="supplier_id">
            <option value="">Select Supplier</option>
            <?php
            while ($supplier = $supplier_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $supplier['supplier_id'] . "'>" . htmlspecialchars($supplier['supplier_name'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            ?>
        </select>

        <label for="cost_price">Cost Price:</label>
        <input type="number" step="0.01" id="cost_price" name="cost_price" required>

        <label for="selling_price">Selling Price:</label>
        <input type="number" step="0.01" id="selling_price" name="selling_price" required>

        <label for="quantity_on_hand">Quantity On Hand:</label>
        <input type="number" id="quantity_on_hand" name="quantity_on_hand" required>

        <label for="reorder_level">Reorder Level:</label>
        <input type="number" id="reorder_level" name="reorder_level" required>

        <button type="submit">Add Product</button>
    </form>

</body>
</html>
