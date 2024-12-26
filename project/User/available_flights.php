<?php
session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'project';

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$results = [];
$search = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

    // SQL query with JOIN to include airline_name
    $query = "SELECT flight.*, airline.airline_name FROM flight
              JOIN airline ON flight.airline_id = airline.airline_id
              WHERE 
                  `flight_no` LIKE '%$search%' OR 
                  `from_` LIKE '%$search%' OR 
                  `to_` LIKE '%$search%' OR 
                  DATE(dep_time) LIKE '%$search%' OR
                  airline.airline_name LIKE '%$search%'";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }

    // If the request is via AJAX, return JSON data
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            align-items: center;
            background-color: #333;
            padding: 20px;
        }

        .navbar .logo img {
            height: 50px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .search-container input {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-results {
            margin: 20px auto;
            width: 90%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        thead {
            background-color: #009900;
            color: #fff;
        }

        thead th {
            padding: 12px;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }

        tbody td {
            padding: 12px;
            text-align: center;
        }

        .book-btn {
            padding: 5px 10px;
            background-color: #0066cc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="profile.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
    </nav>

    <div class="search-container">
        <input type="text" id="search-bar" placeholder="Search flights..." />
    </div>

    <div class="search-results">
        <h2>Available Flights</h2>
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
            <tbody id="flights-table-body">
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $flight): ?>
                        <tr>
                            <td><?= htmlspecialchars($flight['flight_no']) ?></td>
                            <td><?= htmlspecialchars($flight['airline_name']) ?></td>
                            <td><?= htmlspecialchars($flight['dep_time']) ?></td>
                            <td><?= htmlspecialchars($flight['arr_time']) ?></td>
                            <td><?= htmlspecialchars($flight['from_']) ?></td>
                            <td><?= htmlspecialchars($flight['to_']) ?></td>
                            <td>
                                <a href="book_flight.php?flight_no=<?= urlencode($flight['flight_no']) ?>" class="book-btn">Book</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No flights found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('flights-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`?search=${query}&ajax=1`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = "";
                    if (data.length === 0) {
                        tableBody.innerHTML = "<tr><td colspan='7'>No flights found.</td></tr>";
                    } else {
                        data.forEach(flight => {
                            const row = `
                                <tr>
                                    <td>${flight.flight_no}</td>
                                    <td>${flight.airline_name}</td>
                                    <td>${flight.dep_time}</td>
                                    <td>${flight.arr_time}</td>
                                    <td>${flight.from_}</td>
                                    <td>${flight.to_}</td>
                                    <td>
                                        <a href="book_flight.php?flight_no=${encodeURIComponent(flight.flight_no)}" class="book-btn">Book</a>
                                    </td>
                                </tr>`;
                            tableBody.innerHTML += row;
                        });
                    }
                });
        });
    </script>
</body>
</html>
