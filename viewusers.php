<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'dbcon.php';

$data = mysqli_query($conn, "SELECT * FROM users");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css">
    <style>
        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
    <script>
        function confirmDelete(id, username) {
            if (username === 'admin') {
                alert("The admin user cannot be deleted.");
            } else if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "deleteuser.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="viewusers.php" class="active">View Users</a></li>
            <li><a href="viewcontacts.php">View Contacts</a></li>
            <li><a href="viewbookings.php">View Bookings</a></li>
            <li><a href="viewdestinations.php">View Destinations</a></li>
        </ul>
    </div>
    <div class="content">
        <a href="admin_logout.php" class="logout">Logout</a>
        <h1>Users</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo $row['username']; ?>')" class="delete-btn">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
