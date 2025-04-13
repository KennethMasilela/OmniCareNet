<?php  
session_start();
$isLoggedIn = isset($_SESSION['account_loggedin']);
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OmniCareNet Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      margin-top: 60px;
      padding: 0 20px;
    }

    h1 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #4dd0e1;
    }

    p {
      font-size: 14px;
      margin-bottom: 20px;
      color: #ddd;
    }

    /* Quick Navigation Tiles */
    .tile-grid {
      margin-top: 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      gap: 14px;
    }

    .tile {
      background-color: #ffffff15;
      color: #fff;
      padding: 12px 10px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 500;
      font-size: 13px;
      text-align: center;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .tile:hover {
      background-color: #29a0d5;
      transform: translateY(-3px);
    }

    body.dark .tile {
      background-color: #2c3e50;
    }

    body.dark .tile:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <div class="brand">
    <!-- SVG Cloud + Medical Cross + Orbit -->
    <svg class="logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
      <!-- Orbit circle -->
      <path d="M5,32a27,27 0 1,0 54,0a27,27 0 1,0 -54,0" fill="none" stroke="#4caf50" stroke-width="2" />
      
      <!-- Cloud -->
      <path d="M45,30c0-5-4-9-9-9-2,0-4,1-6,2-2-3-6-4-9-2-3,2-4,6-3,9-4,1-6,4-6,7 0,4,4,7,9,7h22c5,0,9-3,9-7s-4-7-7-7z" 
            fill="#4caf50"/>
      
      <!-- Medical cross inside cloud -->
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

    <!-- Quick Navigation Tiles -->
    <div class="tile-grid">
      <a href="register_patient.php" class="tile">👥 Register Patient</a>
      <a href="search_patient.php" class="tile">📋 Search Patient</a>
      <a href="hospital_records.php" class="tile">🏥 Hospital Records</a>
      <a href="prescriptions.php" class="tile">💊 Prescriptions</a>
      <a href="billing.php" class="tile">💳 Billing</a>
      <a href="admin_panel.php" class="tile">⚙️ Admin Panel</a>
    </div>
  <?php else: ?>
    <h1>👋 Welcome to OmniCareNet</h1>
    <p>Your trusted healthcare records platform.</p>
  <?php endif; ?>
</div>

<script>
  const toggle = document.querySelector('.theme-toggle');
  toggle?.addEventListener('click', () => {
    document.body.classList.toggle('dark');
    toggle.textContent = document.body.classList.contains('dark') ? '☀️' : '🌙';
  });
</script>

</body>
</html>
