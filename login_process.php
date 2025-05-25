<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes (adjust path if needed)
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// DB connection setup
$servername = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ispsc_admission";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input
$username = trim($_POST['username']);
$password = $_POST['password'];

// Check if username exists and get hashed password and email
$stmt = $conn->prepare("SELECT password, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "<script>alert('Username not found.'); window.history.back();</script>";
    exit();
}

$stmt->bind_result($hashed_password, $email);
$stmt->fetch();

// Verify password
if (!password_verify($password, $hashed_password)) {
    echo "<script>alert('Incorrect password.'); window.history.back();</script>";
    exit();
}

// Generate 6-digit OTP
$otp = rand(100000, 999999);

// Store OTP & info in session
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300;  // 5 minutes from now
$_SESSION['username_temp'] = $username;

// Send OTP email
$mail = new PHPMailer(true);
try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';        // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'christiannailon1@gmail.com';  // Your SMTP username
    $mail->Password = 'your_app_password_here';       // Use App Password, NOT your Gmail login
    $mail->SMTPSecure = 'tls';               // Encryption
    $mail->Port = 587;                       // TCP port to connect to

    $mail->setFrom('christiannailon1@gmail.com', 'ISPSC Admission');
    $mail->addAddress($email, $username);

    $mail->isHTML(false);
    $mail->Subject = 'Your ISPSC Admission OTP Code';
    $mail->Body = "Hello $username,\nYour OTP code is: $otp\nIt is valid for 5 minutes.";

    $mail->send();

    // Redirect to OTP verify page
    header('Location: otp_verify.php');
    exit();

} catch (Exception $e) {
    echo "<script>alert('Mailer Error: " . addslashes($mail->ErrorInfo) . "'); window.history.back();</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
