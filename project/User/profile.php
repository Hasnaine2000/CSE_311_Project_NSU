<?php
session_start();

// Include the external connection file
include '../connection.php'; // Replace with the actual path

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT us_f_name, us_m_name, us_l_name, email, DOB, phone_no FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <nav class="navbar">
        <a class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
        <div class="nav-links">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-box">
            <h2>Your Profile</h2>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['us_f_name']); ?></p>
            <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($user['us_m_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['us_l_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['DOB']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_no']); ?></p>
            <div class="edit-button-container">
                <a href="edit_info.php" class="edit-btn">Edit Info</a>
            </div>
        </div>

        <div class="button-container">
            <a href="available_flights.php" class="btn">Book Flight</a>
            <a href="history.php" class="btn">Your History</a>
        </div>
    </div>
</body>
</html>
