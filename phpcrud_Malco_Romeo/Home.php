<?php
session_start();
require_once 'Database.php';

// Route Guard: Send user to login if session does not exist
if (!isset($_SESSION['user_id'])) {
    header("Location: Index.php?error=Please log in first to access dashboard");
    exit();
}

// Fetch all entries from the students table
$students_result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management Dashboard</title>
    <link rel="stylesheet" href="Style..css">
</head>
<body style="background-color: #0f172a; color: white; font-family: 'Inter', sans-serif; padding: 40px;">

    <div style="max-width: 900px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 style="font-size: 1.8rem; margin: 0;">Student Management Dashboard</h1>
            <div>
                <span style="margin-right: 15px; color: #94a3b8;">Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="Logout.php" style="background-color: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">Logout</a>
            </div>
        </div>

        <!-- Add Student Section -->
        <div style="background-color: white; color: #1e293b; padding: 24px; border-radius: 12px; margin-bottom: 24px;">
            <h3 style="margin-top: 0; margin-bottom: 16px;">Add New Student</h3>
            <form action="Insert.php" method="POST" style="display: flex; gap: 12px;">
                <input type="text" name="firstname" placeholder="First Name" required style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                <input type="text" name="lastname" placeholder="Last Name" required style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                <button type="submit" style="background-color: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;">Add Student</button>
            </form>
        </div>

        <!-- Student List Table -->
        <div style="background-color: white; color: #1e293b; padding: 24px; border-radius: 12px;">
            <h3 style="margin-top: 0; margin-bottom: 16px;">Student List</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px;">ID</th>
                        <th style="padding: 12px;">FIRST NAME</th>
                        <th style="padding: 12px;">LAST NAME</th>
                        <th style="padding: 12px;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students_result && $students_result->num_rows > 0): ?>
                        <?php while ($row = $students_result->fetch_assoc()): ?>
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 12px;"><?= $row['id']; ?></td>
                                <td style="padding: 12px;"><?= htmlspecialchars($row['firstname']); ?></td>
                                <td style="padding: 12px;"><?= htmlspecialchars($row['lastname']); ?></td>
                                <td style="padding: 12px;">
                                    <a href="Update .php?id=<?= $row['id']; ?>" style="color: #3b82f6; text-decoration: none; margin-right: 10px;">Edit</a>
                                    <a href="Delete.php?id=<?= $row['id']; ?>" style="color: #ef4444; text-decoration: none;" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="padding: 16px; text-align: center; color: #64748b;">No students found in system.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>