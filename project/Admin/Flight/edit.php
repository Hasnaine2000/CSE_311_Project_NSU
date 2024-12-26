<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch flight data if `flight_no` is provided
if (isset($_POST['flight_no'])) {
    $flight_no = $conn->real_escape_string($_POST['flight_no']);
    $sql = "SELECT * FROM flight WHERE flight_no = '$flight_no'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $flight = $result->fetch_assoc();
    } else {
        die("Flight not found.");
    }
}

// Handle form submission to update flight details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $flight_no = $conn->real_escape_string($_POST['flight_no']);
    $from_ = $conn->real_escape_string($_POST['from_']);
    $to_ = $conn->real_escape_string($_POST['to_']);
    $dep_time = $conn->real_escape_string($_POST['dep_time']);
    $arr_time = $conn->real_escape_string($_POST['arr_time']);
    $plane_id = $conn->real_escape_string($_POST['plane_id']);
    $airline_id = $conn->real_escape_string($_POST['airline_id']);

    $update_sql = "UPDATE flight 
                   SET from_ = '$from_', to_ = '$to_', dep_time = '$dep_time', 
                       arr_time = '$arr_time', plane_id = '$plane_id', airline_id = '$airline_id' 
                   WHERE flight_no = '$flight_no'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Flight details updated successfully!'); window.location.href = 'flights.php';</script>";
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
    <title>Edit Flight</title>
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

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
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

        input[type="text"], input[type="datetime-local"], input[type="number"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .logo img {
    height: 50px;
    cursor: pointer;
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
            <a href="flights.php">Manage Flights</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Edit Flight</h1>
        <form method="POST" action="edit.php">
            <label for="flight_no">Flight No</label>
            <input type="text" id="flight_no" name="flight_no" value="<?php echo $flight['flight_no']; ?>" readonly>

            <label for="from_">From</label>
            <input type="text" id="from_" name="from_" value="<?php echo $flight['from_']; ?>" required>

            <label for="to_">To</label>
            <input type="text" id="to_" name="to_" value="<?php echo $flight['to_']; ?>" required>

            <label for="dep_time">Departure Time</label>
            <input type="datetime-local" id="dep_time" name="dep_time" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['dep_time'])); ?>" required>

            <label for="arr_time">Arrival Time</label>
            <input type="datetime-local" id="arr_time" name="arr_time" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['arr_time'])); ?>" required>

            <label for="plane_id">Plane ID</label>
            <input type="number" id="plane_id" name="plane_id" value="<?php echo $flight['plane_id']; ?>" required>

            <label for="airline_id">Airline ID</label>
            <input type="number" id="airline_id" name="airline_id" value="<?php echo $flight['airline_id']; ?>" required>

            <button type="submit" name="update">Update Flight</button>
            <a href="flights.php"><button type="button" class="cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>
