<?php
session_start();

// Block login page access if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: Home.php");
    exit();
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style..css">
</head>
<body>

<div class="container" style="max-width: 420px; margin-top: 80px;">
    <div class="card">
        <h2 style="color: var(--text-main, #1e293b); font-size: 1.5rem; text-align: center; margin-bottom: 8px;">Welcome Back</h2>
        <p style="color: var(--text-muted, #64748b); text-align: center; margin-bottom: 24px; font-size: 0.9rem;">Sign in to access your dashboard</p>

        <?php if (!empty($error)): ?>
            <div style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 18px; font-size: 0.9rem; text-align: center;">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="Check.php" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted, #64748b); display: block; margin-bottom: 6px;">First Name</label>
                <input type="text" name="firstname" placeholder="Enter First Name" required style="width: 100%; padding: 12px 16px; font-size: 0.95rem; background-color: #f1f5f9; border: 1px solid transparent; border-radius: 8px; outline: none;">
            </div>
            <div>
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted, #64748b); display: block; margin-bottom: 6px;">Password</label>
                <input type="password" name="password" placeholder="Enter Password" required style="width: 100%; padding: 12px 16px; font-size: 0.95rem; background-color: #f1f5f9; border: 1px solid transparent; border-radius: 8px; outline: none;">
            </div>
            <button type="submit" name="login" style="width: 100%; margin-top: 8px; background-color: #4f46e5; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Sign In</button>
        </form>
    </div>
</div>

</body>
</html>