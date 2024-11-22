<?php
// Include database connection
include('../config/db_connection.php');

// Fetch the supplier-product data from the database
$sql = "SELECT supplier.supplier_name, 
               product.product_name, 
               product.quantity_on_hand, 
               product.reorder_level
        FROM supplier
        JOIN product ON supplier.supplier_id = product.supplier_id
        ORDER BY supplier.supplier_name ASC, product.product_name ASC";

$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier and Product Report - Sylvester's Bike Shop</title>
    <link rel="stylesheet" href="../assets/index.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .supplier-header {
            background-color: #f8f8f8;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="/Sylvester_Bike_Shop">Back to Menu</a></li>
            <li><a href="/Sylvester_Bike_Shop/product">Back to Product List</a></li>
        </ul>
    </nav>

    <h2>Supplier and Product Report</h2>

    <?php
    if ($stmt->rowCount() > 0) {
        $current_supplier = ""; // To track when the supplier changes
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Supplier Name</th>
                    <th>Product Name</th>
                    <th>Quantity on Hand</th>
                    <th>Reorder Level</th>
                </tr>
              </thead>
              <tbody>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // If the supplier changes, print the new supplier name (as a table header)
            if ($row['supplier_name'] !== $current_supplier) {
                if ($current_supplier != "") {
                    echo "</tbody>"; // Close previous supplier's products section
                }
                echo "<tbody><tr class='supplier-header'><td colspan='4'>" . $row['supplier_name'] . "</td></tr>";
                $current_supplier = $row['supplier_name']; // Update the current supplier
            }

            // Print the product details under the current supplier
            echo "<tr>
                    <td></td>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['quantity_on_hand'] . "</td>
                    <td>" . $row['reorder_level'] . "</td>
                  </tr>";
        }
        echo "</tbody></table>"; // Close the last supplier list and the table
    } else {
        echo "<p>No products found.</p>";
    }
    ?>

</body>
</html>
