<?php
include "../connection.php"; // Include your database connection file
session_start();

$ticket_no = $_GET['ticket_no'] ?? null;
$price = $_GET['price'] ?? null;

if (!$ticket_no || !$price) {
    // Redirect back to the ticket history page if required data is missing
    header("Location: history.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'];
    $amount = $price; // Set amount to ticket price
    $status = "Pending";
    
    // Insert payment details into the "payment" table
    $sql = "INSERT INTO `payment`(`amount`, `method`, `status`, `ticket_no`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Corrected bind_param
    $stmt->bind_param("dssi", $amount, $method, $status, $ticket_no); // d for double, s for string, i for integer
    
    if ($stmt->execute()) {
        echo "<script>alert('Payment initiated successfully. Please complete the process.');</script>";
        header("Location: history.php");
        exit;
    } else {
        // Echo the SQL error
        echo "<script>alert('Error initiating payment: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN link -->
    <style>
        /* Global styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg'); /* Set the background image */
            background-size: cover; /* Ensure the image covers the entire page */
            background-position: center; /* Center the image */
            height: 100%;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: flex-start; /* Align logo to the left */
            align-items: center;
            background-color: #333333; /* Darker navbar background */
            padding: 20px 40px; /* Enlarged padding */
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 70px; /* Adjust size for the logo */
            cursor: pointer; /* Make logo clickable */
        }

        /* Payment Page Styles */
        .payment-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(244, 244, 244, 0.8); /* Slight transparent background for the payment box */
        }

        .payment-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .payment-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .input-field:focus, select:focus {
            border-color: #007700;
            outline: none;
        }
        .input-field, select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

       

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #009900;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #006600;
        }

        .info {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.html" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </nav>

    <!-- Payment Page Content -->
    <div class="payment-container">
        <div class="payment-box">
            <h2>Enter Payment Details</h2>
            <form method="POST">
                <label for="method"></label>
                <select name="method" id="method" class="input-field" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="Mobile Banking">Mobile Banking</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
                <div class="info" id="info"></div>
                
                
                <button type="submit" class="submit-btn" onclick="alert('Your payment is currently pending, please wait for our admin panel to confirm your payment! Then you can print your ticket. Thank you!')">Proceed</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Payment Method Info -->
    <script>
        const methodSelect = document.getElementById('method');
        const infoDiv = document.getElementById('info');

        methodSelect.addEventListener('change', () => {
            const method = methodSelect.value;
            if (method === 'Mobile Banking') {
                infoDiv.textContent = 'Please send the amount to our Mobile Banking number: +880123456789.';
            } else if (method === 'Bank Transfer') {
                infoDiv.textContent = 'Please transfer the amount to our Bank Account: 1234567890 (ABC Bank).';
            }  else {
                infoDiv.textContent = '';
            }
        });
    </script>
</body>

</html>
