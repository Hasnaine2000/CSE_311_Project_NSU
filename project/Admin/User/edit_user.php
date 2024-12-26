<?php
include "../connection.php";

// Fetch user data if `user_id` is provided
if (isset($_GET['user_id'])) {
    $user_id = $conn->real_escape_string($_GET['user_id']);
    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
}

// Handle form submission to update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $us_f_name = $conn->real_escape_string($_POST['us_f_name']);
    $us_m_name = $conn->real_escape_string($_POST['us_m_name']);
    $us_l_name = $conn->real_escape_string($_POST['us_l_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_no = $conn->real_escape_string($_POST['phone_no']);
    $DOB = $conn->real_escape_string($_POST['DOB']);
    $password = $conn->real_escape_string($_POST['password']);

    $update_sql = "UPDATE user 
                   SET us_f_name = '$us_f_name', us_m_name = '$us_m_name', us_l_name = '$us_l_name', 
                       email = '$email', phone_no = '$phone_no', DOB = '$DOB', password = '$password' 
                   WHERE user_id = '$user_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('User details updated successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
            color: #fff;
        }

        .navbar .logo img {
            height: 50px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-size: 16px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="password"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004d99;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
        <a href="manage_users.php">Back to Manage Users</a>
    </div>

    <!-- Edit User Form -->
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST" action="edit_user.php">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

            <label for="us_f_name">First Name</label>
            <input type="text" name="us_f_name" value="<?php echo $user['us_f_name']; ?>" required>

            <label for="us_m_name">Middle Name</label>
            <input type="text" name="us_m_name" value="<?php echo $user['us_m_name']; ?>">

            <label for="us_l_name">Last Name</label>
            <input type="text" name="us_l_name" value="<?php echo $user['us_l_name']; ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label for="phone_no">Phone Number</label>
            <input type="number" name="phone_no" value="<?php echo $user['phone_no']; ?>" required>

            <label for="DOB">Date of Birth</label>
            <input type="date" name="DOB" value="<?php echo $user['DOB']; ?>" required>

            

            <button type="submit" name="update">Update User</button>
        </form>
    </div>

</body>
</html>
