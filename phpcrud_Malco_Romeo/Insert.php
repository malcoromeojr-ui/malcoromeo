<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!empty($firstname) && !empty($lastname)) {
        $stmt = $conn->prepare("INSERT INTO students (firstname, lastname) VALUES (?, ?)");
        $stmt->bind_param("ss", $firstname, $lastname);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: Home.php");
exit();
?>