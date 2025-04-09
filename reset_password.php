<?php
session_start();

// // Redirect if already logged in
// if (isset($_SESSION['account_loggedin'])) {
//     header('Location: home.php');
//     exit;
// }

// // Ensure token is passed in URL
// if (!isset($_GET['token'])) {
//     header('Location: login.php');
//     exit;
// }

$token = $_GET['token'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>
  <style>
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
    }

    body.dark {
      background: #1e1e2f;
      color: #e0e0e0;
    }

    .login-container {
      background-color: #ffffffee;
      padding: 40px 35px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 400px;
    }

    body.dark .login-container {
      background-color: #2e2e3f;
      color: #e0e0e0;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      color: #1a3d5d;
    }

    body.dark .login-container h2 {
      color: #e0e0e0;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 10px 40px 10px 35px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #fff;
      font-size: 15px;
    }

    body.dark .form-group input {
      background-color: #444;
      color: #eee;
      border: 1px solid #666;
    }

    .form-icon {
      position: absolute;
      top: 70%;
      left: 10px;
      transform: translateY(-50%);
      font-size: 18px;
      color: #999;
    }

    .btn {
      width: 100%;
      background-color: #29a0d5;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
    }

    .btn:hover {
      background-color: #1d8ec0;
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .extra-links a {
      color: #2c8fbb;
      text-decoration: none;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    .theme-toggle {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 20px;
      background: none;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <button class="theme-toggle" title="Toggle theme">🌙</button>

  <div class="login-container">
    <h2>Reset Your Password</h2>
    <form action="process_reset_password.php" method="post">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />

      <div class="form-group">
        <label for="new_password">New Password</label>
        <span class="form-icon">🔒</span>
        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required />
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <span class="form-icon">🔒</span>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required />
      </div>

      <button type="submit" class="btn">Update Password</button>
    </form>

    <div class="extra-links">
      <p><a href="login.php">Back to Login</a></p>
    </div>
  </div>

  <script src="theme.js"></script>
</body>
</html>
