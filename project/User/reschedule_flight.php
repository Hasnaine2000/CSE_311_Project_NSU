<?php
include "../connection.php"; // Include your database connection file
session_start();

// Fetch user ID from session (assuming user is logged in)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the ticket details from the URL
$ticket_no = $_GET['ticket_no'] ?? null;
$from_location = $_GET['from_location'] ?? null;
$to_location = $_GET['to_location'] ?? null;

if (!$ticket_no || !$from_location || !$to_location) {
    echo "Missing ticket information.";
    exit;
}

// Prepare the SQL query to fetch available flights to the same destination along with the arrival time and airline name
$sql = "SELECT f.flight_no, a.airline_name, f.dep_time, f.arr_time, f.from_ AS from_location, f.to_ AS to_location
        FROM flight f
        JOIN airline a ON f.airline_id = a.airline_id
        WHERE f.to_ = ? AND f.from_ = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('SQL error: ' . $conn->error);  // Check if query preparation failed
}

$stmt->bind_param("ss", $to_location, $from_location); // Binding the parameters

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Flight</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
            color: #fff;
        }

        .table-container {
            margin: 30px auto;
            width: 90%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #009900;
            color: #fff;
        }

        thead th {
            padding: 12px;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }

        tbody td {
            padding: 12px;
            text-align: left;
        }

        .action-btn {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .book-btn {
            background-color: #007bff; /* Blue color */
            color: #fff;
        }

        .logo img {
            height: 70px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="profile.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </div>

    <!-- Available Flights Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Flight No</th>
                    <th>Airline</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Insert the rescheduling action into the reschedule table
                        // This will log that the user is rescheduling their flight.
                        $r_status = 'Pending';  // The status can be updated later based on the flight booking result.
                        $current_date = date('Y-m-d');  // Current date
                        $current_time = date('H:i:s');  // Current time

                        // Insert the reschedule record
                        $reschedule_query = "INSERT INTO reschedule (date, time, r_status, ticket_no) VALUES (?, ?, ?, ?)";
                        $reschedule_stmt = $conn->prepare($reschedule_query);
                        $reschedule_stmt->bind_param("ssss", $current_date, $current_time, $r_status, $ticket_no);
                        $reschedule_stmt->execute();

                        // Booking button with redirection to res_book_flight.php
                        echo "<tr>
                            <td>{$row['flight_no']}</td>
                            <td>{$row['airline_name']}</td>
                            <td>{$row['dep_time']}</td>
                            <td>{$row['arr_time']}</td>
                            <td>{$row['from_location']}</td>
                            <td>{$row['to_location']}</td>
                            <td><a href='res_book_flight.php?ticket_no={$ticket_no}&new_flight_no={$row['flight_no']}' class='action-btn book-btn'>Book</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No available flights found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
