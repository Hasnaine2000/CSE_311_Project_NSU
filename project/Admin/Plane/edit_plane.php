<?php
include "../connection.php";

// Fetch plane data if `plane_id` is provided
if (isset($_POST['plane_id'])) {
    $plane_id = $conn->real_escape_string($_POST['plane_id']);
    $sql = "SELECT * FROM plane WHERE plane_id = '$plane_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $plane = $result->fetch_assoc();
    } else {
        die("Plane not found.");
    }
}

// Handle form submission to update plane details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $plane_id = $conn->real_escape_string($_POST['plane_id']);
    $model = $conn->real_escape_string($_POST['model']);
    $capacity = $conn->real_escape_string($_POST['capacity']);
    $airline_id = $conn->real_escape_string($_POST['airline_id']);

    $update_sql = "UPDATE plane 
                   SET model = '$model', capacity = '$capacity', airline_id = '$airline_id' 
                   WHERE plane_id = '$plane_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Plane details updated successfully!'); window.location.href = 'planes.php';</script>";
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
    <title>Edit Plane</title>
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

        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
        <div class="links">
            <a href="planes.php">Manage Planes</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Edit Plane</h1>
        <form method="POST" action="edit_plane.php">
            <label for="plane_id">Plane ID</label>
            <input type="text" id="plane_id" name="plane_id" value="<?php echo $plane['plane_id']; ?>" readonly>

            <label for="model">Model</label>
            <input type="text" id="model" name="model" value="<?php echo $plane['model']; ?>" required>

            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $plane['capacity']; ?>" required>

            <label for="airline_id">Airline ID</label>
            <input type="text" id="airline_id" name="airline_id" value="<?php echo $plane['airline_id']; ?>" required>

            <button type="submit" name="update">Update Plane</button>
            <a href="planes.php"><button type="button" class="cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>
