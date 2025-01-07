<?php
include "../connection.php";

// Fetch planes based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT * FROM plane";
if (!empty($search)) {
    $sql .= " WHERE plane_id LIKE '%$search%' OR model LIKE '%$search%' OR capacity LIKE '%$search%' OR airline_id LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Planes</title>
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

        <input type="text" id="search-bar" class="search-bar" placeholder="Search planes...">
    </div>

    <!-- Plane Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Plane ID</th>
                    <th>Model</th>
                    <th>Capacity</th>
                    <th>Airline ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="plane-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['plane_id']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['capacity']}</td>
                            <td>{$row['airline_id']}</td>
                            <td class='actions'>
                                <form method='POST' action='edit_plane.php' style='display:inline;'>
                                    <input type='hidden' name='plane_id' value='{$row['plane_id']}'>
                                    <button type='submit' class='edit'>Edit</button>
                                </form>
                                <form id='deleteForm{$row['plane_id']}' method='POST' action='delete_plane.php' style='display:inline;'>
                                    <input type='hidden' name='plane_id' value='{$row['plane_id']}'>
                                    <button type='button' class='delete' onclick='confirmDelete({$row['plane_id']})'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No planes found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('plane-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`planes.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#plane-table-body').innerHTML;
                    tableBody.innerHTML = newRows;
                });
        });

        function confirmDelete(planeId) {
            if (confirm("Are you sure you want to delete this plane?")) {
                document.getElementById('deleteForm' + planeId).submit();
            }
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>
