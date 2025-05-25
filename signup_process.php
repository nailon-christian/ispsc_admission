<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection setup
$servername = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ispsc_admission";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize inputs
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

// Validate role
$valid_roles = ['admin', 'student'];
if (!in_array($role, $valid_roles)) {
    echo "<script>
        alert('Invalid role selected.');
        window.history.back();
    </script>";
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
        alert('Invalid email format.');
        window.history.back();
    </script>";
    exit();
}

// Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>
        alert('Username already taken. Please choose another.');
        window.history.back();
    </script>";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

if ($stmt->execute()) {
    echo "<script>
        alert('Account created successfully!');
        window.location.href = 'login.php';
    </script>";
} else {
    $error = htmlspecialchars($stmt->error, ENT_QUOTES);
    echo "<script>
        alert('Error: $error');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
