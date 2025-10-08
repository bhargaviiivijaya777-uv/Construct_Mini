<?php
$conn = new mysqli('localhost', 'root', '', 'constructhub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
