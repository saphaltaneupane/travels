<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    include 'dbcon.php';
    
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    
    $query = "UPDATE bookings SET status = 'accepted' WHERE id = '$booking_id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: viewbookings.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: viewbookings.php");
}
?>