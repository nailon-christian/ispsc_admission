<?php
session_start();

// Check if user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome, Student <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your student dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
