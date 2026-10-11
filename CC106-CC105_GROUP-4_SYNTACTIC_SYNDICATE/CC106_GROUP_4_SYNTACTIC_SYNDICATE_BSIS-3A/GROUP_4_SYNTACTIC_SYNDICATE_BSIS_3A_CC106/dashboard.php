<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isAdmin = ($_SESSION['role_name'] === 'Admin');
$profile_id = $_SESSION['profile_id'];

// Pagination Configuration
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search & Filter Inputs
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';

// Base Query Conditions
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

// 1. Get Total Count for Pagination
$countQuery = "SELECT COUNT(*) as total 
               FROM service_requests sr
               JOIN youth_profiles yp ON sr.profile_id = yp.profile_id
               JOIN service_categories sc ON sr.category_id = sc.category_id
               $whereSQL";

$stmtCount = $conn->prepare($countQuery);
if (!empty($types)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$totalRecords = $stmtCount->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
$stmtCount->close();

// 2. Fetch Paginated Records using Advanced 3-Table SQL JOIN
$mainQuery = "SELECT sr.request_id, sr.purpose, sr.status, sr.requested_at, 
                     yp.first_name, yp.last_name, yp.purok, yp.contact_number, 
                     sc.category_name 
              FROM service_requests sr
              JOIN youth_profiles yp ON sr.profile_id = yp.profile_id
              JOIN service_categories sc ON sr.category_id = sc.category_id
              $whereSQL 
              ORDER BY sr.requested_at DESC 
              LIMIT ? OFFSET ?";

$stmtMain = $conn->prepare($mainQuery);
$mainTypes = $types . "ii";
$mainParams = array_merge($params, [$limit, $offset]);
$stmtMain->bind_param($mainTypes, ...$mainParams);
$stmtMain->execute();
$requests = $stmtMain->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BYISP - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="dashboard.php">BYISP Portal</a>
        <div class="d-flex align-items-center text-white">
            <span class="me-3">Welcome, <strong><?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']); ?></strong> (<?php echo htmlspecialchars($_SESSION['role_name']); ?>)</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Service Requests Dashboard</h2>
        <div>
            <a href="create_request.php" class="btn btn-success">+ New Service Request</a>
            <a href="export_csv.php?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" class="btn btn-secondary">Export to CSV</a>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search by resident name, category, or purpose..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">-- Filter by All Statuses --</option>
                <option value="Pending" <?php if($status_filter === 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Approved" <?php if($status_filter === 'Approved') echo 'selected'; ?>>Approved</option>
                <option value="Rejected" <?php if($status_filter === 'Rejected') echo 'selected'; ?>>Rejected</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="dashboard.php" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <!-- Records Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Resident</th>
                            <th>Purok</th>
                            <th>Category</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($requests->num_rows > 0): ?>
                            <?php while ($row = $requests->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['request_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['purok']); ?></td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($row['category_name']); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                                    <td>
                                        <?php 
                                            $status = $row['status'];
                                            $badge = ($status === 'Approved') ? 'bg-success' : (($status === 'Rejected') ? 'bg-danger' : 'bg-warning text-dark');
                                        ?>
                                        <span class="badge <?php echo $badge; ?>"><?php echo $status; ?></span>
                                    </td>
                                    <td><?php echo date('M d, Y h:i A', strtotime($row['requested_at'])); ?></td>
                                    <td>
                                        <a href="edit_request.php?id=<?php echo $row['request_id']; ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                        <a href="delete_request.php?id=<?php echo $row['request_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No service requests found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
</body>
</html>