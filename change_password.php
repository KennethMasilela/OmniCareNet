<?php
session_start();
require 'db.php'; // your PDO database connection
require 'vendor/autoload.php'; // PHPMailer (if you want email notifications)

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Step 1: Check if the token is valid and not expired
    $stmt = $pdo->prepare("SELECT * FROM password_reset_requests WHERE reset_token = ? AND token_expiration > NOW()");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    if (!$resetRequest) {
        $_SESSION['error_message'] = "❌ Invalid or expired token.";
        header("Location: forgot_password.php");
        exit;
    }

    // Step 2: Process password reset request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Step 2.1: Get the new password from the form
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Step 2.2: Validate password (e.g., check if passwords match and meet criteria)
        if (empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error_message'] = "❌ Password fields cannot be empty.";
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = "❌ Passwords do not match.";
        } elseif (strlen($newPassword) < 8) {
            $_SESSION['error_message'] = "❌ Password must be at least 8 characters.";
        } else {
            // Step 2.3: Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Step 2.4: Update the password in the users table
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updateStmt->execute([$hashedPassword, $resetRequest['user_email']]);

            // Step 2.5: Delete the token after successful password reset
            $deleteStmt = $pdo->prepare("DELETE FROM password_reset_requests WHERE reset_token = ?");
            $deleteStmt->execute([$token]);

            // Step 2.6: Set success message and redirect to login page
            $_SESSION['success_message'] = "✅ Password successfully reset. You can now log in with your new password.";
            header("Location: login.php");
            exit;
        }
    }
} else {
    $_SESSION['error_message'] = "❌ No token provided.";
    header("Location: forgot_password.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - OmniCareNet</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your styles -->
</head>
<body>

<div class="container">
    <h2>Reset Your Password</h2>
    
    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert error">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php elseif (isset($_SESSION['success_message'])): ?>
        <div class="alert success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <button type="submit">Reset Password</button>
    </form>
    
</div>

</body>
</html>
