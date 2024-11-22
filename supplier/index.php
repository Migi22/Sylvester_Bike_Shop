<?php
// Include database connection
include('../config/db_connection.php');

// Start the session to retrieve the message
session_start();

// Fetch all suppliers from the database
$sql = "SELECT * FROM supplier";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Suppliers - Sylvester's Bike Shop</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="/Sylvester_Bike_Shop">Back to Menu</a></li>
            <li><a href="add.php">Add Supplier</a></li>
        </ul>
    </nav>

    <h2>All Suppliers</h2>

    <!-- Display success message if available -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?> <!-- Clear the message after displaying -->
    <?php endif; ?>

    <?php
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Supplier's Name</th>
                    <th>Contact Info</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row['supplier_id'] . "</td>
                    <td>" . $row['supplier_name'] . "</td>
                    <td>" . $row['supplier_contact_info'] . "</td>
                    <td>
                        <a href='edit.php?id=" . $row['supplier_id'] . "'>Edit</a> |
                        <a href='delete.php?id=" . $row['supplier_id'] . "'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No suppliers found.</p>";  // Message when table is empty
    }
    ?>

</body>
</html>
