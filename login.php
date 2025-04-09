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
  <title>OmniCareNet Login</title>
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

    .toggle-password {
      position: absolute;
      top: 70%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
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

    #error {
      color: red;
      font-size: 14px;
      text-align: center;
      display: none;
      margin-bottom: 10px;
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
    <h2>Welcome to OmniCareNet</h2>
    <form action="authenticate.php" method="post" class="form">
      <div class="form-group">
        <label for="username">Username</label>
        <span class="form-icon">👤</span>
        <input type="text" name="username" id="username" placeholder="Enter your username" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <span class="form-icon">🔒</span>
        <input type="password" name="password" id="password" placeholder="Enter your password" required />
        <span id="togglePassword" class="toggle-password">👁️</span>
      </div>

      <p id="error">Please fill in all fields.</p>
      <button type="submit" class="btn">Login</button>
    </form>

    <div class="extra-links">
      <p><a href="register.php">Don't have an account? Register</a></p>
      <p><a href="forgot_password.php">Forgot Password?</a></p>
      <p><a href="index.php">Back to Home</a></p>
    </div>
  </div>

  <script src="theme.js"></script>
  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
    });

    // Basic client-side validation
    document.querySelector("form").addEventListener("submit", function (event) {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      const error = document.getElementById("error");

      if (username === "" || password === "") {
        event.preventDefault();
        error.style.display = "block";
      } else {
        error.style.display = "none";
      }
    });
  </script>
</body>
</html>
