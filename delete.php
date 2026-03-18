<?php
session_start();

// Only admins with delete role
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['delete', 'admin'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard.php"); exit(); }

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: dashboard.php?msg=User deleted successfully");
} else {
    header("Location: dashboard.php?msg=Error deleting user");
}
exit();
?>