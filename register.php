<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - OmniCareNet</title>
  <link rel="stylesheet" href="style.css" />
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

    .register-container {
      background-color: #ffffffee;
      padding: 22px 18px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 340px;
    }

    body.dark .register-container {
      background-color: #2e2e3f;
      color: #e0e0e0;
    }

    h2 {
      text-align: center;
      margin-bottom: 18px;
      color: #1a3d5d;
      font-size: 18px;
    }

    body.dark h2 {
      color: #e0e0e0;
    }

    .form-group {
      margin-bottom: 14px;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 3px;
      font-weight: 500;
      font-size: 12px;
    }

    input {
      width: 100%;
      padding: 7px 34px 7px 28px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
    }

    body.dark input {
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

    .error-msg {
      color: red;
      font-size: 13px;
      text-align: center;
      margin-bottom: 10px;
      display: none;
    }

    .password-requirements {
      font-size: 12px;
      margin: 8px 0 14px;
      padding-left: 20px;
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

  <div class="register-container">
    <h2>Create Your Account</h2>
    <form id="registerForm" action="register_handler.php" method="POST">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <span class="form-icon">📝</span>
        <input type="text" name="fullname" required placeholder="Enter your full name" />
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <span class="form-icon">👤</span>
        <input type="text" name="username" id="username" placeholder="Choose a username" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <span class="form-icon">📧</span>
        <input type="email" name="email" id="email" placeholder="you@example.com" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <span class="form-icon">🔒</span>
        <input type="password" name="password" id="password" placeholder="Create a password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'password')" data-visible="false">🙈</span>
      </div>

      <ul class="password-requirements" id="requirements">
        <li id="length" style="color: red;"><span class="emoji">❌</span> At least 8 characters</li>
        <li id="number" style="color: red;"><span class="emoji">❌</span> At least one number</li>
        <li id="special" style="color: red;"><span class="emoji">❌</span> At least one special character</li>
      </ul>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <span class="form-icon">🔁</span>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'confirm_password')" data-visible="false">🙈</span>
      </div>

      <p class="error-msg" id="error-msg">⚠️ Passwords do not match!</p>

      <button type="submit" class="btn">Register</button>
    </form>

    <div class="extra-links">
      <p>Already have an account? <a href="login.php">Login</a></p>
      <p><a href="home.php">Back to Home</a></p>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function toggleVisibility(toggleIcon, fieldId) {
      const input = document.getElementById(fieldId);
      const isVisible = toggleIcon.getAttribute("data-visible") === "true";

      input.type = isVisible ? "password" : "text";
      toggleIcon.setAttribute("data-visible", !isVisible);
      toggleIcon.textContent = isVisible ? "🙈" : "👁️";
    }

    // Password match check
    document.getElementById("registerForm").addEventListener("submit", function (e) {
      const pass = document.getElementById("password").value;
      const confirm = document.getElementById("confirm_password").value;
      const errorMsg = document.getElementById("error-msg");

      if (pass !== confirm) {
        e.preventDefault();
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });

    document.getElementById("password").addEventListener("input", function () {
      const value = this.value;

      const lengthEl = document.getElementById("length");
      const numberEl = document.getElementById("number");
      const specialEl = document.getElementById("special");

      const updateRequirement = (el, isValid) => {
        el.style.color = isValid ? "green" : "red";
        el.querySelector(".emoji").textContent = isValid ? "✅" : "❌";
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
