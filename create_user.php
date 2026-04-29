<?php
session_start();
include 'connection.php';

// 🔒 Only admin allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $role = $_POST['role']; // admin can choose role

    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, gender, role) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $fname, $lname, $email, $password, $gender, $role);

    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
</head>
<body>

<div class="sidebar">
    <h2>Connect</h2>
    <a href="dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="create_user.php" class="active">Add User</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

    <div class="card">
        <h2>Create New User</h2>

        <form method="POST">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" placeholder="Enter first name" required>
        </div>

        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" placeholder="Enter last name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" name="submit" class="btn-submit">Create User</button>
    </form>
</div>

</body>
</html>