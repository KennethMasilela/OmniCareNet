<?php  
session_start();
$isLoggedIn = isset($_SESSION['account_loggedin']);
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OmniCareNet</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(to right, #002b36, #004c5a);
      color: #fff;
      min-height: 100vh;
      font-size: 14px;
    }

    body.dark {
      background: #1e1e2f;
      color: #e0e0e0;
    }

    .navbar {
      width: 100%;
      padding: 10px 20px;
      background-color: #ffffff0d;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .logo {
      width: 32px;
      height: 32px;
    }

    .brand-text {
      color: #4dd0e1;
      font-weight: 600;
      font-size: 16px;
    }

    .navbar .actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .theme-toggle {
      font-size: 18px;
      background: none;
      border: none;
      cursor: pointer;
      color: inherit;
    }

    .btn {
      padding: 6px 12px;
      background-color: #29a0d5;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      font-weight: 600;
      font-size: 13px;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #1d8ec0;
    }

    .container {
      text-align: center;
      margin-top: 40px;
      padding: 0 20px;
    }

    h1 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #4dd0e1;
    }

    p {
      font-size: 14px;
      margin-bottom: 30px;
      color: #ddd;
    }

    .quick-actions {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1.5rem;
      padding: 1.5rem 2rem;
      max-width: 900px;
      margin: 0 auto 4rem;
    }

    .card {
      backdrop-filter: blur(12px);
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 20px;
      padding: 1.5rem 1rem;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: white;
      animation: fadeInUp 0.5s ease-in-out both;
      text-decoration: none;
      display: block;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
      text-decoration: none;
    }

    .card i {
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
      display: block;
    }

    .card.dark {
      background-color: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.1);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <div class="brand">
    <svg class="logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
      <path d="M5,32a27,27 0 1,0 54,0a27,27 0 1,0 -54,0" fill="none" stroke="#4caf50" stroke-width="2" />
      <path d="M45,30c0-5-4-9-9-9-2,0-4,1-6,2-2-3-6-4-9-2-3,2-4,6-3,9-4,1-6,4-6,7 0,4,4,7,9,7h22c5,0,9-3,9-7s-4-7-7-7z" fill="#4caf50"/>
      <rect x="29" y="28" width="6" height="12" fill="white"/>
      <rect x="26" y="31" width="12" height="6" fill="white"/>
    </svg>
    <span class="brand-text">OmniCareNet</span>
  </div>

  <div class="actions">
    <?php if ($isLoggedIn): ?>
      <span style="font-size: 13px;">Hello, <?= htmlspecialchars($username) ?> 👋</span>
      <a href="logout.php" class="btn">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn">Login</a>
      <a href="register.php" class="btn">Register</a>
    <?php endif; ?>
    <button class="theme-toggle" title="Toggle theme">🌙</button>
  </div>
</div>

<!-- Main content -->
<div class="container">
  <?php if ($isLoggedIn): ?>
    <h1>Welcome back, <?= htmlspecialchars($username) ?>!</h1>
    <p>You are successfully logged in to OmniCareNet.</p>
  <?php else: ?>
    <h1>👋 Welcome to OmniCareNet</h1>
    <p>Your trusted healthcare records platform.</p>
  <?php endif; ?>

  <!-- Quick Actions Grid -->
  <section class="quick-actions">
    <a href="register_patient.php" class="card" title="Register a new patient"><i class="fas fa-user-doctor"></i>Register New Patient</a>
    <a href="view_records.php" class="card" title="Access all patient records"><i class="fas fa-clipboard-list"></i>View Patient Records</a>
    <a href="hospital_transfers.php" class="card" title="Manage hospital transfers"><i class="fas fa-hospital"></i>Hospital Transfers</a>
    <a href="prescriptions.php" class="card" title="View prescriptions and medications"><i class="fas fa-pills"></i>Prescriptions & Medications</a>
    <a href="billing_insurance.php" class="card" title="Handle billing and insurance"><i class="fas fa-credit-card"></i>Billing & Insurance</a>
    <a href="appointments.php" class="card" title="Manage appointments"><i class="fas fa-calendar-alt"></i>Appointments</a>
    <a href="system_status.php" class="card" title="Check system performance"><i class="fas fa-satellite-dish"></i>System Status</a>
    <a href="reports.php" class="card" title="View reports and analytics"><i class="fas fa-chart-line"></i>Reports / Analytics</a>
    <a href="patient_card.php" class="card" title="Access the digital patient card"><i class="fas fa-id-card"></i>Patient Card</a>
  </section>

<script>
  const toggle = document.querySelector('.theme-toggle');
  toggle?.addEventListener('click', () => {
    const darkMode = document.body.classList.toggle('dark');
    toggle.textContent = darkMode ? '☀️' : '🌙';

    document.querySelectorAll('.card').forEach(card => {
      card.classList.toggle('dark', darkMode);
    });
  });
</script>

</body>
</html>
