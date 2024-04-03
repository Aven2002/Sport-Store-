<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../css/Contact.css">
</head>
<body>
    <?php include ("../includes/header.html");?>

    <main class="contact-container">
        <section class="contact-info">
            <h2>Contact Information</h2>
            <p><strong>Email:</strong> example@example.com</p>
            <p><strong>Phone:</strong> +123-456-7890</p>
            <p><strong>Address:</strong> 123 Main Street, City, Country</p>
        </section>

        <section class="contact-form">
            <h2>Send us a message</h2>
            <form action="send_message.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <?php include("../includes/footer.html");?>
</body>
</html>
