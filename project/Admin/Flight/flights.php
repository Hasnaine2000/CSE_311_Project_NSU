<?php
include "../connection.php";

// Fetch flights based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT * FROM flight";
if (!empty($search)) {
    $sql .= " WHERE flight_no LIKE '%$search%' OR from_ LIKE '%$search%' OR to_ LIKE '%$search%'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Information</title>
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
        .table-container {
            margin: 30px auto;
            width: 90%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            margin-left: auto;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        

        .logo img {
            height: 50px;
            cursor: pointer;
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
        .actions {
            display: flex;
            gap: 10px;
        }
        tbody td {
            padding: 12px;
            text-align: left;
        }

       

        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions .delete {
            background-color: #cc0000;
            color: #fff;
        }
        .actions .edit {
            background-color: #0066cc;
            color: #fff;
        }

        
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>

        <input type="text" id="search-bar" class="search-bar" placeholder="Search flights...">
    </div>

    <!-- Flight Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Flight No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Plane ID</th>
                    <th>Airline ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="flight-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
    <td>{$row['flight_no']}</td>
    <td>{$row['from_']}</td>
    <td>{$row['to_']}</td>
    <td>{$row['dep_time']}</td>
    <td>{$row['arr_time']}</td>
    <td>{$row['plane_id']}</td>
    <td>{$row['airline_id']}</td>
    <td class='actions'>
        <form method='POST' action='edit.php' style='display:inline;'>
            <input type='hidden' name='flight_no' value='{$row['flight_no']}'>
            <button type='submit' class='edit'>Edit</button>
        </form>
        <form id='deleteForm{$row['flight_no']}' method='POST' action='delete.php' style='display:inline;'>
            <input type='hidden' name='flight_no' value='{$row['flight_no']}'>
            <button type='button' class='delete' onclick='confirmDelete({$row['flight_no']})'>Delete</button>
        </form>
    </td>
</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No flights found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('flight-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`flights.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    // Extract table rows from the returned HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#flight-table-body').innerHTML;

                    // Update the table body
                    tableBody.innerHTML = newRows;
                });
        });
    </script>
    <script>
        function confirmDelete(flightNo) {
            // Display a confirmation popup
            var result = confirm("Are you sure you want to delete this flight?");

            if (result) {
                // If confirmed, submit the delete form
                document.getElementById('deleteForm' + flightNo).submit();
            }
        }
    </script>
</body>

</html>