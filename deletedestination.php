<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    include 'dbcon.php';

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $delete_query = "DELETE FROM destinations WHERE id = '$id'";
    
    if (mysqli_query($conn, $delete_query)) {
        mysqli_close($conn);
        header("Location: viewdestinations.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: viewdestinations.php");
    exit();
}
?>