<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$isAdmin = ($_SESSION['role_name'] === 'Admin');
$profile_id = $_SESSION['profile_id'];

if ($request_id > 0) {
    if ($isAdmin) {
        $stmt = $conn->prepare("DELETE FROM service_requests WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
    } else {
        $stmt = $conn->prepare("DELETE FROM service_requests WHERE request_id = ? AND profile_id = ?");
        $stmt->bind_param("ii", $request_id, $profile_id);
    }
    
    $stmt->execute();
    $stmt->close();
}

header("Location: dashboard.php?msg=deleted");
exit;
?>