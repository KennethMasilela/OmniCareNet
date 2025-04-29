<?php
session_start();
require_once 'db.php'; // Uses $pdo for PDO connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $first_name       = trim($_POST["first_name"]);
    $last_name        = trim($_POST["last_name"]);
    $username         = trim($_POST["username"]);
    $email            = trim($_POST["email"]);
    $contact_number   = trim($_POST["contact_number"]);
    $role             = trim($_POST["role"]);
    $hospital_name    = trim($_POST["hospital_users_name"]);
    $other_hospital   = trim($_POST["other_hospital"]);
    $password         = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Basic validation
    if (
        empty($first_name) || empty($last_name) || empty($username) || empty($email) ||
        empty($contact_number) || empty($role) || empty($hospital_name) ||
        empty($password) || empty($confirm_password)
    ) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: register.php");
        exit();
    }

    // Password validation
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    if (
        strlen($password) < 8 ||
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W]/", $password)
    ) {
        $_SESSION['error'] = "Password must be at least 8 characters long and include a number and a special character.";
        header("Location: register.php");
        exit();
    }

    // Handle custom hospital entry: Directly insert custom hospital without checking for duplicates
    if ($hospital_name === "Other" && !empty($other_hospital)) {
        $hospital_name = $other_hospital;

        // Insert the custom hospital into the hospital_users table
        $addHospital = $pdo->prepare("INSERT INTO hospital_users (hospital_users_name) VALUES (?)");
        $addHospital->execute([$hospital_name]);
    }

    // Check existing user (username or email)
    $checkUser = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $checkUser->execute([$username, $email]);

    if ($checkUser->rowCount() > 0) {
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: register.php");
        exit();
    }

    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insertUser = $pdo->prepare("
        INSERT INTO users (
            first_name, last_name, username, email, contact_number, role, hospital_users_name, password
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $inserted = $insertUser->execute([
        $first_name,
        $last_name,
        $username,
        $email,
        $contact_number,
        $role,
        $hospital_name,
        $hashed_password
    ]);

    if ($inserted) {
        // Get last inserted user ID
        $lastInsertedUserId = $pdo->lastInsertId();

        // Insert into hospital_users (user_id, hospital_users_name)
        $stmtHospitalUser = $pdo->prepare("INSERT INTO hospital_users (user_id, hospital_users_name) VALUES (?, ?)");
        $stmtHospitalUser->execute([
            $lastInsertedUserId,
            $hospital_name
        ]);

        $_SESSION['success_message'] = "✅ Registration successful! You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "❌ Registration failed. Please try again.";
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
