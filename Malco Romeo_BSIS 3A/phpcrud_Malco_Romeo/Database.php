<?php
$host = "localhost";
$user = "root";     
$pass = "malco2006";          
$dbname = "phpcrud_malco_romeo";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>