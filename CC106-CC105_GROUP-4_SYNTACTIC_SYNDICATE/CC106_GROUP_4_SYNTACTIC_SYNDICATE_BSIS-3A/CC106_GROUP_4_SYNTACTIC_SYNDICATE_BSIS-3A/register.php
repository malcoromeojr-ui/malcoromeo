<?php
session_start();
require_once 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name     = trim($_POST['first_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $username       = trim($_POST['username'] ?? '');
    $password       = $_POST['password'] ?? '';
    $confirm_pass   = $_POST['confirm_password'] ?? '';
    $purok          = trim($_POST['purok'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');

    // Form Validation
    if (empty($first_name) || empty($last_name) || empty($username) || empty($password) || empty($purok) || empty($contact_number)) {
        $errors[] = "All fields are required.";
    }
    if ($password !== $confirm_pass) {
        $errors[] = "Passwords do not match.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Check if username already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = "Username is already taken. Please choose another.";
        }
        $stmt->close();
    }

    // Process Registration
    if (empty($errors)) {
        $conn->begin_transaction();

        try {
            // 1. Fetch Resident Role ID (Default to role_name = 'Resident')
            $role_id = 2; // Fallback ID
            $role_query = $conn->query("SELECT role_id FROM roles WHERE role_name = 'Resident' LIMIT 1");
            if ($role_query && $role_row = $role_query->fetch_assoc()) {
                $role_id = $role_row['role_id'];
            }

            // 2. Hash Password & Insert into users table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmtUser = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
            $stmtUser->bind_param("ssi", $username, $hashed_password, $role_id);
            $stmtUser->execute();
            $new_user_id = $stmtUser->insert_id;
            $stmtUser->close();

            // 3. Insert into youth_profiles table
            $stmtProfile = $conn->prepare("INSERT INTO youth_profiles (user_id, first_name, last_name, purok, contact_number) VALUES (?, ?, ?, ?, ?)");
            $stmtProfile->bind_param("issss", $new_user_id, $first_name, $last_name, $purok, $contact_number);
            $stmtProfile->execute();
            $stmtProfile->close();

            $conn->commit();
            header("Location: login.php?registered=success");
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Registration failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BYISP - Resident Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center py-5" style="min-height: 100vh;">
<div class="container" style="max-width: 550px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">Resident Registration</h4>
            <small class="text-white-50">Create an account to submit service requests</small>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Purok / Zone</label>
                    <input type="text" name="purok" class="form-control" placeholder="e.g. Purok 1" value="<?php echo htmlspecialchars($_POST['purok'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" placeholder="09xxxxxxxxx" value="<?php echo htmlspecialchars($_POST['contact_number'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Register Account</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center py-3">
            <span>Already have an account? <a href="login.php" class="text-primary text-decoration-none fw-bold">Login here</a></span>
        </div>
    </div>
</div>
</body>
</html>