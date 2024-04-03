<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../css/Contact.css?ver=<?php echo filemtime('../../css/Contact.css'); ?>">
</head>
<body>
<header>
    <?php include ("../includes/header.html");?>
</header>

<main class="contact-container">
    
    <section class="contact-info">
    <img src="/Sport-Store-/assets/img/contactLogo.png" class="contact-logo"> 
        <h2>Contact Information</h2>
        <p><strong>Email:</strong> example@example.com</p>
        <p><strong>Phone:</strong> +123-456-7890</p>
        <p><strong>Address:</strong> 123 Main Street, City, Country</p>
    </section>
    <section class="contact-form">
        <h2>Send us a message</h2>
        <p>
            Have a queston for us or feedback? Please select on the most
            appropriate category and fill out the form to reach us.
        </P>

        <form id="contactForm" action="contact.php" method="post">
        <label for="category">Category:</label>
            <select id="category" name="category">
                <option value="General">General Inquiry</option>
                <option value="Bug">Report a Bug or Technical Issue</option>
                <option value="Feature Request">Feature Request</option>
                <option value="Feedback">Feedback</option>
                <option value="Customer Support">Customer Support</option>
                <option value="Other">Other</option>
            </select>
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="email">Contact Number:</label>
            <input type="text" name="contactNum" required>

            <label for="message">Feedback:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            <div id="charCount"></div>

            <button id="submitButton" type="submit">Submit Feedback</button>
            <div id="errorMessage" style="color: red;"></div>
        </form>
    </section>
</main>

<footer>
    <?php include("../includes/footer.html");?>
</footer>

<script>
    var messageTextarea = document.getElementById('message');
    var charCountDisplay = document.getElementById('charCount');
    var errorMessage = document.getElementById('errorMessage');
    var submitButton = document.getElementById('submitButton');
    var contactForm = document.getElementById('contactForm');

    function updateCharCount() {
        var charCount = messageTextarea.value.trim().length;
        charCountDisplay.textContent = 'Character count: ' + charCount;

        if (charCount > 1500) {
            errorMessage.textContent = 'Maximum 1500 characters allowed.';
            submitButton.disabled = true;
        } else {
            errorMessage.textContent = '';
            submitButton.disabled = false;
        }
    }

    messageTextarea.addEventListener('input', updateCharCount);

    contactForm.addEventListener('submit', function(event) {
        var charCount = messageTextarea.value.trim().length;
        if (charCount > 1500) {
            event.preventDefault(); // Prevent form submission
            errorMessage.textContent = 'Maximum 1500 characters allowed.';
        }
    });

    updateCharCount();
</script>

</body>
</html>

<?php
    // Include the database connection
    include("../../database.php");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $category = $_POST["category"];
        $email = $_POST["email"];
        $contactNum = $_POST["contactNum"];
        $message = $_POST["message"];

        // Prepare and execute the SQL query to insert data into the feedback table
        $sql = "INSERT INTO feedback (category, email, contactNum, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $category, $email, $contactNum, $message);
        $stmt->execute();
        
        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            // Feedback successfully submitted
            echo "<script>alert('Feedback submitted successfully!');</script>";
        } else {
            // Error occurred while submitting feedback
            echo "<script>alert('Error submitting feedback. Please try again later.');</script>";
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
?>

