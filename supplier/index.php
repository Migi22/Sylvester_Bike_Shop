<?php
// Include database connection
include('../config/db_connection.php');

// Fetch all suppliers from the database
$sql = "SELECT * FROM supplier";
$stmt = $pdo->query($sql);

// Check if there are any suppliers
if ($stmt->rowCount() > 0) {
    echo "<h2>All Suppliers</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . $row['supplier_id'] . "</td>
                <td>" . $row['supplier_name'] . "</td>
                <td>" . $row['supplier_email'] . "</td>
                <td>" . $row['supplier_phone'] . "</td>
                <td>" . $row['supplier_address'] . "</td>
                <td>
                    <a href='edit.php?id=" . $row['supplier_id'] . "'>Edit</a> |
                    <a href='delete.php?id=" . $row['supplier_id'] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No suppliers table is empty.</p>";  // Message when table is empty
}
?>
