<?php
include "connection.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount']) && isset($_POST['method'])) {
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $status = "Pending"; // Status is automatically set to "Pending"

    // Insert the payment into the database
    $query = "INSERT INTO payment (amount, method, status) VALUES ('$amount', '$method', '$status')";
    if ($conn->query($query)) {
        echo "<script>alert('Payment added successfully!'); window.location.href = 'payments.php';</script>"; // Redirect to the payments page
    } else {
        echo "<script>alert('Error Adding Payment'); window.location.href = 'payments.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
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
            justify-content: flex-start;
            align-items: center;
            background-color: #333;
            padding: 20px;
            color: #fff;
        }

        .logo img {
            height: 50px;
            cursor: pointer;
        }

        .form-container {
            width: 50%;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group button {
            padding: 10px 20px;
            border: none;
            background-color: #009900;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }

        .form-group button:hover {
            background-color: #006600;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="index.html" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </div>

    <!-- Add Payment Form -->
    <div class="form-container">
        <h2>Add Payment</h2>
        <form method="POST" action="payments.php">
            <div class="form-group">
                <label for="method">Payment Method</label>
                <select name="method" id="method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="bkash">bkash</option>
                    <option value="Nagad">Nagad</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" required placeholder="Enter amount" min="1" step="0.01">
            </div>

            <div class="form-group">
                <button type="submit">Add Payment</button>
            </div>
        </form>
    </div>
</body>

</html>
