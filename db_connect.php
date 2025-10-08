<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // leave empty if default XAMPP
$dbname = "constructhub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
