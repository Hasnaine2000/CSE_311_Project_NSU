<?php
include("connection.php");

// Start the session
session_start();

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check user credentials
    $sql = "SELECT * FROM `user` WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        // Store user_id in session
        $_SESSION['user_id'] = $user['user_id'];

        // Redirect to the profile page in the 'user' folder
        header("Location: user/profile.php");
        exit();
    } else {
        // Incorrect credentials
        echo "Incorrect email or password";
    }
}
?>
