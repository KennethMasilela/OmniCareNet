<?php 
session_start();

// Redirect if already logged in
if (isset($_SESSION['account_loggedin'])) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Keep all your existing CSS here – unchanged */
    /* This is the exact same CSS from your previous page */
    * {
      box-sizing: border-box;
      font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #dff6ff, #b5e0f7);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      transition: background 0.3s ease;
      font-size: 13px;
    }
    body.dark {
      background: #1e1e2f;
      color: #e0e0e0;
    }
    .login-container {
      background-color: #ffffffee;
      padding: 22px 18px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 340px;
    }
    body.dark .login-container {
      background-color: #2e2e3f;
      color: #e0e0e0;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 18px;
      font-size: 18px;
      font-weight: 600;
      color: #1a3d5d;
    }
    body.dark .login-container h2 {
      color: #e0e0e0;
    }
    .form-group {
      margin-bottom: 14px;
      position: relative;
    }
    .form-group label {
      display: block;
      margin-bottom: 3px;
      font-size: 12px;
      font-weight: 500;
    }
    .form-group input {
      width: 100%;
      padding: 7px 34px 7px 28px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
    }
    body.dark .form-group input {
      background-color: #444;
      color: #eee;
      border: 1px solid #666;
    }
    .form-icon {
      position: absolute;
      top: 66%;
      left: 6px;
      transform: translateY(-50%);
      font-size: 16px;
      color: #999;
    }
    .btn {
      width: 100%;
      background-color: #29a0d5;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
    }
    .btn:hover {
      background-color: #1d8ec0;
    }
    .theme-toggle {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 18px;
      background: none;
      border: none;
      cursor: pointer;
    }
    .extra-links {
      text-align: center;
      margin-top: 12px;
      font-size: 13px;
    }
    .extra-links a {
      color: #2c8fbb;
      text-decoration: none;
    }
    .extra-links a:hover {
      text-decoration: underline;
    }
    .success {
      color: green;
      font-size: 13px;
      text-align: center;
      margin-bottom: 10px;
    }
    .error {
      color: red;
      font-size: 13px;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <button class="theme-toggle" title="Toggle theme" onclick="toggleTheme()" id="theme-icon">🌙</button>

  <div class="login-container">
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <h2>Forgot Password</h2>
    <form action="forgot_password_handler.php" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <span class="form-icon"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email" id="email" placeholder="Enter your email" required />
      </div>

      <button type="submit" class="btn">Send Reset Link</button>
    </form>

    <div class="extra-links">
      <p><a href="login.php">Back to Login</a></p>
    </div>
  </div>

  <script>
    function toggleTheme() {
      document.body.classList.toggle("dark");
      const themeIcon = document.getElementById("theme-icon");
      themeIcon.textContent = document.body.classList.contains("dark") ? "☀️" : "🌙";
    }
  </script>

</body>
</html>
