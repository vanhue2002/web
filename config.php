<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "asm4";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
} else {
}

$conn->set_charset("utf8");
?>
