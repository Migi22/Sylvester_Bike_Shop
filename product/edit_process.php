<?php
// Include database connection
include('../config/db_connection.php');

// Get form data
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_type = $_POST['product_type'];
$supplier_id = $_POST['supplier_id'];
$cost_price = $_POST['cost_price'];
$selling_price = $_POST['selling_price'];
$quantity_on_hand = $_POST['quantity_on_hand'];
$reorder_level = $_POST['reorder_level'];

// Prepare and execute the update query
$sql = "UPDATE product SET 
            product_name = :product_name, 
            product_type = :product_type, 
            supplier_id = :supplier_id, 
            cost_price = :cost_price, 
            selling_price = :selling_price, 
            quantity_on_hand = :quantity_on_hand, 
            reorder_level = :reorder_level 
        WHERE product_id = :product_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':product_name', $product_name);
$stmt->bindParam(':product_type', $product_type);
$stmt->bindParam(':supplier_id', $supplier_id);
$stmt->bindParam(':cost_price', $cost_price);
$stmt->bindParam(':selling_price', $selling_price);
$stmt->bindParam(':quantity_on_hand', $quantity_on_hand);
$stmt->bindParam(':reorder_level', $reorder_level);
$stmt->bindParam(':product_id', $product_id);

if ($stmt->execute()) {
    session_start();
    $_SESSION['message'] = 'Product updated successfully!';
    header('Location: index.php');
} else {
    echo "Error: Could not update product.";
}
?>
