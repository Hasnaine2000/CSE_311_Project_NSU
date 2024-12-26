<?php
include "../connection.php";

// Check if the user_id is passed via POST
if (isset($_POST['user_id'])) {
    $user_id = $conn->real_escape_string($_POST['user_id']);

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM user WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User has been banned (deleted) successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "Error banning (deleting) user: " . $conn->error;
    }
}

$conn->close();
?>
