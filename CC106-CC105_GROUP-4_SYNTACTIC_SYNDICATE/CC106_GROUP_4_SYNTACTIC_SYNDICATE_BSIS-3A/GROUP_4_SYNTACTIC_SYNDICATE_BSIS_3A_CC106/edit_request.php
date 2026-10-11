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

// Fetch Existing Record using Prepared Statement
$stmt = $conn->prepare("SELECT * FROM service_requests WHERE request_id = ?");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$request = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$request || (!$isAdmin && $request['profile_id'] != $profile_id)) {
    die("Unauthorized access or request not found.");
}

$categories = $conn->query("SELECT * FROM service_categories ORDER BY category_name ASC");
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = intval($_POST['category_id']);
    $purpose = trim($_POST['purpose']);
    $status = $isAdmin ? trim($_POST['status']) : $request['status'];

    if (empty($purpose) || $category_id <= 0) {
        $error = "All fields are required.";
    } else {
        $updateStmt = $conn->prepare("UPDATE service_requests SET category_id = ?, purpose = ?, status = ? WHERE request_id = ?");
        $updateStmt->bind_param("issi", $category_id, $purpose, $status, $request_id);

        if ($updateStmt->execute()) {
            header("Location: dashboard.php?msg=updated");
            exit;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
        $updateStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BYISP - Edit Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Service Request #<?php echo $request['request_id']; ?></h4>
        </div>
        <div class="card-body p-4">
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $cat['category_id']; ?>" <?php if($cat['category_id'] == $request['category_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Purpose</label>
                    <textarea name="purpose" class="form-control" rows="4" required><?php echo htmlspecialchars($request['purpose']); ?></textarea>
                </div>

                <?php if ($isAdmin): ?>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-danger">Application Status (Admin Only)</label>
                        <select name="status" class="form-select">
                            <option value="Pending" <?php if($request['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Approved" <?php if($request['status'] === 'Approved') echo 'selected'; ?>>Approved</option>
                            <option value="Rejected" <?php if($request['status'] === 'Rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>