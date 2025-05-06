<?php  
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register New Patient | OmniCareNet</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --light-bg: #f4f9fc;
      --light-card: #ffffff;
      --dark-bg: #0b1c23;
      --dark-card: #1a2e35;
      --main-color: #007c91;
      --section-bg: #e6f0f5;
      --section-card: #f9fbfc;
      --input-focus: #007c91;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: var(--light-bg);
      margin: 0;
      padding: 20px;
      transition: background-color 0.3s ease;
    }

    .dark-mode {
      background-color: var(--dark-bg);
      color: #f4f9fc;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background-color: var(--light-card);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
    }

    .dark-mode .container {
      background-color: var(--dark-card);
    }

    h2 {
      text-align: center;
      color: var(--main-color);
      margin-bottom: 30px;
    }

    .section {
      background-color: var(--section-bg);
      padding: 25px;
      border-radius: 8px;
      margin-bottom: 25px;
      border-left: 5px solid var(--main-color);
    }

    .section-title {
      color: var(--main-color);
      font-size: 20px;
      margin-bottom: 15px;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
      color: var(--main-color);
      display: block;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 20px;
    }

    .input-wrapper input,
    .input-wrapper select,
    .input-wrapper textarea {
      width: 100%;
      padding: 14px 14px 14px 45px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
      background-color: #fefefe;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
    }

    .dark-mode .input-wrapper input,
    .dark-mode .input-wrapper select,
    .dark-mode .input-wrapper textarea {
      background-color: #2c444d;
      color: #f4f9fc;
      border: 1px solid #555;
    }

    .input-wrapper input:focus,
    .input-wrapper select:focus,
    .input-wrapper textarea:focus {
      border-color: var(--input-focus);
      outline: none;
    }

    .form-icon {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      font-size: 16px;
      color: #999;
    }

    button {
      margin-top: 30px;
      width: 100%;
      background-color: var(--main-color);
      color: white;
      border: none;
      padding: 15px;
      font-size: 18px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #005e6b;
    }

    .theme-toggle {
      position: right;
      top: 10px;
      right: 5px;
      font-size: 18px;
      background: none;
      border: none;
      cursor: pointer;
    }
    
    .hidden {
      display: none;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>


<button class="theme-toggle" title="Toggle theme" onclick="toggleTheme()" id="theme-icon">🌙</button>
<div class="container">
  <h2>Register New Patient</h2>
  <form method="POST" action="save_patient.php">

    <!-- PERSONAL -->
    <div class="section">
      <div class="section-title">Personal Information</div>

      <label>First Name:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-user"></i></span>
        <input type="text" name="first_name" required>
      </div>

      <label>Last Name:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-user"></i></span>
        <input type="text" name="last_name" required>
      </div>

      <label>Date of Birth:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-calendar-alt"></i></span>
        <input type="date" name="date_of_birth" required>
      </div>

      <label>ID Number:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-id-card"></i></span>
        <input type="text" name="id_number" pattern="\d{13}" maxlength="13" required>
      </div>

      <label>Gender:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-venus-mars"></i></span>
        <select name="gender" required>
          <option value="">-- Select --</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <label>Primary Contact Number:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-phone"></i></span>
        <input type="text" name="contact_number" pattern="\d{10}" required>
      </div>

      <label>Email Address:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email_address" required>
      </div>

      <label>Address:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-home"></i></span>
        <textarea name="address" rows="2" required></textarea>
      </div>
    </div>

    <!-- EMERGENCY -->
    <div class="section">
      <div class="section-title">Emergency Contact</div>

      <label>Emergency Contact Name:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-user-shield"></i></span>
        <input type="text" name="emergency_contact_name" required>
      </div>

      <label>Emergency Contact Number:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-phone-volume"></i></span>
        <input type="text" name="emergency_contact_number" pattern="\d{10}" required>
      </div>

      <label>Relationship to Emergency Contact:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-handshake"></i></span>
        <input type="text" name="emergency_contact_relationship" required>
      </div>
    </div>

    <!-- MEDICAL -->
    <div class="section">
      <div class="section-title">Medical Information</div>

      <label>Blood Type:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-tint"></i></span>
        <select name="blood_type" required>
          <option value="">-- Select --</option>
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
        </select>
      </div>

      <label>Allergies:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-allergies"></i></span>
        <textarea name="allergies" rows="2"></textarea>
      </div>

      <label>Medical Conditions:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-notes-medical"></i></span>
        <textarea name="medical_conditions" rows="2"></textarea>
      </div>

      <label>Current Medications:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-pills"></i></span>
        <textarea name="medications" rows="2"></textarea>
      </div>
    </div>

    <!-- INSURANCE -->
    <div class="section">
      <div class="section-title">Medical Aid Information</div>

      <label>Medical Aid Provider:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-briefcase-medical"></i></span>
        <select name="medical_aid_provider" id="aidProvider" onchange="checkOtherOption(this)" required>
          <option value="">-- Select --</option>
          <option value="Discovery">Discovery</option>
          <option value="Bonitas">Bonitas</option>
          <option value="Momentum">Momentum</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div id="otherAidDiv" class="hidden">
        <label>Specify Other:</label>
        <div class="input-wrapper">
          <span class="form-icon"><i class="fas fa-edit"></i></span>
          <input type="text" name="other_medical_aid">
        </div>
      </div>

      <label>Insurance Policy Number:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-file-alt"></i></span>
        <input type="text" name="insurance_policy_number">
      </div>
    </div>

    <!-- LEGAL -->
    <div class="section">
      <div class="section-title">Patient Registration & Legal Consent</div>

      <label>Patient Card ID:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-id-badge"></i></span>
        <input type="text" name="patient_card_id" required>
      </div>

      <label>Referral Source:</label>
      <div class="input-wrapper">
        <span class="form-icon"><i class="fas fa-hand-point-right"></i></span>
        <input type="text" name="referral_source">
      </div>

      <div class="input-wrapper">
        <label>
          <input type="checkbox" name="terms_conditions" required>
          I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.
        </label>
      </div>
    </div>

    <button type="submit">Register Patient</button>
  </form>
</div>

<script>
  function checkOtherOption(select) {
    document.getElementById("otherAidDiv").classList.toggle("hidden", select.value !== "Other");
  }

  
</script>

</body>
</html>