<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Queries</title>
    <link rel="stylesheet" href="queries.css"> <!-- Reuse your existing CSS file -->
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </nav>

    <!-- Queries Display Section -->
    <div class="queries-container">
        <h2>Customer Queries</h2>
        <?php
            include("../connection.php");  // Include the database connection
            
            $sql = "SELECT * FROM queries"; // SQL query to fetch all queries
            $result = $conn->query($sql); // Execute the query

            if ($result->num_rows > 0) {
                echo "<table class='queries-table'>";
                echo "<tr><th>Email</th><th>Query</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['query_text']) . "</td>";
                   
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No queries found.</p>";
            }
            $conn->close();
        ?>
    </div>

</body>
</html>
