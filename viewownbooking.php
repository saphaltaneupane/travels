<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'dbcon.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT bookings.*, destinations.name as destination_name, destinations.price 
          FROM bookings 
          JOIN destinations ON bookings.destination_id = destinations.id 
          WHERE bookings.user_id = '$user_id' AND bookings.status = 'accepted'";

$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK Travel - Your Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #ecf0f1;
            --text-color: #34495e;
            --card-background: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header, footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
        }

        header {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav, .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        nav h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        nav ul {
            list-style-type: none;
            display: flex;
        }

        nav ul li {
            margin-left: 2rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 300;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--secondary-color);
        }

        main {
            max-width: 1200px;
            margin: 6rem auto 2rem;
            padding: 0 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .bookings-section {
            background-color: var(--card-background);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .bookings-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .bookings-section th, .bookings-section td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .bookings-section th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        .bookings-section tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .bookings-section tr:hover {
            background-color: #f1f1f1;
        }

        .no-bookings {
            color: #666;
            font-style: italic;
            text-align: center;
        }

        @media (max-width: 768px) {
            nav, .footer-content {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 1rem;
            }

            nav ul li {
                margin: 0 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>BK Travel</h1>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="viewownbooking.php" class="view-bookings">View Bookings</a></li>
                <?php if(isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login/Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="bookings-section">
            <h1>Your Bookings</h1>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <tr>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Number of People</th>
                        <th>Total Price</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['destination_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['num_travelers']); ?></td>
                            <td>Rs <?php echo htmlspecialchars($row['price']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="no-bookings">You have no accepted bookings at the moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="copyright">
                &copy; <?php echo date("Y"); ?> BK Travel. All rights reserved.
            </div>
            <div class="social-icons">
            <a href="https://www.facebook.com/bktravel" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/bktravel" target="_blank"><i class="fab fa-instagram"></i></a>
                
            </div>
        </div>
    </footer>
</body>
</html>
