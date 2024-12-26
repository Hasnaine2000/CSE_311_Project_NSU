<?php
include "../connection.php"; // Include your database connection file
session_start();

// Fetch ticket_no from GET parameters
$ticket_no = $_GET['ticket_no'] ?? null;

if (!$ticket_no) {
    echo "Invalid ticket number.";
    exit;
}

// Fetch ticket details along with user, flight, plane, airline, and seat information
$sql = "
    SELECT 
        t.ticket_no,
        t.from_location,
        t.to_location,
        t.date,
        t.price,
        t.t_status,
        u.user_id,
        u.us_f_name,
        u.us_m_name,
        u.us_l_name,
        u.email,
        u.phone_no,
        f.flight_no,
        f.dep_time,
        f.arr_time,
        p.model AS plane_model,
        a.airline_name,
        f.from_ AS flight_from,
        f.to_ AS flight_to,
        GROUP_CONCAT(s.s_no SEPARATOR ', ') AS seat_numbers
    FROM 
        ticket t
    JOIN 
        user u 
    ON 
        t.user_id = u.user_id
    JOIN 
        flight f
    ON 
        t.flight_no = f.flight_no
    JOIN 
        plane p
    ON 
        f.plane_id = p.plane_id
    JOIN 
        airline a
    ON 
        f.airline_id = a.airline_id
    LEFT JOIN 
        seat s
    ON 
        t.ticket_no = s.ticket_no
    WHERE 
        t.ticket_no = ?
    GROUP BY 
        t.ticket_no";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Ticket not found.";
    exit;
}

$ticket = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #000; /* Ensure all text is black */
        }

        .ticket-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #000; /* Set header text to black */
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h3 {
            border-bottom: 2px solid #000; /* Set section header underline to black */
            padding-bottom: 5px;
            color: #000; /* Set section header text to black */
            margin-bottom: 15px;
        }

        .details p {
            margin: 5px 0;
            font-size: 16px;
            line-height: 1.5;
            color: #000; /* Ensure all detail text is black */
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 10px;
            background: #000; /* Set button background to black */
            color: #fff; /* Set button text to white for contrast */
            text-align: center;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-print:hover {
            background: #333; /* Slightly lighter black for hover */
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 70px;
        }
    </style>
</head>

<body>
    <div class="ticket-container">
        <!-- Logo -->
        <div class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </div>

        <h1>Flight Ticket</h1>

        <!-- Passenger Information Section -->
        <div class="section">
            <h2>Passenger Information</h2>
            <div class="details">
                <p><strong>Passenger ID:</strong> <?= htmlspecialchars($ticket['user_id']) ?></p>
                <p><strong>Full Name:</strong> <?= htmlspecialchars(trim($ticket['us_f_name'] . ' ' . $ticket['us_m_name'] . ' ' . $ticket['us_l_name'])) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($ticket['phone_no']) ?></p>
            </div>
        </div>

        <!-- Ticket Information Section -->
        <div class="section">
            <h2>Ticket Information</h2>
            <div class="details">
                <p><strong>Ticket Number:</strong> <?= htmlspecialchars($ticket['ticket_no']) ?></p>
                <p><strong>Price:</strong> $<?= htmlspecialchars($ticket['price']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($ticket['t_status']) ?></p>
                <p><strong>Seat Numbers:</strong> <?= htmlspecialchars($ticket['seat_numbers']) ?></p>
            </div>
        </div>

        <!-- Flight Information Section -->
        <div class="section">
            <h2>Flight Information</h2>
            <div class="details">
                <p><strong>Flight Number:</strong> <?= htmlspecialchars($ticket['flight_no']) ?></p>
                <p><strong>Departure Time:</strong> <?= htmlspecialchars($ticket['dep_time']) ?></p>
                <p><strong>Arrival Time:</strong> <?= htmlspecialchars($ticket['arr_time']) ?></p>
                <p><strong>Plane Model:</strong> <?= htmlspecialchars($ticket['plane_model']) ?></p>
                <p><strong>Airline Name:</strong> <?= htmlspecialchars($ticket['airline_name']) ?></p>
                <p><strong>From:</strong> <?= htmlspecialchars($ticket['flight_from']) ?></p>
                <p><strong>To:</strong> <?= htmlspecialchars($ticket['flight_to']) ?></p>
            </div>
        </div>

        <!-- Print Button -->
        <button class="btn-print" onclick="window.print()">Print</button>
    </div>
</body>

</html>
