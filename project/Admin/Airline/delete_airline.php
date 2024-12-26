<?php
include "../connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['airline_id'])) {
    $airline_id = $conn->real_escape_string($_POST['airline_id']);
    $sql = "DELETE FROM airline WHERE airline_id = '$airline_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: airlines.php?message=Airline deleted successfully");
    } else {
        header("Location: airlines.php?message=Error deleting airline: " . $conn->error);
    }
} else {
    header("Location: airlines.php?message=Invalid request");
}
?>
