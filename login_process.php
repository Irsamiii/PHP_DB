<?php
ob_start(); // buffer output - prevents header errors
session_start();

include 'connection.php';

if (isset($_POST['submit'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username'] = $user['fname'];
            $_SESSION['role']      = $user['role'];

            ob_end_clean();
           if ($user['role'] == 'admin') {
    header("Location: dashboard.php"); // admin dashboard
} else {
    header("Location: dashboard.php"); // user dashboard (same page, different view)
}
            exit();
        }
    }

    ob_end_clean();
    header("Location: login.php?error=1");
    exit();
}
?>