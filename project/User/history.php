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

// Fetch tickets and corresponding flight departure time for the logged-in user
$sql = "SELECT t.ticket_no, t.flight_no, t.from_location, t.to_location, f.dep_time, t.price, t.t_status
        FROM ticket t
        JOIN flight f ON t.flight_no = f.flight_no
        WHERE t.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ticket History</title>
    <style>
        body,
        html {
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

        .pay-btn {
            background-color: #007bff;
            color: #fff;
        }

        .print-btn {
            background-color: #28a745;
            color: #fff;
        }

        .reschedule-btn {
            background-color: #f39c12;
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

    <!-- Ticket Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ticket No</th>
                    <th>Flight No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Departure Date and Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $actionButton = '';

                        // Check if the ticket has a pending payment in the payment table
                        $paymentQuery = "SELECT status FROM payment WHERE ticket_no = ? AND status = 'pending'";
                        $paymentStmt = $conn->prepare($paymentQuery);
                        $paymentStmt->bind_param("i", $row['ticket_no']);
                        $paymentStmt->execute();
                        $paymentResult = $paymentStmt->get_result();

                        if ($paymentResult->num_rows > 0) {
                            // Payment is pending
                            $actionButton = "<span style='color: red; font-weight: bold;'>Payment Pending</span>";
                        } else {
                            // Determine actions based on ticket status
                            if ($row['t_status'] === 'Pending') {
                                $actionButton = "<a href='pay.php?ticket_no={$row['ticket_no']}&price={$row['price']}' class='action-btn pay-btn'>Pay Now</a>";
                            } elseif ($row['t_status'] === 'Booked') {
                                $actionButton = "<a href='print_ticket.php?ticket_no={$row['ticket_no']}' target='_blank' class='action-btn print-btn'>Print Ticket</a>";
                                $actionButton .= " <a href='reschedule_flight.php?ticket_no={$row['ticket_no']}&from_location={$row['from_location']}&to_location={$row['to_location']}' class='action-btn reschedule-btn'>Reschedule</a>";
                            }
                        }

                        echo "<tr>
                            <td>{$row['ticket_no']}</td>
                            <td>{$row['flight_no']}</td>
                            <td>{$row['from_location']}</td>
                            <td>{$row['to_location']}</td>
                            <td>{$row['dep_time']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['t_status']}</td>
                            <td>$actionButton</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No tickets found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
