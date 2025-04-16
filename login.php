<?php 
session_start();

// Redirect if already logged in
if (isset($_SESSION['account_loggedin'])) {
    header('Location: home.php');
    exit;
}

if (isset($_SESSION['success_message'])) {
  echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
  unset($_SESSION['success_message']); // Clear the message after displaying it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OmniCareNet Login</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
      font-size: 14px;
    }

    body.dark {
      background: #1e1e2f;
      color: #e0e0e0;
    }

    .login-container {
      background-color: #ffffffee;
      padding: 28px 22px;
      border-radius: 14px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 360px;
    }

    body.dark .login-container {
      background-color: #2e2e3f;
      color: #e0e0e0;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
      color: #1a3d5d;
      font-size: 18px;
    }

    body.dark .login-container h2 {
      color: #e0e0e0;
    }

    .form-group {
      margin-bottom: 16px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      font-size: 13px;
    }

    .form-group input {
      width: 100%;
      padding: 8px 36px 8px 30px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #fff;
      font-size: 14px;
    }

    body.dark .form-group input {
      background-color: #444;
      color: #eee;
      border: 1px solid #666;
    }

    input.error {
      border: 1px solid red;
    }

    .form-icon {
      position: absolute;
      top: 66%;
      left: 8px;
      transform: translateY(-50%);
      font-size: 16px;
      color: #999;
    }

    .toggle-password {
      position: absolute;
      top: 66%;
      right: 8px;
      transform: translateY(-50%);
      cursor: pointer;
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

    #error {
      color: red;
      font-size: 13px;
      text-align: center;
      display: none;
      margin-bottom: 10px;
    }

    .success {
      color: #0a8754;
      background-color: #e0f9ed;
      padding: 10px;
      margin-bottom: 14px;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      font-size: 13.5px;
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

    .theme-toggle {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 18px;
      background: none;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <button class="theme-toggle" title="Toggle theme">🌙</button>

  <div class="login-container">
    
    <!-- ✅ Success Message -->
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="success">
        <?= $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
      </div>
    <?php endif; ?>

    <h2>Welcome to OmniCareNet</h2>

    <?php
      $errorMessage = '';
      if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
          $errorMessage = '❌ Invalid username or password.';
      }
    ?>

    <form action="authenticate.php" method="post" class="form">
      <div class="form-group">
        <label for="username">Username</label>
        <span class="form-icon"><i class="fas fa-user-alt"></i></span>
        <input type="text" name="username" id="username" placeholder="Enter your username" required class="<?= isset($_GET['error']) ? 'error' : '' ?>" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <span class="form-icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="password" id="password" placeholder="Enter your password" required class="<?= isset($_GET['error']) ? 'error' : '' ?>" />
        <span class="toggle-password" onclick="toggleVisibility(this, 'password')" data-visible="false"><i class="fas fa-eye-slash"></i></span>
      </div>

      <p id="error" style="display: <?= !empty($errorMessage) ? 'block' : 'none' ?>;">
        <?= !empty($errorMessage) ? htmlspecialchars($errorMessage) : 'Please fill in all fields.' ?>
      </p>


      <button type="submit" class="btn">Login</button>
    </form>

    <div class="extra-links">
      <p><a href="register.php">Don't have an account? Register</a></p>
      <p><a href="forgot_password.php">Forgot Password?</a></p>
      <p><a href="home.php">Back to Home</a></p>
    </div>
  </div>

  <script src="theme.js"></script>
  <script>
  
    function toggleVisibility(toggleIcon, inputId) {
      const input = document.getElementById(inputId);
      const icon = toggleIcon.querySelector("i");
      const isVisible = toggleIcon.getAttribute("data-visible") === "true";

      input.type = isVisible ? "password" : "text";
      toggleIcon.setAttribute("data-visible", !isVisible);

      icon.classList.remove(isVisible ? "fa-eye" : "fa-eye-slash");
      icon.classList.add(isVisible ? "fa-eye-slash" : "fa-eye");
    }


    // Basic client-side validation
    document.querySelector("form").addEventListener("submit", function (event) {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      const error = document.getElementById("error");

      if (username === "" || password === "") {
        event.preventDefault();
        error.style.display = "block";
        error.textContent = "Please fill in all fields.";
      } else {
        error.style.display = "none";
      }
    });

    // Hide error message while typing
    ["username", "password"].forEach(id => {
      document.getElementById(id).addEventListener("input", () => {
        document.getElementById("error").style.display = "none";
      });
    });
  </script>
</body>
</html>
