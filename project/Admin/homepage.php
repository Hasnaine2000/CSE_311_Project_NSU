<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("location: login.php"); // Redirect to login if not logged in
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy(); // Destroy session to log out
    header("location: login.php"); // Redirect to login page after logout
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="images/logo.png" alt="Website Logo">
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="button-container">
            <a href="flight/addflight.html" class="dashboard-btn">Add Flight</a>
            <a href="flight/flights.php" class="dashboard-btn">Manage Flight</a>
            <a href="pilot/addpilot.html" class="dashboard-btn">Add Pilot</a>
            <a href="pilot/pilot.php" class="dashboard-btn">Manage Pilots</a>
            <a href="plane/addplane.html" class="dashboard-btn">Add Plane</a>
            <a href="plane/planes.php" class="dashboard-btn">Manage Planes</a>
            <a href="airline/addairline.html" class="dashboard-btn">Add Airline</a>
            <a href="airline/airlines.php" class="dashboard-btn">Manage Airline</a>
            
            <a href="Payment/payments.php" class="dashboard-btn">Verify Payments</a>
            <a href="User/manage_users.php" class="dashboard-btn">Users</a>
            <a href="Queries/queries.php" class="dashboard-btn">Reports</a>
            <a href="?logout=true" class="dashboard-btn logout-btn">Logout</a>
        </div>
    </div>
</body>

</html>
