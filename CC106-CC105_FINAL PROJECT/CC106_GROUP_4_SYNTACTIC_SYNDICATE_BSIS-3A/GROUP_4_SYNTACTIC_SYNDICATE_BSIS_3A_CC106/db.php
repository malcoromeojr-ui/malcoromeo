<?php
$host = "localhost";
$user = "root";
$pass = "malco2006"; // Match your MySQL password[cite: 6]
$dbname = "byisp_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>