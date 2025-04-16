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
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

    .toggle-password {
      position: absolute;
      top: 66%;
      right: 6px;
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

    #password-requirements {
      font-size: 12px;
      margin-top: 5px;
      color: #444;
    }

    #password-requirements li {
      margin-left: 18px;
    }

    body.dark #password-requirements {
      color: #ddd;
    }

    .password-requirements li {
      list-style: none;
      margin-bottom: 4px;
      color: #888;
    }

    .password-requirements li.valid {
      color: green;
    }

    .password-requirements li.invalid {
      color: red;
    }

    body.dark .password-requirements li.invalid {
      color: #ff8c8c;
    }

    body.dark .password-requirements li.valid {
      color: #90ee90;
    }
  </style>
</head>
<body>

  <button class="theme-toggle" title="Toggle theme" onclick="toggleTheme()" id="theme-icon">🌙</button>

  <div class="login-container">
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="success">
        <?= $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
      </div>
    <?php endif; ?>

    <h2>Reset Your Password</h2>
    <form action="reset_password_handler.php" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <span class="form-icon"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email" id="email" placeholder="Enter your email" required />
      </div>

      <div class="form-group">
        <label for="new_password">New Password</label>
        <span class="form-icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'new_password')" data-visible="false"><i class="fas fa-eye-slash"></i></span>
      </div>
      <ul class="password-requirements" id="requirements">
        <li id="length" style="color: red;">
          <i class="fas fa-times-circle requirement-icon"></i> At least 8 characters
        </li>
        <li id="number" style="color: red;">
          <i class="fas fa-times-circle requirement-icon"></i> At least one number
        </li>
        <li id="special" style="color: red;">
          <i class="fas fa-times-circle requirement-icon"></i> At least one special character
        </li>
      </ul>


      <div class="form-group"> 
        <label for="confirm_password">Confirm Password</label>
        <span class="form-icon">
          <i id="match-icon" class="fas fa-check-circle"></i>
        </span>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'confirm_password')" data-visible="false">
          <i class="fas fa-eye-slash"></i>
        </span>
      </div>
      <p id="error">Passwords do not match.</p>
      <button type="submit" class="btn">Reset Password</button>
    </form>

    <div class="extra-links">
      <p><a href="login.php">Back to Login</a></p>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function toggleVisibility(toggleIcon, inputId) {
      const input = document.getElementById(inputId);
      const icon = toggleIcon.querySelector("i");
      const isVisible = toggleIcon.getAttribute("data-visible") === "true";

      input.type = isVisible ? "password" : "text";
      toggleIcon.setAttribute("data-visible", !isVisible);

      icon.classList.remove(isVisible ? "fa-eye" : "fa-eye-slash");
      icon.classList.add(isVisible ? "fa-eye-slash" : "fa-eye");
    }
    
    // Password match and requirement check
    document.querySelector("form").addEventListener("submit", function (e) {
      const pass = document.getElementById("new_password").value;
      const confirm = document.getElementById("confirm_password").value;
      const errorMsg = document.getElementById("error");

      const isValid =
        pass.length >= 8 &&
        /\d/.test(pass) &&
        /[!@#$%^&*(),.?":{}|<>]/.test(pass);

      if (pass !== confirm) {
        e.preventDefault();
        errorMsg.textContent = "❌ Passwords do not match.";
        errorMsg.style.display = "block";
      } else if (!isValid) {
        e.preventDefault();
        errorMsg.textContent = "❌ Password does not meet the requirements.";
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });


    // Password requirements validation
    document.getElementById("new_password").addEventListener("input", function () {
      const value = this.value;

      const lengthEl = document.getElementById("length");
      const numberEl = document.getElementById("number");
      const specialEl = document.getElementById("special");

      const updateRequirement = (el, isValid) => {
      const icon = el.querySelector(".requirement-icon");
        el.style.color = isValid ? "green" : "red";
        icon.className = isValid ? "fas fa-check-circle requirement-icon" : "fas fa-times-circle requirement-icon";
      };

      updateRequirement(lengthEl, value.length >= 8);
      updateRequirement(numberEl, /\d/.test(value));
      updateRequirement(specialEl, /[!@#$%^&*(),.?":{}|<>]/.test(value));
    });

    // Theme toggle with emoji change
    function toggleTheme() {
      document.body.classList.toggle("dark");
      const themeIcon = document.getElementById("theme-icon");
      themeIcon.textContent = document.body.classList.contains("dark") ? "☀️" : "🌙";
    }
  </script>

</body>
</html>
