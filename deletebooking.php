<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
include 'dbcon.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "Booking deleted successfully";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: viewbookings.php");
exit();
?>
