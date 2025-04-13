<?php
session_start();
require 'db.php'; // This should define $pdo as a PDO instance

// Fetch user input
$fullname = trim($_POST['fullname'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Basic validation
if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: register.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: register.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: register.php");
    exit();
}

if (
    strlen($password) < 8 ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[\W_]/', $password)
) {
    $_SESSION['error'] = "Password must be at least 8 characters long and include a number and special character.";
    header("Location: register.php");
    exit();
}

// Check if email already exists
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);
if ($check->fetch()) {
    $_SESSION['error'] = "Email is already registered.";
    header("Location: register.php");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into DB
try {
    $insert = $pdo->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");
    $insert->execute([$fullname, $username, $email, $hashed_password]);

    $_SESSION['success_message'] = "✅ Account created successfully! You can now log in.";
    header("Location: login.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "❌ Error creating account: " . $e->getMessage();
    header("Location: register.php");
    exit();
}
?>
