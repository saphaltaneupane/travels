<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'dbcon.php';

// Get the destination from the URL parameter
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';

// Fetch destination details from the database
$sql = "SELECT * FROM destinations WHERE name = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $destination);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$destination_details = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Assuming you store user_id in session
    $destination_id = $destination_details['id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $num_travelers = $_POST['num_travelers'];
    $price = $destination_details['price'] * $num_travelers; // Calculate total price

    // Validate dates
    $today = date('Y-m-d');
    if ($start_date < $today || $end_date < $today) {
        $error_message = "Error: You cannot book dates in the past.";
    } elseif ($end_date < $start_date) {
        $error_message = "Error: End date cannot be before start date.";
    } else {
        // Disable the trigger temporarily
        mysqli_query($conn, "SET @disable_trigger = 1");

        $sql = "INSERT INTO bookings (user_id, destination_id, start_date, end_date, num_travelers, price, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iissid", $user_id, $destination_id, $start_date, $end_date, $num_travelers, $price);
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Booking successful!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }

        // Re-enable the trigger
        mysqli_query($conn, "SET @disable_trigger = NULL");
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Trip - <?php echo htmlspecialchars($destination); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }

        main {
            padding: 2rem;
        }

        h1 {
            color: #34495e;
            text-align: center;
        }

        .booking-form {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 2rem auto;
        }

        .booking-form h2 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #34495e;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .submit-btn, .back-btn {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover, .back-btn:hover {
            background-color: #219150;
        }

        .back-btn {
            background-color: #3498db;
            margin-bottom: 1rem;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <main>
        <a href="home.php" class="back-btn">Back</a>
        <h1>Book Your Trip to <?php echo htmlspecialchars($destination); ?></h1>
        
        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="booking-form">
            <h2>Booking Details</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?destination=' . urlencode($destination); ?>" method="post">
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="num_travelers">Number of Travelers:</label>
                    <input type="number" id="num_travelers" name="num_travelers" min="1" required>
                </div>
                <button type="submit" class="submit-btn">Book Now</button>
            </form>
        </div>
    </main>
    <script>
        // Ensure end date is not before start date
        document.getElementById('start_date').addEventListener('change', function() {
            document.getElementById('end_date').min = this.value;
        });
    </script>
</body>
</html>