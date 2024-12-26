<?php
include "../connection.php";

// Fetch pilot details if `pilot_id` is provided
if (isset($_POST['pilot_id'])) {
    $pilot_id = $conn->real_escape_string($_POST['pilot_id']);
    $sql = "SELECT pilot.*, captain.captain_id 
            FROM pilot
            LEFT JOIN captain ON pilot.pilot_id = captain.pilot_id
            WHERE pilot.pilot_id = '$pilot_id'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $pilot = $result->fetch_assoc();
    } else {
        die("Pilot not found.");
    }
}

// Handle form submission to update pilot details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $pilot_id = $conn->real_escape_string($_POST['pilot_id']);
    $pi_f_name = $conn->real_escape_string($_POST['pi_f_name']);
    $pi_m_name = $conn->real_escape_string($_POST['pi_m_name']);
    $pi_l_name = $conn->real_escape_string($_POST['pi_l_name']);
    $licence_no = $conn->real_escape_string($_POST['licence_no']);
    $flight_hr = $conn->real_escape_string($_POST['flight_hr']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $captain_id = $conn->real_escape_string($_POST['captain_id']);

    // Update the pilot information
    $update_sql = "UPDATE pilot
                   SET pi_f_name = '$pi_f_name', pi_m_name = '$pi_m_name', pi_l_name = '$pi_l_name', 
                       licence_no = '$licence_no', flight_hr = '$flight_hr', salary = '$salary'
                   WHERE pilot_id = '$pilot_id'";

    if ($conn->query($update_sql) === TRUE) {
        // Update captain info if available
        if (!empty($captain_id)) {
            $update_captain_sql = "UPDATE captain 
                                   SET captain_id = '$captain_id' 
                                   WHERE pilot_id = '$pilot_id'";

            $conn->query($update_captain_sql);
        }
        
        echo "<script>alert('Pilot details updated successfully!'); window.location.href = 'pilot.php';</script>";
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
    <title>Edit Pilot</title>
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
            <a href="pilot.php">Manage Pilots</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Edit Pilot</h1>
        <form method="POST" action="edit_pilot.php">
            <label for="pilot_id">Pilot ID</label>
            <input type="text" id="pilot_id" name="pilot_id" value="<?php echo $pilot['pilot_id']; ?>" readonly>

            <label for="pi_f_name">First Name</label>
            <input type="text" id="pi_f_name" name="pi_f_name" value="<?php echo $pilot['pi_f_name']; ?>" required>

            <label for="pi_m_name">Middle Name</label>
            <input type="text" id="pi_m_name" name="pi_m_name" value="<?php echo $pilot['pi_m_name']; ?>">

            <label for="pi_l_name">Last Name</label>
            <input type="text" id="pi_l_name" name="pi_l_name" value="<?php echo $pilot['pi_l_name']; ?>" required>

            <label for="licence_no">Licence No</label>
            <input type="text" id="licence_no" name="licence_no" value="<?php echo $pilot['licence_no']; ?>" required>

            <label for="flight_hr">Flight Hours</label>
            <input type="number" id="flight_hr" name="flight_hr" value="<?php echo $pilot['flight_hr']; ?>" required>

            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" value="<?php echo $pilot['salary']; ?>" required>

            <label for="captain_id">Captain ID (if applicable)</label>
            <input type="text" id="captain_id" name="captain_id" value="<?php echo isset($pilot['captain_id']) ? $pilot['captain_id'] : ''; ?>">

            <button type="submit" name="update">Update Pilot</button>
            <a href="pilot.php"><button type="button" class="cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>
