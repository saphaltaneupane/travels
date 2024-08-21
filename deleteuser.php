<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'dbcon.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if ($row['username'] === 'admin') {
    echo "The admin user cannot be deleted.";
} else {
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header("Location: viewusers.php");
    exit();
}

mysqli_close($conn);
?>
