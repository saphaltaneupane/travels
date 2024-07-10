<?php
session_start();

// Database connection
include 'dbcon.php';

// Fetch destinations from database
$sql = "SELECT * FROM destinations";
$result = mysqli_query($conn, $sql);
$destinations = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK Travel - Home</title>
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
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .destinations {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 1.5rem;
        }

        .card h2 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .card p {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .book-now {
            display: inline-block;
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .book-now:hover {
            background-color: #27ae60;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-left: 1rem;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
        }

        /* New styles for View Bookings link */
        .view-bookings {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        @media (max-width: 1024px) {
            .destinations {
                grid-template-columns: repeat(2, 1fr);
            }
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

            .destinations {
                grid-template-columns: 1fr;
            }

            .social-icons {
                margin-top: 1rem;
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
                <?php if(isset($_SESSION['username'])): ?>
                    <li><a href="viewownbooking.php" class="view-bookings">View Bookings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login/Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Popular Destinations</h1>
        <div class="destinations">
            <?php foreach ($destinations as $destination): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($destination['image_url']); ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>">
                <div class="card-content">
                    <h2><?php echo htmlspecialchars($destination['name']); ?></h2>
                    <p><?php echo htmlspecialchars($destination['description']); ?></p>
                    <p>Price: Rs<?php echo htmlspecialchars($destination['price']); ?></p>
                    <?php if(isset($_SESSION['username'])): ?>
                        <a href="booking.php?destination=<?php echo urlencode($destination['name']); ?>" class="book-now">Book Now</a>
                    <?php else: ?>
                        <a href="login.php" class="book-now">Book Now</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
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
