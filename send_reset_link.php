<?php
session_start();
require 'db_php'; // <-- include your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists in users table
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Delete any existing tokens for this email
        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        // Insert new reset token
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires_at]);

        // Create reset URL
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";

        // Send email
        $to = $email;
        $subject = "Reset your password";
        $message = "Hello,\n\nPlease click the link below to reset your password:\n$reset_link\n\nThis link will expire in 1 hour.";
        $headers = "From: no-reply@yourdomain.com";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['status'] = "Password reset email sent successfully!";
        } else {
            $_SESSION['status'] = "Failed to send email. Please try again.";
        }

    } else {
        $_SESSION['status'] = "No account found with that email address.";
    }

    header("Location: forgot_password.php");
    exit;
}
?>
