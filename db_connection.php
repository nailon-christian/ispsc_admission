<?php
$servername = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ispsc_admission";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
