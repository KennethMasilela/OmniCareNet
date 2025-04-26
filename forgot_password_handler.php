<?php
session_start();
require 'db.php'; // Your PDO database connection
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']); // Get email from form submission

    try {
        // Check if email exists in users table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            // If email doesn't exist in the database, show error message and redirect
            $_SESSION['error_message'] = "❌ No account found with that email.";
            header("Location: forgot_password.php");
            exit;
        }

        // Generate token
        $token = bin2hex(random_bytes(32)); // Generate a secure token
        $expiration = date("Y-m-d H:i:s", strtotime("+1 hour")); // Set token expiration time (1 hour)

        // Delete previous tokens for the same email
        $deleteStmt = $pdo->prepare("DELETE FROM password_reset_requests WHERE user_email = :email");
        $deleteStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $deleteStmt->execute();

        // Store token in the password_reset_requests table
        $stmt = $pdo->prepare("INSERT INTO password_reset_requests (user_email, reset_token, token_expiration) VALUES (:email, :token, :expiration)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':expiration', $expiration, PDO::PARAM_STR);
        $stmt->execute();

        // Send email with reset link
        $resetLink = "http://yourdomain.com/change_password.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kennethmasilela.githubproject@gmail.com'; // your email
            $mail->Password = 'K3nneth36812!';    // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'OmniCareNet');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = '🔐 Password Reset Request';
            $mail->Body = "
                <p>Hello,</p>
                <p>You requested to reset your password. Click the link below to proceed:</p>
                <p><a href='$resetLink'>Reset My Password</a></p>
                <p>This link will expire in 1 hour.</p>
                <p>If you didn't request this, please ignore this email.</p>
            ";

            $mail->send();
            $_SESSION['success_message'] = "✅ Password reset link sent to your email.";
            header("Location: forgot_password.php");
            exit;

        } catch (Exception $e) {
            $_SESSION['error_message'] = "❌ Email sending failed. Try again.";
            header("Location: forgot_password.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "❌ Database error: " . $e->getMessage();
        header("Location: forgot_password.php");
        exit;
    }
}
?>
