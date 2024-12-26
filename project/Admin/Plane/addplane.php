<?php
// Include the connection file to connect to the database
include('../connection.php');

if (isset($_POST['submit'])) {
    // Get data from the form
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $airline_id = $_POST['airline_id'];

    // SQL query to insert the data into the plane table
    $sql = "INSERT INTO plane (model, capacity, airline_id) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sii", $model, $capacity, $airline_id); // 's' for string, 'i' for integer

        // Execute the query
        if ($stmt->execute()) {
            header("location: ../homepage.php");
            echo "<script>alert('Plane added successfully!');</script>";
            // Optionally, redirect to another page
            
        } else {
            echo "<script>alert('Error adding plane. Please try again.');</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the SQL statement.');</script>";
    }

    // Close the connection
    $conn->close();
}
?>
