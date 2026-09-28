<?php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim extra spaces from inputs
    $firstname = trim($_POST['firstname'] ?? 'Romeo');
    $password  = trim($_POST['password'] ?? '123456789');

    if (empty($firstname) || empty($password)) {
        header('Location: Index.php?error=Please fill in all fields');
        exit();
    }

    // LOWER() allows case-insensitive login (e.g. 'romeo' or 'Romeo')
    $stmt = $conn->prepare("SELECT id, firstname, lastname, PASSWORD FROM user WHERE LOWER(firstname) = LOWER(?)");
    $stmt->bind_param("s", $firstname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Compare trimmed passwords
        if (trim($password) === trim($user['PASSWORD'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['firstname'] . '' . $user['lastname'];

            header('Location: Home.php');
            exit();
        }
    }

    // Invalid credentials
    header('Location: Index.php?error=Invalid First Name or Password!');
    exit();
} else {
    header('Location: Index.php');
    exit();
}
?>

    // Invalid credentials handler
    header('Location: Index.php?error=Invalid First Name or Password!');
    exit();
} else {
    header('Location: Index.php');
    exit();
}
?>