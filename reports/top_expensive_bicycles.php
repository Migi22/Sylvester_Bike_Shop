<?php
// Include database connection
include('../config/db_connection.php');

// Query for the top 5 most expensive bicycles
$sql = "SELECT product_name, cost_price, selling_price, quantity_on_hand,
               ((selling_price - cost_price) / cost_price) * 100 AS markup_percentage
        FROM product
        ORDER BY selling_price DESC
        LIMIT 5";

$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top 5 Expensive Bicycles - Sylvester's Bike Shop</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="/Sylvester_Bike_Shop">Back to Menu</a></li>
            <li><a href="/Sylvester_Bike_Shop/product">Back to Product List</a></li>
        </ul>
    </nav>

    <h2>Top 5 Most Expensive Bicycles</h2>

    <?php
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Product Name</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Quantity On Hand</th>
                    <th>Markup Percentage</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row['product_name'] . "</td>
                    <td>" . $row['cost_price'] . "</td>
                    <td>" . $row['selling_price'] . "</td>
                    <td>" . $row['quantity_on_hand'] . "</td>
                    <td>" . number_format($row['markup_percentage'], 2) . "%</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No expensive bicycles found.</p>";
    }
    ?>

</body>
</html>
