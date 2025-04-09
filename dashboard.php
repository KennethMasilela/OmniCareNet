<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";
echo "<p>Your role: " . $_SESSION['role'] . "</p>";
?>
