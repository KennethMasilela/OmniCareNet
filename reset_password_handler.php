<?php
session_start();
require 'db.php'; // Uses $pdo
require 'mail_config.php'; // Your PHPMailer setup
require 'vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Grab form data
$email = $_POST['email'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate email exists in DB
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "Email not found.";
    header("Location: reset_password.php");
    exit();
}

// Validate password strength
if (
    strlen($new_password) < 8 ||
    !preg_match('/[0-9]/', $new_password) ||
    !preg_match('/[\W_]/', $new_password)
) {
    $_SESSION['error'] = "Password must be at least 8 characters long and include a number and a special character.";
    header("Location: reset_password.php");
    exit();
}

if ($new_password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: reset_password.php");
    exit();
}

// Hash and update password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$update = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$update->execute([$hashed_password, $email]);

// Send confirmation email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kennethmasilela.githubproject@gmail.com'; // Your email
    $mail->Password = 'K3nneth36812!'; // Your app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('no-reply@omnicarenet.com', 'OmniCareNet');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Successful';
    $mail->Body = "Hi <strong>{$user['username']}</strong>,<br><br>Your password has been successfully reset.<br><br>Thank you,<br>OmniCareNet Team";

    $mail->send();
} catch (Exception $e) {
    // Optional: You can store this to a log file instead in production
    error_log("Mailer Error: " . $mail->ErrorInfo);
}

// Redirect with success
$_SESSION['success_message'] = "✅ You have successfully created a new password.";
header("Location: login.php");
exit();
?>

