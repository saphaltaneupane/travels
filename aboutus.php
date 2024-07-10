<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK Travel - About Us</title>
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

        .about-section {
            background-color: var(--card-background);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .about-section h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .about-section p {
            margin-bottom: 1rem;
            font-size: 1rem;
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
        <h1>About Us</h1>
        <div class="about-section">
            <h2>Welcome to BK Travel</h2>
            <p>At BK Travel, we are dedicated to providing the best travel experiences for our customers. Our mission is to make travel accessible, enjoyable, and memorable for everyone. Whether you are looking for a relaxing beach vacation, an adventurous mountain trek, or an immersive cultural experience, we have the perfect destination for you.</p>
            <p>Our team of experienced travel experts is here to assist you in planning your dream vacation. We offer personalized travel packages, exclusive deals, and 24/7 customer support to ensure your trip is seamless and stress-free.</p>
            <p>We believe in sustainable and responsible tourism. BK Travel is committed to promoting eco-friendly travel practices and supporting local communities at our destinations. We aim to create positive impacts on the environment and the people we interact with during our travels.</p>
            <p>Join us on a journey of discovery and adventure. Let's explore the world together!</p>
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
