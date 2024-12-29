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

// Get the form data
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);

// Validate the data (you can add more validations here)
if (empty($first_name) || empty($last_name) || empty($dob) || empty($phone_no)) {
    echo "Please fill in all the fields.";
    exit();
}




// Update the database with the new information
$sql = "UPDATE user SET us_f_name = ?, us_m_name = ?, us_l_name = ?, DOB = ?, phone_no = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $first_name, $middle_name, $last_name, $dob, $phone_no, $user_id);

// Execute the update query
if ($stmt->execute()) {
    
    echo "Profile updated successfully!";
    // Optionally redirect to the profile page after update
    header("Location: profile.php");
    exit();
} else {
    echo "Error updating profile: " . $stmt->error;
}





$stmt->close();
$conn->close();
?>
