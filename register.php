<?php session_start(); 
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
  <title>Register - OmniCareNet</title>
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

    .register-container {
      display: flex;
      flex-wrap: wrap;
      gap: -10px;
      background-color: rgba(255, 255, 255, 0.85); /* More readable and still transparent */
      padding: 28px;
      border-radius: 13px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      max-width: 780px;
      width: 95%;
    }


    body.dark .register-container {
      background-color: #2e2e3f;
      color: #e0e0e0;
    }

    .form-section {
      flex: 1 1 350px;
      min-width: 300px;
    }

    h2 {
      width: 100%;
      text-align: center;
      margin-bottom: 18px;
      color: #1a3d5d;
      font-size: 20px;
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

    input, select {
      width: 80%;
      padding: 7px 34px 7px 28px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
    }

    body.dark input, body.dark select {
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
      right: 90px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 16px;
      color: #999;
    }

    .btn {
      width: 60%;
      margin: 0 auto;
      display: block;
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
      width: 100%;
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
      margin-top: 8px;
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

    select {
      appearance: none;
      padding-left: 28px;
    }

    @media (max-width: 768px) {
      .register-container {
        flex-direction: column;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <button class="theme-toggle" title="Toggle theme" onclick="toggleTheme()" id="theme-icon">🌙</button>
  <form action="register_handler.php" method="post" id="registerForm" class="register-container">
    <h2>Create Your Account</h2>
    <!-- Column 1 -->
    <div class="form-section">
      <div class="form-group">
        <label for="first_name">First Name(s)</label>
        <span class="form-icon"><i class="fas fa-user"></i></span>
        <input type="text" name="first_name" id="first_name" placeholder="Enter your first name" required />
      </div>

      <div class="form-group">
        <label for="last_name">Last Name</label>
        <span class="form-icon"><i class="fas fa-user"></i></span>
        <input type="text" name="last_name" id="last_name" placeholder="Enter your last name" required />
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <span class="form-icon"><i class="fas fa-user-alt"></i></span>
        <input type="text" name="username" id="username" placeholder="Choose a username" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <span class="form-icon"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email" id="email" placeholder="you@example.com" required />
      </div>

      <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <span class="form-icon"><i class="fas fa-phone"></i></span>
        <input type="text" name="contact_number" id="contact_number" pattern="\d{10}" maxlength="10" title="Enter a valid 10-digit phone number" required placeholder="e.g. 0812345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
      </div>
    </div>

    <!-- Column 2 -->
    <div class="form-section">
      <div class="form-group">
        <label for="role">Role</label>
        <span class="form-icon"><i class="fas fa-user-md"></i></span>
        <select name="role" id="role" required>
          <option value="">Select role</option>
          <option value="Admin">Admin</option>
          <option value="Doctor">Doctor</option>
          <option value="Nurse">Nurse</option>
          <option value="Receptionist">Receptionist</option>
        </select>
      </div>

      <div class="form-group">
        <label for="hospital_name">Hospital</label>
        <span class="form-icon"><i class="fas fa-hospital"></i></span>
        <select name="hospital_users_name" id="hospital_name" required onchange="toggleOtherHospitalField()">
          <option value="">Select hospital</option>
          <option value="Chris Hani Baragwanath Academic Hospital">Chris Hani Baragwanath Academic Hospital</option>
          <option value="Steve Biko Academic Hospital">Steve Biko Academic Hospital</option>
          <option value="Charlotte Maxeke Johannesburg Academic Hospital">Charlotte Maxeke Johannesburg Academic Hospital</option>
          <option value="Helen Joseph Hospital">Helen Joseph Hospital</option>
          <option value="Tambo Memorial Hospital">Tambo Memorial Hospital</option>
          <option value="Pholosong Hospital">Pholosong Hospital</option>
          <option value="Kalafong Provincial Tertiary Hospital">Kalafong Provincial Tertiary Hospital</option>
          <option value="Netcare Milpark Hospital">Netcare Milpark Hospital</option>
          <option value="Life Brenthurst Hospital">Life Brenthurst Hospital</option>
          <option value="Netcare Sunninghill Hospital">Netcare Sunninghill Hospital</option>
          <option value="Life Fourways Hospital">Life Fourways Hospital</option>
          <option value="Bedford Gardens Private Hospital">Bedford Gardens Private Hospital</option>
          <option value="Bougainville Private Hospital">Bougainville Private Hospital</option>
          <option value="Busamed Modderfontein Private Hospital">Busamed Modderfontein Private Hospital</option>
          <option value="Carstenhof Hospital">Carstenhof Hospital</option>
          <option value="Cintocare">Cintocare</option>
          <option value="Clinix Naledi-Nkanyezi Private Hospital">Clinix Naledi-Nkanyezi Private Hospital</option>
          <option value="Clinix Private Hospital (Vosloorus)">Clinix Private Hospital (Vosloorus)</option>
          <option value="Clinix Solomon Stix Morewa Memorial Hospital">Clinix Solomon Stix Morewa Memorial Hospital</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group" id="other-hospital-group" style="display: none;">
        <label for="other_hospital">Specify Hospital</label>
        <input type="text" name="other_hospital" id="other_hospital" placeholder="Enter hospital name" />
        <span class="form-icon"><i class="fas fa-hospital"></i></span>
      </div>


      <div class="form-group">
        <label for="password">Password</label>
        <span class="form-icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="password" id="password" placeholder="Create a password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'password')" data-visible="false"><i class="fas fa-eye-slash"></i></span>
      </div>

      <ul class="password-requirements" id="requirements">
        <li id="length"><i class="fas fa-times-circle requirement-icon"></i> At least 8 characters</li>
        <li id="number"><i class="fas fa-times-circle requirement-icon"></i> At least one number</li>
        <li id="special"><i class="fas fa-times-circle requirement-icon"></i> At least one special character</li>
      </ul>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <span class="form-icon"><i class="fas fa-sync-alt"></i></span>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat password" required />
        <span class="toggle-password" onclick="toggleVisibility(this, 'confirm_password')" data-visible="false"><i class="fas fa-eye-slash"></i></span>
      </div>
    </div>

    <p class="error-msg" id="error-msg">⚠️ Passwords do not match!</p>

    <button type="submit" class="btn">Register</button>

    <div class="extra-links">
      <p>Already have an account? <a href="login.php">Login</a></p>
      <p><a href="home.php">Back to Home</a></p>
    </div>
  </form>

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
        el.classList.toggle("valid", isValid);
        el.classList.toggle("invalid", !isValid);
        const icon = el.querySelector("i");
        icon.className = isValid ? "fas fa-check-circle requirement-icon" : "fas fa-times-circle requirement-icon";
      };

      updateRequirement(lengthEl, value.length >= 8);
      updateRequirement(numberEl, /\d/.test(value));
      updateRequirement(specialEl, /[!@#$%^&*(),.?":{}|<>]/.test(value));
    });

    function toggleTheme() {
      document.body.classList.toggle("dark");
      const themeIcon = document.getElementById("theme-icon");
      themeIcon.textContent = document.body.classList.contains("dark") ? "☀️" : "🌙";
    }
  </script>
  <script>
    function toggleOtherHospitalField() {
      const hospitalSelect = document.getElementById('hospital_name');
      const otherHospitalGroup = document.getElementById('other-hospital-group');
      otherHospitalGroup.style.display = hospitalSelect.value === 'Other' ? 'block' : 'none';
    }
  </script>
</body>
</html>
