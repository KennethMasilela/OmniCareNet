<?php
$host = 'localhost';       // or 127.0.0.1
$dbname = 'omnicarenet';   // your database name
$username = 'kenneth';        // your MySQL username
$password = 'K3nneth36812!';  // your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=3306", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to OmniCareNet database!";
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>


