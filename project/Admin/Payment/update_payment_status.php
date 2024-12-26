<?php
include "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['p_id']) && isset($_POST['status'])) {
    $p_id = $_POST['p_id'];
    $status = $_POST['status'];

    // Update the status of the payment
    $update_query = "UPDATE payment SET status = '$status' WHERE p_id = '$p_id'";
    
    if ($conn->query($update_query)) {
        // If the payment status is updated to "Completed", update the ticket status to "Booked"
        if ($status == 'Completed') {
            // Get the ticket number associated with this payment (assuming ticket_no is in the payment table)
            $ticket_query = "SELECT ticket_no FROM payment WHERE p_id = '$p_id'";
            $ticket_result = $conn->query($ticket_query);

            if ($ticket_result->num_rows > 0) {
                $ticket_row = $ticket_result->fetch_assoc();
                $ticket_no = $ticket_row['ticket_no'];

                // Update the ticket status to "Booked"
                $update_ticket_query = "UPDATE ticket SET t_status = 'Booked' WHERE ticket_no = '$ticket_no'";

                if ($conn->query($update_ticket_query)) {
                    echo "<script>window.location.href = 'payments.php';</script>"; // Redirect to the payments page
                } else {
                    echo "Error updating ticket status.";
                }
            } else {
                echo "Ticket not found for this payment.";
            }
        } else {
            echo "<script>window.location.href = 'payments.php';</script>"; // Redirect to the payments page if not "Completed"
        }
    } else {
        echo "Error updating payment status.";
    }
}

$conn->close();
?>
