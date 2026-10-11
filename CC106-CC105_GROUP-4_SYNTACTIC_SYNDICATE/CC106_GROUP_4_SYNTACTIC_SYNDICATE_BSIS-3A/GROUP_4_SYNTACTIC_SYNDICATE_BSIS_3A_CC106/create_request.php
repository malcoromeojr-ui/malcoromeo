<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$categories = $conn->query("SELECT * FROM service_categories ORDER BY category_name ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = intval($_POST['category_id'] ?? 0);
    $purpose = trim($_POST['purpose'] ?? '');
    $profile_id = $_SESSION['profile_id'];

    // Server-Side Data Validation
    if ($category_id <= 0) {
        $errors[] = "Please select a valid service category.";
    }
    if (empty($purpose)) {
        $errors[] = "Purpose field cannot be empty.";
    } elseif (strlen($purpose) < 10) {
        $errors[] = "Purpose must be at least 10 characters long.";
    }

    if (empty($errors)) {
        // Prepared Statement Execution
        $stmt = $conn->prepare("INSERT INTO service_requests (profile_id, category_id, purpose, status) VALUES (?, ?, ?, 'Pending')");
        $stmt->bind_param("iis", $profile_id, $category_id, $purpose);

        if ($stmt->execute()) {
            header("Location: dashboard.php?msg=created");
            exit;
        } else {
            $errors[] = "Failed to create request: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BYISP - Submit Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">New Youth Service Request</h4>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="" onsubmit="return validateForm();">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Service Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Purpose of Request</label>
                    <textarea name="purpose" id="purpose" class="form-control" rows="4" placeholder="Explain why you are applying for this service..." required minlength="10"></textarea>
                    <div class="form-text">Must be at least 10 characters long.</div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Client-Side JS Validation
function validateForm() {
    const category = document.getElementById('category_id').value;
    const purpose = document.getElementById('purpose').value.trim();

    if (category === "") {
        alert("Please select a service category.");
        return false;
    }
    if (purpose.length < 10) {
        alert("Purpose must be at least 10 characters long.");
        return false;
    }
    return true;
}
</script>
</body>
</html>