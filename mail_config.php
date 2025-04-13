<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!file_exists('vendor/autoload.php')) {
    die('Composer autoload file not found. Please run "composer install".');
}
require 'vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

function sendResetConfirmationEmail($toEmail) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';         // Use your SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@gmail.com';   // Your email
        $mail->Password   = 'your-app-password';      // App-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'OmniCareNet');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = '✅ Your Password Was Reset';
        $mail->Body    = '
            <h3 style="color:#2c8fbb;">Hello,</h3>
            <p>Your password has been successfully reset for your <strong>OmniCareNet</strong> account.</p>
            <p>If you didn\'t request this, please contact us immediately.</p>
            <br>
            <p style="font-size:14px;color:gray;">This is an automated message. Do not reply.</p>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
