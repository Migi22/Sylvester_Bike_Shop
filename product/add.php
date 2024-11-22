<?php
// Include database connection
include('../config/db_connection.php');

// Define variables for the form
$product_name = $product_category = $supplier_id = $stock_quantity = $reorder_level = $price = "";
$error_message = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $supplier_id = $_POST['supplier_id'];
    $stock_quantity = $_POST['stock_quantity'];
    $reorder_level = $_POST['reorder_level'];
    $price = $_POST['price'];

    try {
        // Prepare and execute the insert query
        $sql = "INSERT INTO product (product_name, product_category, supplier_id, stock_quantity, reorder_level, price)
                VALUES (:product_name, :product_category, :supplier_id, :stock_quantity, :reorder_level, :price)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_category', $product_category);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':reorder_level', $reorder_level);
        $stmt->bindParam(':price', $price);
        
        $stmt->execute();
        
        // Redirect or success message
        echo "<p>Product added successfully!</p>";
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Sylvester's Bike Shop</title>
</head>
<body>
    <h2>Add New Product</h2>

    <?php if ($error_message): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_category">Category:</label><br>
        <input type="text" id="product_category" name="product_category" required><br><br>

        <label for="supplier_id">Supplier:</label><br>
        <select id="supplier_id" name="supplier_id" required>
            <?php
            // Fetch all suppliers for the dropdown
            $supplier_sql = "SELECT * FROM supplier";
            $supplier_stmt = $pdo->query($supplier_sql);
            while ($supplier = $supplier_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $supplier['supplier_id'] . "'>" . $supplier['supplier_name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="stock_quantity">Stock Quantity:</label><br>
        <input type="number" id="stock_quantity" name="stock_quantity" required><br><br>

        <label for="reorder_level">Reorder Level:</label><br>
        <input type="number" id="reorder_level" name="reorder_level" required><br><br>

        <label for="price">Price:</label><br>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
