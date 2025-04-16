<?php
session_start();
require 'db.php'; // This should define $pdo as a PDO instance
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Make sure to include PHPMailer's autoloader

// Fetch user input
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$contact_number = trim($_POST['contact_number'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$role = $_POST['role'] ?? '';
$hospital_id = $_POST['hospital_id'] ?? '';
$other_hospital_name = trim($_POST['other_hospital_name'] ?? '');

// Basic validation
if (empty($first_name) || empty($last_name) || empty($username) || empty($email) ||
    empty($password) || empty($confirm_password) || empty($role) || empty($hospital_id) || empty($contact_number)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: register.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: register.php");
    exit();
}

if (!preg_match('/^\d{10}$/', $contact_number)) {
    $_SESSION['error'] = "Contact number must be exactly 10 digits.";
    header("Location: register.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: register.php");
    exit();
}

if (
    strlen($password) < 8 ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[\W_]/', $password)
) {
    $_SESSION['error'] = "Password must be at least 8 characters long and include a number and special character.";
    header("Location: register.php");
    exit();
}

// Check if email or username exists
$check = $pdo->prepare("SELECT user_id FROM users WHERE email = ? OR username = ?");
$check->execute([$email, $username]);
if ($check->fetch()) {
    $_SESSION['error'] = "Username or email is already registered.";
    header("Location: register.php");
    exit();
}

// If hospital is "Other", insert new hospital into hospitals table
if ($hospital_id === 'Other') {
    if (empty($other_hospital_name)) {
        $_SESSION['error'] = "Please enter the name of the hospital.";
        header("Location: register.php");
        exit();
    }

    // Check if hospital already exists
    $stmt = $pdo->prepare("SELECT hospital_id FROM hospitals WHERE hospital_name = ?");
    $stmt->execute([$other_hospital_name]);
    $existingHospital = $stmt->fetch();

    if ($existingHospital) {
        $hospital_id = $existingHospital['hospital_id'];
    } else {
        // Insert and get the new hospital_id
        $stmt = $pdo->prepare("INSERT INTO hospitals (hospital_name) VALUES (?)");
        $stmt->execute([$other_hospital_name]);
        $hospital_id = $pdo->lastInsertId();
    }
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user including contact_number
try {
    $insert = $pdo->prepare("INSERT INTO users 
        (username, email, contact_number, password_hash, first_name, last_name, role, hospital_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $insert->execute([
        $username,
        $email,
        $contact_number,
        $password_hash,
        $first_name,
        $last_name,
        $role,
        $hospital_id
    ]);

    // Send welcome email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'kennethmasilela.githubproject@gmail.com'; // Replace with your email
        $mail->Password = 'K3nneth36812!';   // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@omnicarenet.com', 'OmniCareNet');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to OmniCareNet';
        $mail->Body    = "
            <h1>Welcome to OmniCareNet</h1>
            <p>Hello $first_name $last_name,</p>
            <p>Thank you for registering with OmniCareNet!</p>
            <p>You can now manage your patient data safely and securely.</p>
            <p>We are here to ensure your medical records are well monitored and protected.</p>
            <p>Best regards,<br>OmniCareNet Team</p>
        ";

        $mail->send();

        $_SESSION['success_message'] = "✅ Account created successfully! You can now log in.";
        header("Location: login.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;
        header("Location: register.php");
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['error'] = "❌ Error creating account: " . $e->getMessage();
    header("Location: register.php");
    exit();
}
?>

