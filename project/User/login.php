<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'project';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
        exit();
    }

    // Query to check the user's credentials
    $sql = "SELECT user_id, email, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Correct password, set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            header("Location: profile.php"); // Redirect to profile page
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML Login Form -->
<form action="login.php" method="post">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Login</button>
</form>
