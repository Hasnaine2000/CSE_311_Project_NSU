<?php
include "../connection.php";

// Fetch pilots and their corresponding captain information based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT pilot.*, captain.captain_id, captain.pilot_id AS captain_pilot_id
        FROM pilot
        LEFT JOIN captain ON pilot.pilot_id = captain.pilot_id"; // Using LEFT JOIN to get pilots with or without a captain

if (!empty($search)) {
    $sql .= " WHERE pilot.pilot_id LIKE '%$search%' 
              OR pilot.pi_f_name LIKE '%$search%' 
              OR pilot.pi_l_name LIKE '%$search%' 
              OR pilot.licence_no LIKE '%$search%' 
              OR captain.captain_id LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pilots</title>
    <style>
        body, html {
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

        .search-bar {
            margin-left: auto;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .table-container {
            margin: 30px auto;
            width: 90%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        tbody td {
            padding: 12px;
            text-align: left;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions .edit {
            background-color: #0066cc;
            color: #fff;
        }

        .actions .delete {
            background-color: #cc0000;
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

        <input type="text" id="search-bar" class="search-bar" placeholder="Search pilots...">
    </div>

    <!-- Pilot Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Pilot ID</th>
                    <th>Full Name</th>
                    <th>Licence No</th>
                    <th>Flight Hours</th>
                    <th>Salary</th>
                    <th>Captain ID</th> <!-- New Column for Captain Information -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="pilot-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['pilot_id']}</td>
                            <td>{$row['pi_f_name']} {$row['pi_l_name']}</td>
                            <td>{$row['licence_no']}</td>
                            <td>{$row['flight_hr']}</td>
                            <td>{$row['salary']}</td>
                            <td>" . ($row['captain_id'] ? $row['captain_id'] : 'None') . "</td> <!-- Display Captain ID if exists -->
                            <td class='actions'>
                                <form method='POST' action='edit_pilot.php' style='display:inline;'>
                                    <input type='hidden' name='pilot_id' value='{$row['pilot_id']}'>
                                    <button type='submit' class='edit'>Edit</button>
                                </form>
                                <form id='deleteForm{$row['pilot_id']}' method='POST' action='delete_pilot.php' style='display:inline;'>
                                    <input type='hidden' name='pilot_id' value='{$row['pilot_id']}'>
                                    <button type='button' class='delete' onclick='confirmDelete({$row['pilot_id']})'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No pilots found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('pilot-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`pilot.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#pilot-table-body').innerHTML;
                    tableBody.innerHTML = newRows;
                });
        });

        function confirmDelete(pilotId) {
            if (confirm("Are you sure you want to delete this pilot?")) {
                document.getElementById('deleteForm' + pilotId).submit();
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
