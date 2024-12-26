<?php
session_start();

// Include the external connection file
include_once '../connection.php'; // Replace with the actual path

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

// Retrieve flight, seat, and reschedule details from POST request
$flight_no = $_POST['flight_no'] ?? null;
$seat_ids = $_POST['seat_id'] ?? [];
$previous_ticket_no = $_POST['previous_ticket_no'] ?? null;
$is_reschedule = $_POST['reschedule'] ?? false;

// Redirect back if no flight or seats are selected
if (!$flight_no || empty($seat_ids)) {
    header("Location: book_flight.php?error=No seat selected");
    exit();
}

// Fetch user_id from the session
$user_id = $_SESSION['user_id'];

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

// Initialize total price
$total_price = 0;

// Calculate total price for selected seats
foreach ($seat_ids as $seat_id) {
    $query_seat = "SELECT price FROM seat WHERE s_id = ? AND flight_no = ?";
    $stmt_seat = $conn->prepare($query_seat);

    if ($stmt_seat) {
        $stmt_seat->bind_param("ss", $seat_id, $flight_no);
        $stmt_seat->execute();
        $result_seat = $stmt_seat->get_result();
        if ($seat = $result_seat->fetch_assoc()) {
            $total_price += $seat['price'];
        }
        $stmt_seat->close();
    }
}

// Handle Rescheduling Logic
if ($is_reschedule && $previous_ticket_no) {
    // Update the ticket status to 'Rescheduled'
    $query_update_ticket = "UPDATE ticket SET t_status = 'Rescheduled' WHERE ticket_no = ? AND user_id = ?";
    $stmt_update_ticket = $conn->prepare($query_update_ticket);
    if ($stmt_update_ticket) {
        $stmt_update_ticket->bind_param("ii", $previous_ticket_no, $user_id);
        $stmt_update_ticket->execute();
        $stmt_update_ticket->close();
    }

    // Mark previous seats as 'available'
    $query_update_seat = "UPDATE seat SET status = 'available', ticket_no = NULL WHERE ticket_no = ?";
    $stmt_update_seat = $conn->prepare($query_update_seat);
    if ($stmt_update_seat) {
        $stmt_update_seat->bind_param("i", $previous_ticket_no);
        $stmt_update_seat->execute();
        $stmt_update_seat->close();
    }
}

// Insert a new ticket for all selected seats
$query_ticket = "INSERT INTO ticket (from_location, to_location, date, price, t_status, flight_no, user_id) 
                 VALUES (?, ?, NOW(), ?, 'Pending', ?, ?)";
$stmt_ticket = $conn->prepare($query_ticket);

if ($stmt_ticket) {
    $stmt_ticket->bind_param("ssdss", 
        $flight_details['from_'], 
        $flight_details['to_'], 
        $total_price, 
        $flight_no, 
        $user_id
    );
    $stmt_ticket->execute();

    // Get the generated ticket_no
    $ticket_no = $conn->insert_id;

    $stmt_ticket->close();

    // Update each selected seat with the new ticket_no
    foreach ($seat_ids as $seat_id) {
        $query_update_seat = "UPDATE seat SET ticket_no = ?, status = 'booked' WHERE s_id = ?";
        $stmt_update_seat = $conn->prepare($query_update_seat);

        if ($stmt_update_seat) {
            $stmt_update_seat->bind_param("is", $ticket_no, $seat_id);
            $stmt_update_seat->execute();
            $stmt_update_seat->close();
        }
    }

    // Redirect to the payment page with the total price
    $seat_ids_encoded = urlencode(implode(",", $seat_ids));
    header("Location: payment.php?flight_no=$flight_no&seat_ids=$seat_ids_encoded&total_price=$total_price");
    exit();
} else {
    // Handle error if the ticket could not be created
    file_put_contents("debug.log", "Error creating ticket: " . $conn->error . "\n", FILE_APPEND);
    header("Location: book_flight.php?error=Unable to create ticket");
    exit();
}
?>
