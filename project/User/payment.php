<?php
session_start();

// Include the external connection file
include_once '../connection.php'; // Replace with actual path

// Retrieve flight and seat details from the GET request
$flight_no = $_GET['flight_no'] ?? null;
$seat_ids = explode(",", $_GET['seat_ids'] ?? []);
$seat_details = [];
$total_price = $_GET['total_price'] ?? 0;

// Fetch flight details
$flight_details = null;
$query_flight = "SELECT * FROM flight WHERE flight_no = ?";
$stmt_flight = $conn->prepare($query_flight);
if ($stmt_flight) {
    $stmt_flight->bind_param("s", $flight_no);
    $stmt_flight->execute();
    $result_flight = $stmt_flight->get_result();
    $flight_details = $result_flight->fetch_assoc();
    $stmt_flight->close();
}

// Fetch seat details, including prices
$query_seats = "SELECT s_no, price FROM seat WHERE s_id = ? AND flight_no = ?";
$stmt_seat = $conn->prepare($query_seats);
if ($stmt_seat) {
    foreach ($seat_ids as $seat_id) {
        $stmt_seat->bind_param("ss", $seat_id, $flight_no);
        $stmt_seat->execute();
        $result_seat = $stmt_seat->get_result();
        if ($seat = $result_seat->fetch_assoc()) {
            $seat_details[] = $seat;
        }
    }
    $stmt_seat->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
        <div class="nav-links">
            <!-- Additional Navbar Links Here -->
        </div>
    </nav>

    <!-- Payment Details -->
    <div class="container">
        <h2>Payment Details</h2>
        <?php if ($flight_details): ?>
            <p><strong>Flight No:</strong> <?= htmlspecialchars($flight_details['flight_no']) ?></p>
            <p><strong>Departure Time:</strong> <?= htmlspecialchars($flight_details['dep_time']) ?></p>
            <p><strong>Arrival Time:</strong> <?= htmlspecialchars($flight_details['arr_time']) ?></p>
            <p><strong>From:</strong> <?= htmlspecialchars($flight_details['from_']) ?></p>
            <p><strong>To:</strong> <?= htmlspecialchars($flight_details['to_']) ?></p>

            <h3>Selected Seats and Prices</h3>
            <ul>
                <?php foreach ($seat_details as $seat): ?>
                    <li><?= htmlspecialchars($seat['s_no']) ?> - $<?= number_format($seat['price'], 2) ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>Total Price: $<?= number_format($total_price, 2) ?></h3>

            <form action="profile.php">
                <input type="hidden" name="flight_no" value="<?= htmlspecialchars($flight_no) ?>">
                <input type="hidden" name="seat_ids" value="<?= htmlspecialchars(implode(",", $seat_ids)) ?>">
                <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
                <button type="submit" class="pay-btn" onclick="alert('Your flight is booked partially, Please confirm your payment from the History section!')">Book Now</button>

            </form>
        <?php else: ?>
            <p>Error fetching flight details. Please try again.</p>
        <?php endif; ?>
    </div>
</body>
</html>
