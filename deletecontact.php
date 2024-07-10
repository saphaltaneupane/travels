<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Check if the id is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Database connection
    include 'dbcon.php';

    // Delete the contact
    $query = "DELETE FROM contact WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);
        header("Location: viewcontacts.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: viewcontacts.php");
    exit();
}
?>
