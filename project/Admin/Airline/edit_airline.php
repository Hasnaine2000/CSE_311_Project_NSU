<?php
include "../connection.php";

// Fetch airline data if `airline_id` is provided
if (isset($_POST['airline_id'])) {
    $airline_id = $conn->real_escape_string($_POST['airline_id']);
    $sql = "SELECT * FROM airline WHERE airline_id = '$airline_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $airline = $result->fetch_assoc();
    } else {
        die("Airline not found.");
    }
}

// Handle form submission to update airline details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $airline_id = $conn->real_escape_string($_POST['airline_id']);
    $airline_name = $conn->real_escape_string($_POST['airline_name']);
    $contact_info = $conn->real_escape_string($_POST['contact_info']);

    $update_sql = "UPDATE airline 
                   SET airline_name = '$airline_name', contact_info = '$contact_info' 
                   WHERE airline_id = '$airline_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Airline details updated successfully!'); window.location.href = 'airlines.php';</script>";
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
    <title>Edit Airline</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #333;
            padding: 20px;
            color: #fff;
        }

        .navbar .logo img {
            height: 50px;
            cursor: pointer;
        }

        .navbar .links {
            margin-left: auto;
        }

        .navbar .links a {
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

        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #009900;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #006600;
        }

        .cancel {
            background-color: #cc0000;
        }

        .cancel:hover {
            background-color: #990000;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>

        <div class="links">
            <a href="airlines.php">Manage Airlines</a>
        </div>
    </div>

    <!-- Edit Airline Form -->
    <div class="container">
        <h1>Edit Airline</h1>
        <form method="POST" action="edit_airline.php">
            <label for="airline_id">Airline ID</label>
            <input type="number" id="airline_id" name="airline_id" value="<?php echo $airline['airline_id']; ?>" readonly>

            <label for="airline_name">Airline Name</label>
            <input type="text" id="airline_name" name="airline_name" value="<?php echo $airline['airline_name']; ?>" required>

            <label for="contact_info">Contact Info</label>
            <input type="text" id="contact_info" name="contact_info" value="<?php echo $airline['contact_info']; ?>" required>

            <button type="submit" name="update">Update Airline</button>
            <a href="airlines.php"><button type="button" class="cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>
