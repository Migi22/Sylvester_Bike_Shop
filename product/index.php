<?php
// Start the session to check for a message
session_start();

// Include database connection
include('../config/db_connection.php');

// Fetch all products from the database
$sql = "SELECT * FROM product";
$stmt = $pdo->query($sql);

// Check if there are any products
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
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock Quantity</th>
                    <th>Reorder Level</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Fetch the supplier name for each product
            $supplier_sql = "SELECT supplier_name FROM supplier WHERE supplier_id = :supplier_id";
            $supplier_stmt = $pdo->prepare($supplier_sql);
            $supplier_stmt->bindParam(':supplier_id', $row['supplier_id']);
            $supplier_stmt->execute();
            $supplier_row = $supplier_stmt->fetch(PDO::FETCH_ASSOC);
            $supplier_name = $supplier_row['supplier_name'];

            echo "<tr>
                    <td>" . $row['product_id'] . "</td>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['product_category'] . "</td>
                    <td>" . $supplier_name . "</td>
                    <td>" . $row['stock_quantity'] . "</td>
                    <td>" . $row['reorder_level'] . "</td>
                    <td>" . $row['price'] . "</td>
                    <td>
                        <a href='edit.php?id=" . $row['product_id'] . "'>Edit</a> |
                        <a href='delete.php?id=" . $row['product_id'] . "'>Delete</a>
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
