<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Please fill in both username and password.";
    } else {
        // Query to fetch user along with their role and profile info if available
        $stmt = $conn->prepare("
            SELECT u.user_id, u.username, u.password, u.role_id, 
                   r.role_name, yp.profile_id, yp.first_name 
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.role_id
            LEFT JOIN youth_profiles yp ON u.user_id = yp.user_id
            WHERE u.username = ?
        ");
        
        // Note: If you don't have a password column yet in your users table, 
        // adjust the query or use standard password verification.
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // If passwords are stored as plain text (or use password_verify($password, $row['password']) for hashing)
            if ($password === $row['password'] || password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role_id'] = $row['role_id'];
                $_SESSION['role_name'] = $row['role_name'] ?? 'Resident';
                $_SESSION['profile_id'] = $row['profile_id'] ?? 1;
                $_SESSION['first_name'] = $row['first_name'] ?? $row['username'];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BYISP - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center py-5" style="min-height: 100vh;">
<div class="container" style="max-width: 450px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">BYISP Portal Login</h4>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted py-3">
            <small>&copy; <?php echo date('Y'); ?> Barangay Youth Information & Service Portal</small>
        </div>
    </div>
</div>
</body>
</html>