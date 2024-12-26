<?php
include "../connection.php";

// Check if plane_id is passed via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plane_id'])) {
    $plane_id = $conn->real_escape_string($_POST['plane_id']);
    
    // Prepare and execute the DELETE query
    $sql = "DELETE FROM plane WHERE plane_id = '$plane_id'";
    if ($conn->query($sql) === TRUE) {
       header("location: planes.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Redirect back if accessed directly
    echo "<script>alert('Invalid request'); window.location.href = 'planes.php';</script>";
}

$conn->close();
?>
