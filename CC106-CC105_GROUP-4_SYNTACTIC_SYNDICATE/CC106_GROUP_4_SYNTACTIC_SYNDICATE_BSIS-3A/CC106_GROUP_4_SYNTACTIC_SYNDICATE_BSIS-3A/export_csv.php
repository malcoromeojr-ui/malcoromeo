<?php
session_start();
require_once 'db.php';

// Check if user is logged in (or fallback if sessions are simplified)
if (!isset($_SESSION['user_id'])) {
    // If login is removed/not used, set default session values:
    $_SESSION['user_id'] = 1;
    $_SESSION['role_name'] = 'Admin';
    $_SESSION['profile_id'] = 1;
}

$isAdmin = (isset($_SESSION['role_name']) && $_SESSION['role_name'] === 'Admin');
$profile_id = $_SESSION['profile_id'] ?? 1;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';

$whereClauses = [];
$params = [];
$types = "";

if (!$isAdmin) {
    $whereClauses[] = "sr.profile_id = ?";
    $params[] = $profile_id;
    $types .= "i";
}

if (!empty($search)) {
    $whereClauses[] = "(yp.first_name LIKE ? OR yp.last_name LIKE ? OR sc.category_name LIKE ? OR sr.purpose LIKE ?)";
    $searchTerm = "%{$search}%";
    array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $types .= "ssss";
}

if (!empty($status_filter)) {
    $whereClauses[] = "sr.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$whereSQL = count($whereClauses) > 0 ? "WHERE " . implode(" AND ", $whereClauses) : "";

$query = "SELECT sr.request_id, yp.first_name, yp.last_name, yp.purok, yp.contact_number,
                 sc.category_name, sr.purpose, sr.status, sr.requested_at
          FROM service_requests sr
          JOIN youth_profiles yp ON sr.profile_id = yp.profile_id
          JOIN service_categories sc ON sr.category_id = sc.category_id
          $whereSQL
          ORDER BY sr.requested_at DESC";

$stmt = $conn->prepare($query);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

// FIX: Replaced $stmt.execute() with $stmt->execute()
$stmt->execute();
$result = $stmt->get_result();

// Stream headers for CSV Download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=BYISP_Service_Requests_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// Header Row
fputcsv($output, ['Request ID', 'First Name', 'Last Name', 'Purok', 'Contact Number', 'Category', 'Purpose', 'Status', 'Date Requested']);

// Data Rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['request_id'],
        $row['first_name'],
        $row['last_name'],
        $row['purok'],
        $row['contact_number'],
        $row['category_name'],
        $row['purpose'],
        $row['status'],
        $row['requested_at']
    ]);
}

fclose($output);
$stmt->close();
exit;
?>