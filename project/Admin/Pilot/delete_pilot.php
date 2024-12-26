<?php
include "../connection.php";

// Check if `pilot_id` is passed via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pilot_id'])) {
    $pilot_id = $conn->real_escape_string($_POST['pilot_id']);
    
    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // First, delete from the captain table if the pilot is a captain
        $delete_captain_sql = "DELETE FROM captain WHERE pilot_id = '$pilot_id'";
        $conn->query($delete_captain_sql);

        // Now, delete from the pilot table
        $delete_pilot_sql = "DELETE FROM pilot WHERE pilot_id = '$pilot_id'";
        $conn->query($delete_pilot_sql);

        // Commit the transaction
        $conn->commit();

        // Redirect with success message
        header("location: pilot.php");
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $conn->rollback();
        echo "Error deleting pilot: " . $e->getMessage();
    }
} else {
    // Redirect back if accessed directly without a pilot_id
    echo "<script>alert('Invalid request'); window.location.href = 'pilot.php';</script>";
}

$conn->close();
?>
