<?php
session_start();
include "../connection.php"; // Include your database connection file

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch selected flight details for rescheduling
$flight_details = null;
if (isset($_GET['new_flight_no'])) {
    $flight_no = $_GET['new_flight_no'];
    $query_flight = "SELECT * FROM flight WHERE flight_no = ?";
    $stmt_flight = $conn->prepare($query_flight);

    if ($stmt_flight) {
        $stmt_flight->bind_param("s", $flight_no);
        $stmt_flight->execute();
        $result_flight = $stmt_flight->get_result();
        $flight_details = $result_flight->fetch_assoc();
        $stmt_flight->close();
    }
}

// Fetch available seats for the new flight
$available_seats = [];
if (isset($flight_no)) {
    $query_seats = "SELECT s_id, s_no FROM seat WHERE status = 'available' AND flight_no = ?";
    $stmt_seats = $conn->prepare($query_seats);

    if ($stmt_seats) {
        $stmt_seats->bind_param("s", $flight_no);
        $stmt_seats->execute();
        $result_seats = $stmt_seats->get_result();

        while ($row = $result_seats->fetch_assoc()) {
            $available_seats[] = $row;
        }
        $stmt_seats->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Flight</title>
    <link rel="stylesheet" href="book_flight.css">
</head>
<body>
    <nav class="navbar">
        <a class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </nav>

    <div class="container">
        <div class="booking-section">
            <h2>Flight Details</h2>
            <?php if ($flight_details): ?>
                <p><strong>Flight No:</strong> <?= htmlspecialchars($flight_details['flight_no']) ?></p>
                <p><strong>Departure Time:</strong> <?= htmlspecialchars($flight_details['dep_time']) ?></p>
                <p><strong>Arrival Time:</strong> <?= htmlspecialchars($flight_details['arr_time']) ?></p>
                <p><strong>From:</strong> <?= htmlspecialchars($flight_details['from_']) ?></p>
                <p><strong>To:</strong> <?= htmlspecialchars($flight_details['to_']) ?></p>

                <h3>Select New Seat(s)</h3>
                <form action="process_booking.php" method="POST" id="rescheduleForm">
                    <input type="hidden" name="flight_no" value="<?= htmlspecialchars($flight_details['flight_no']) ?>">
                    <input type="hidden" name="previous_ticket_no" value="<?= htmlspecialchars($_GET['ticket_no']) ?>">
                    <input type="hidden" name="reschedule" value="true">

                    <label>Select Seat(s):</label>
                    <div class="seat-checkbox-container">
                        <?php if (!empty($available_seats)): ?>
                            <?php foreach ($available_seats as $seat): ?>
                                <label class="seat-checkbox">
                                    <input type="checkbox" name="seat_id[]" value="<?= htmlspecialchars($seat['s_id']) ?>">
                                    <?= htmlspecialchars($seat['s_no']) ?>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No seats available.</p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="book-btn" disabled id="confirmButton">Confirm & Reschedule</button>
                </form>
            <?php else: ?>
                <p>No flight details available. Please try again.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Enable the confirm button only if at least one seat is selected
        const seatCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const confirmButton = document.getElementById('confirmButton');

        seatCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                confirmButton.disabled = !Array.from(seatCheckboxes).some(checkbox => checkbox.checked);
            });
        });
    </script>
</body>
</html>
