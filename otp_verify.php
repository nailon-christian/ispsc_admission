<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_otp = trim($_POST['otp']);

    if (!isset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['username_temp'])) {
        echo "Session expired. Please login again.";
        exit();
    }

    if (time() > $_SESSION['otp_expiry']) {
        session_destroy();
        echo "OTP expired. Please login again.";
        exit();
    }

    if ($input_otp == $_SESSION['otp']) {
        // OTP correct, log user in
        $_SESSION['username'] = $_SESSION['username_temp'];

        // Clear temp session data
        unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['username_temp']);

        // Redirect to student dashboard or homepage
        header('Location: student_dashboard.php');
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>OTP Verification</title>
</head>
<body>
<h2>Enter OTP</h2>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" action="">
  <input type="text" name="otp" placeholder="Enter OTP" required autofocus><br><br>
  <button type="submit">Verify OTP</button>
</form>

</body>
</html>
