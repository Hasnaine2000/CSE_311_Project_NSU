<?php
include "../connection.php";

// Check if flight_no is passed via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flight_no'])) {
    $flight_no = $conn->real_escape_string($_POST['flight_no']);
    
    // Prepare and execute the DELETE query
    $sql = "DELETE FROM flight WHERE flight_no = '$flight_no'";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the main flights page with a success message
        header("location: flights.php");
    } else {
        // Redirect back to the main flights page with an error message
        header("Location: flights.php?message=Error deleting flight: " . $conn->error);
    }
} else {
    // Redirect back if accessed directly
    header("Location: flights.php?message=Invalid request");
}
?>
