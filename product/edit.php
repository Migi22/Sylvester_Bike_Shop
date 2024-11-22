<?php
// Include database connection
include('../config/db_connection.php');

// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product data
$sql = "SELECT * FROM product WHERE product_id = :product_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_id', $product_id);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all suppliers to populate the supplier dropdown
$supplier_sql = "SELECT * FROM supplier";
$supplier_stmt = $pdo->query($supplier_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Sylvester's Bike Shop</title>
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

    <h2>Edit Product</h2>

    <form action="edit_process.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="product_type">Product Type:</label>
        <input type="text" id="product_type" name="product_type" value="<?php echo htmlspecialchars($product['product_type'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="supplier_id">Supplier:</label>
        <select id="supplier_id" name="supplier_id">
            <option value="">Select Supplier</option>
            <?php
            while ($supplier = $supplier_stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = $supplier['supplier_id'] == $product['supplier_id'] ? 'selected' : '';
                echo "<option value='" . $supplier['supplier_id'] . "' $selected>" . htmlspecialchars($supplier['supplier_name'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
            ?>
        </select>

        <label for="cost_price">Cost Price:</label>
        <input type="number" step="0.01" id="cost_price" name="cost_price" value="<?php echo htmlspecialchars($product['cost_price'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="selling_price">Selling Price:</label>
        <input type="number" step="0.01" id="selling_price" name="selling_price" value="<?php echo htmlspecialchars($product['selling_price'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="quantity_on_hand">Quantity On Hand:</label>
        <input type="number" id="quantity_on_hand" name="quantity_on_hand" value="<?php echo htmlspecialchars($product['quantity_on_hand'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="reorder_level">Reorder Level:</label>
        <input type="number" id="reorder_level" name="reorder_level" value="<?php echo htmlspecialchars($product['reorder_level'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <button type="submit">Update Product</button>
    </form>

</body>
</html>
