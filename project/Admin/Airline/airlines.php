<?php
include "../connection.php";

// Fetch airlines based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT * FROM airline";
if (!empty($search)) {
    $sql .= " WHERE airline_id LIKE '%$search%' OR airline_name LIKE '%$search%' OR contact_info LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Information</title>
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
        .logo img {
            height: 50px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="navbar">
    <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>
       
        <input type="text" id="search-bar" class="search-bar" placeholder="Search airlines...">
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Airline ID</th>
                    <th>Airline Name</th>
                    <th>Contact Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="airline-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['airline_id']}</td>
                            <td>{$row['airline_name']}</td>
                            <td>{$row['contact_info']}</td>
                            <td class='actions'>
                                <form method='POST' action='edit_airline.php' style='display:inline;'>
                                    <input type='hidden' name='airline_id' value='{$row['airline_id']}'>
                                    <button type='submit' class='edit'>Edit</button>
                                </form>
                                <form id='deleteForm{$row['airline_id']}' method='POST' action='delete_airline.php' style='display:inline;'>
                                    <input type='hidden' name='airline_id' value='{$row['airline_id']}'>
                                    <button type='button' class='delete' onclick='confirmDelete({$row['airline_id']})'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No airlines found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('airline-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`airlines.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#airline-table-body').innerHTML;
                    tableBody.innerHTML = newRows;
                });
        });

        function confirmDelete(airlineId) {
            if (confirm("Are you sure you want to delete this airline?")) {
                document.getElementById('deleteForm' + airlineId).submit();
            }
        }
    </script>
</body>

</html>
