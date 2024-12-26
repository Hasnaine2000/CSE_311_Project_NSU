<?php
// Start session to check if the user is logged in
session_start();

// Database connection
$host = 'localhost'; // Adjust this if your database is hosted elsewhere
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'project'; // Database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is stored in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT us_f_name, us_m_name, us_l_name, DOB, phone_no FROM user WHERE user_id = ?";
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_info.css"> <!-- Linking your CSS file -->
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
        <div class="nav-links">
            <a href="../login.html" class="logout-btn">Logout</a>
        </div>
    </nav>

    <!-- Edit Profile Page Content -->
    <div class="profile-container">
        <div class="profile-box">
            <h2>Edit Your Profile</h2>
            <!-- Edit Form -->
            <form action="update_info.php" method="POST">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['us_f_name']); ?>" required>

                <label for="middle_name">Middle Name:</label>
                <input type="text" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($user['us_m_name']); ?>" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['us_l_name']); ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['DOB']); ?>" required>

                <label for="phone_no">Phone Number:</label>
                <input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($user['phone_no']); ?>" required>

                <!-- Save Changes Button -->
                <button type="submit" class="edit-btn">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
