<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// Collect submitted data
$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validate input
if (empty($password) || empty($confirmPassword)) {
    $_SESSION['error_message'] = "❌ Password fields cannot be empty.";
    header("Location: change_password.php?token=" . urlencode($token));
    exit;
}

if ($password !== $confirmPassword) {
    $_SESSION['error_message'] = "❌ Passwords do not match.";
    header("Location: change_password.php?token=" . urlencode($token));
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['error_message'] = "❌ Password must be at least 8 characters.";
    header("Location: change_password.php?token=" . urlencode($token));
    exit;
}

// Validate token again
$stmt = $pdo->prepare("SELECT * FROM password_reset_requests WHERE reset_token = ? AND token_expiration > NOW()");
$stmt->execute([$token]);
$resetRequest = $stmt->fetch();

if (!$resetRequest) {
    $_SESSION['error_message'] = "❌ Invalid or expired token.";
    header("Location: forgot_password.php");
    exit;
}

// Update password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$updateStmt->execute([$hashedPassword, $resetRequest['user_email']]);

// Delete token
$deleteStmt = $pdo->prepare("DELETE FROM password_reset_requests WHERE reset_token = ?");
$deleteStmt->execute([$token]);

$_SESSION['success_message'] = "✅ Password successfully reset. You can now log in.";
header("Location: login.php");
exit;
?>
