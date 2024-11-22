<?php
// Start the session to check for a message
session_start();

// Include database connection
include('../config/db_connection.php');

// Fetch all products with the supplier name using LEFT JOIN
$sql = "SELECT p.product_id, p.product_name, p.product_type, p.supplier_id, p.cost_price, p.selling_price, p.quantity_on_hand, p.reorder_level, s.supplier_name
        FROM product p
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id"; // Use LEFT JOIN to allow NULL supplier_id
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products - Sylvester's Bike Shop</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="/Sylvester_Bike_Shop">Back to Menu</a></li>
            <li><a href="add.php">Add Product</a></li>
            <li><a href="../reports/top_expensive_bicycles.php">Top 5 Expensive Bicycles</a></li>
            <li><a href="../reports/supplier_product_report.php">Supplier Product Report</a></li>
            <li><a href="../reports/low_stock_report.php">Low Stock Report</a></li>
        </ul>
    </nav>

    <h2>All Products</h2>

    <?php
    // Display success message if set in the session
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
        // Clear the message from the session
        unset($_SESSION['message']);
    }
    ?>

    <?php
    if ($stmt->rowCount() > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Supplier</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Quantity On Hand</th>
                    <th>Reorder Level</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Check if the supplier name is available (if the supplier_id is NULL)
            $supplier_name = $row['supplier_name'] ? htmlspecialchars($row['supplier_name'], ENT_QUOTES, 'UTF-8') : 'No Supplier';

            echo "<tr>
                    <td>" . $row['product_id'] . "</td>
                    <td>" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row['product_type'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . $supplier_name . "</td>
                    <td>" . htmlspecialchars($row['cost_price'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row['selling_price'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row['quantity_on_hand'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row['reorder_level'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>
                        <a href='edit.php?id=" . $row['product_id'] . "'>Edit</a> |
                        <a href='delete.php?id=" . $row['product_id'] . "' onclick=\"return confirm('Are you sure you want to delete this product?')\">Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</body>
</html>
