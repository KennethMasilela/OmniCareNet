<?php
require 'db.php';

$username = "demo_user";
$email = "demo@example.com";
$password = password_hash("DemoPassword123", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $password]);

echo "Test user created!";
?>
