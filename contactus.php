<?php
session_start();

// Database connection
include 'dbcon.php';

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact (firstname, lastname, email, country, message) VALUES ('$firstname', '$lastname', '$email', '$country', '$message')";

    if (mysqli_query($conn, $sql)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK Travel - Contact Us</title>
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
            justify-content: space-between;
            gap: 2rem;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .contact-section {
            background-color: var(--card-background);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .contact-section h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .contact-section form {
            display: flex;
            flex-direction: column;
        }

        .contact-section label {
            margin-bottom: 0.5rem;
        }

        .contact-section input,
        .contact-section textarea {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .contact-section button {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-section button:hover {
            background-color: #27ae60;
        }

        .contact-info {
            flex: 1;
            background-color: var(--card-background);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .contact-info h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .contact-info p {
            margin-bottom: 1rem;
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

            main {
                flex-direction: column;
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
        <div class="contact-section">
            <h2>Contact Us</h2>
            <?php if (isset($success)): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="contactus.php" method="POST">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info">
            <h2>GET IN TOUCH!!</h2>
            <p>We'd love to hear from you</p>
            <p>Email: bktravels@gmail.com</p>
            <p>Contact No: 9876543210</p>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="copyright">
                &copy; <?php echo date("Y"); ?> BK Travel. All rights reserved.
            </div>
            <div class="social-icons">
               
