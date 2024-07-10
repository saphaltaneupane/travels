<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include 'dbcon.php';

$data = mysqli_query($conn, "SELECT bookings.*, users.username, destinations.name as destination_name 
                             FROM bookings 
                             JOIN users ON bookings.user_id = users.id 
                             JOIN destinations ON bookings.destination_id = destinations.id");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bookings</title>
    <link rel="stylesheet" href="admin.css">

    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #f1f1f1;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
        }
        .sidebar ul li a.active {
            background-color: #ddd;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout {
            float: right;
            margin-bottom: 20px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style> -->
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="viewusers.php">View Users</a></li>
        <li><a href="viewcontacts.php">View Contacts</a></li>
        <li><a href="viewbookings.php" class="active">View Bookings</a></li>
        <li><a href="viewdestinations.php">View Destinations</a></li>
    </ul>
</div>
<div class="content">
    <a href="admin_logout.php" class="logout">Logout</a>
    <h1>Bookings</h1>
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
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <?php foreach ($row as $key => $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                    <td class="action-buttons">
                        <?php if ($row['status'] == 'pending'): ?>
                            <form action="acceptbooking.php" method="post">
                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Accept</button>
                            </form>
                        <?php endif; ?>
                        <form action="deletebooking.php" method="post" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="100%">No data available</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>