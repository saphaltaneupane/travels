<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include 'dbcon.php';

$data = mysqli_query($conn, "SELECT * FROM destinations");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css">
    <style>
        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            color: white;
            margin-right: 5px;
        }
        .delete-btn { background-color: red; }
        .update-btn { background-color: blue; }
        .add-btn { background-color: green; }
        
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this destination?")) {
                window.location.href = "deletedestination.php?id=" + id;
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
    <h1>Destinations</h1>
    <a href="adddestination.php" class="action-btn add-btn">Add New Destination</a>
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
                    <td>
                        <a href="updatedestination.php?id=<?php echo $row['id']; ?>" class="action-btn update-btn">Update</a>
                        <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="action-btn delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td>No data available</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>