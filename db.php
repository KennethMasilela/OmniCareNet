<?php
$host = 'localhost';       // or 127.0.0.1
$dbname = 'omnicarenet';   // your database name
$username = 'kenneth';        // your MySQL username
$password = 'K3nneth36812!';  // your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=3306", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // For dev only:
    // echo "✅ Connected to OmniCareNet database!";
} catch (PDOException $e) {
    // Don't expose details to users
    error_log("DB connection error: " . $e->getMessage());
    die("❌ Unable to connect to the database. Please try again later.");
}
