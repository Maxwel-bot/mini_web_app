<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $messageBody = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'maxwellmaxwell252@gmail.com'; // Your Gmail
        $mail->Password = 'wyee bnzr mvfs ogba'; // Use an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

       // Email Headers
       $mail->setFrom($email, $name);
       $mail->addAddress('maxwellmaxwell252@gmail.com'); // Where the email should be sent
       $mail->addReplyTo($email, $name);

       // Email Content
       $mail->isHTML(false);
       $mail->Subject = $subject;
       $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // Send Email
        $mail->send();
        $message = "Your message has been sent successfully!";
        $messageClass = "success"; // Green box
    } catch (Exception $e) {
        $message = "Message could not be sent. Error: {$mail->ErrorInfo}";
        $messageClass = "error"; // Red box
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/contact.css">
</head>
<style>

</style>
<body>

    <!-- Bootstrap Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">My PHP Site</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Contact Us</h2>

        <!-- Message Box -->
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo ($messageClass == 'success') ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show text-center" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="contact-form-container">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject:</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message:</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Send</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-light text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1">&copy; 2025 My PHP Site. All rights reserved.</p>
            <p class="mb-0">
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </p>
            <div class="social-icons mt-2">
                <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-light me-2"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
