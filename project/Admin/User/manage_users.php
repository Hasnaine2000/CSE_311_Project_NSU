<?php
include "../connection.php";

// Fetch users based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT * FROM user";
if (!empty($search)) {
    $sql .= " WHERE user_id LIKE '%$search%' OR us_f_name LIKE '%$search%' OR us_l_name LIKE '%$search%' OR email LIKE '%$search%'";
}

$sql .= " ORDER BY email ASC"; // Sorting by email in ascending order

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .logo img {
            height: 50px;
            cursor: pointer;
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

        .actions .ban {
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

        <input type="text" id="search-bar" class="search-bar" placeholder="Search users...">
    </div>

    <!-- User Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
    <td>{$row['user_id']}</td>
    <td>{$row['us_f_name']} {$row['us_m_name']} {$row['us_l_name']}</td>
    <td>{$row['email']}</td>
    <td>{$row['DOB']}</td>
    <td>{$row['phone_no']}</td>
    <td class='actions'>
        <form method='GET' action='edit_user.php' style='display:inline;'>
            <input type='hidden' name='user_id' value='{$row['user_id']}'>
            <button type='submit' class='edit'>Edit</button>
        </form>
        <form method='POST' action='ban_user.php' style='display:inline;'>
            <input type='hidden' name='user_id' value='{$row['user_id']}'>
            <button type='submit' class='ban'>Ban</button>
        </form>
    </td>
</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('user-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`manage_users.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#user-table-body').innerHTML;
                    tableBody.innerHTML = newRows;
                });
        });
    </script>
</body>
</html>
