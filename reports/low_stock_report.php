<?php
// Include database connection
include('../config/db_connection.php');

// Fetch the low stock products from the database
$sql = "SELECT supplier.supplier_name,
               supplier.supplier_contact_info,
               product.product_name, 
               product.quantity_on_hand, 
               product.reorder_level
        FROM product
        JOIN supplier ON product.supplier_id = supplier.supplier_id
        WHERE product.quantity_on_hand <= product.reorder_level
        ORDER BY supplier.supplier_name ASC, product.product_name ASC";

$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Low Stock Report - Sylvester's Bike Shop</title>
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

        /* Zebra striping for rows */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Center-align numeric columns */
        td:nth-child(4), td:nth-child(5) {
            text-align: center;
        }

        /* Adjust the widths of the columns */
        th:nth-child(1), td:nth-child(1) {
            width: 12%; /* Supplier Name column */
        }

        th:nth-child(2), td:nth-child(2) {
            width: 10%; /* Supplier Contact Info column */
        }

        th:nth-child(3), td:nth-child(3) {
            width: 15%; /* Product Name column */
        }

        th:nth-child(4), td:nth-child(4) {
            width: 5%; /* Quantity on Hand column */
        }

        th:nth-child(5), td:nth-child(5) {
            width: 5%; /* Reorder Level column */
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

    <h2>Low Stock Products Report</h2>

    <?php
    if ($stmt->rowCount() > 0) {
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Supplier Name</th>
                    <th>Supplier Contact Info</th>
                    <th>Product Name</th>
                    <th>Quantity on Hand</th>
                    <th>Reorder Level</th>
                </tr>
              </thead>
              <tbody>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row['supplier_name'] . "</td>
                    <td>" . $row['supplier_contact_info'] . "</td>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['quantity_on_hand'] . "</td>
                    <td>" . $row['reorder_level'] . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p style='color: green;'>All products are sufficiently stocked. No reorder required at this time.</p>";
    }
    ?>

</body>
</html>
