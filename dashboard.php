<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
<p>Your role is: <?php echo $_SESSION["role"]; ?></p>
<a href="logout.php">Logout</a>
