<?php
session_start();
include("connection.php");

if(isset($_POST["submit"])){
    $id = $_POST["id"];
    $password = $_POST["password"];

    // Query to check if admin credentials are correct
    $sql = "SELECT * FROM `admin_login` WHERE admin_id = '$id' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){   
        // Start session and store admin's login state
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $id;
        header("location: homepage.php"); // Redirect to admin dashboard (home page)
    } else {
        echo "<script>alert('Error: Incorrect ID or Password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.html" class="logo">
            <img src="images/logo.png" alt="Website Logo">
        </a>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <form action="login.php" method="post">
                <input type="text" name="id" class="input-field" placeholder="Admin Username" required><br>
                <input type="password" name="password" class="input-field" placeholder="Password" required><br>
                <button type="submit" name="submit" class="login-btn">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>
