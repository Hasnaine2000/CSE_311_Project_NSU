<?php
include "../connection.php";

// Fetch payments based on the search term (if provided via AJAX)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

$sql = "SELECT * FROM payment";
if (!empty($search)) {
    $sql .= " WHERE p_id LIKE '%$search%' OR amount LIKE '%$search%' OR method LIKE '%$search%' OR status LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
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

        .actions select,
        .actions button {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions select {
            width: 100px;
            margin-right: 10px;
        }

        .actions .update {
            background-color: #ff9900;
            color: #fff;
            border: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="../homepage.php" class="logo">
            <img src="../images/logo.png" alt="Website Logo">
        </a>

        <input type="text" id="search-bar" class="search-bar" placeholder="Search payments...">
    </div>

    <!-- Payment Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="payment-table-body">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['p_id']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['method']}</td>
                            <td>{$row['status']}</td>
                            <td class='actions'>
                                <form method='POST' action='update_payment_status.php' style='display:inline;'>
                                    <input type='hidden' name='p_id' value='{$row['p_id']}'>
                                    <select name='status'>
                                        <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                        <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                    </select>
                                    <button type='submit' class='update'>Update Status</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No payments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        const searchBar = document.getElementById('search-bar');
        const tableBody = document.getElementById('payment-table-body');

        searchBar.addEventListener('input', function () {
            const query = searchBar.value;
            fetch(`payments.php?search=${query}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newRows = doc.querySelector('#payment-table-body').innerHTML;
                    tableBody.innerHTML = newRows;
                });
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>
