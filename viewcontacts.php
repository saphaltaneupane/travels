<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include 'dbcon.php';

$data = mysqli_query($conn, "SELECT * FROM contact");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background-color: #34495e;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        h1, h2 {
            color: #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this contact?')) {
                window.location.href = 'deletecontact.php?id=' + id;
            }
        }
    </script>
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="viewusers.php" class="<?= $section == 'users' ? 'active' : '' ?>">View Users</a></li>
        <li><a href="viewcontacts.php" class="<?= $section == 'contacts' ? 'active' : '' ?>">View Contacts</a></li>
        <li><a href="viewbookings.php" class="<?= $section == 'bookings' ? 'active' : '' ?>">View Bookings</a></li>
        <li><a href="viewdestinations.php" class="<?= $section == 'destinations' ? 'active' : '' ?>">View Destinations</a></li>
    </ul>
</div>
   
    <div class="content">
        <a href="admin_logout.php" class="logout">Logout</a>
        <h1>Contacts</h1>
        <table>
            <?php
            if ($data && mysqli_num_rows($data) > 0):
                $first_row = mysqli_fetch_assoc($data);
                mysqli_data_seek($data, 0);
            ?>
                <tr>
                    <?php foreach ($first_row as $key => $value): ?>
                        <th><?php echo ucfirst($key); ?></th>
                    <?php endforeach; ?>
                        <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                            <td><button class="delete-btn" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo count($first_row) + 1; ?>">No data available</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
