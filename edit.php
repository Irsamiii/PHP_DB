<?php
session_start();

// Only admins with edit role
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['edit', 'admin'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard.php"); exit(); }

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname  = $_POST['fname'];
    $lname  = $_POST['lname'];
    $email  = $_POST['email'];
    $gender = $_POST['gender'];
    $role   = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET fname=?, lname=?, email=?, gender=?, role=? WHERE id=?");
    $stmt->bind_param("sssssi", $fname, $lname, $email, $gender, $role, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=User updated successfully");
        exit();
    } else {
        $error = "Update failed: " . $stmt->error;
    }
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) { header("Location: dashboard.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding: 40px; }
        .card { background: white; padding: 32px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 400px; }
        h2 { margin-bottom: 24px; color: #333; }
        label { display: block; margin-bottom: 4px; font-size: 14px; color: #555; }
        input[type="text"], input[type="email"], select {
            width: 100%; padding: 10px; margin-bottom: 16px;
            border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        .radio-group { margin-bottom: 16px; }
        .radio-group label { display: inline; margin-right: 12px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-save   { background: #3498db; color: white; }
        .btn-cancel { background: #aaa; color: white; text-decoration: none; display: inline-block; margin-left: 10px; }
        .error { color: red; margin-bottom: 12px; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Edit User #<?php echo $user['id']; ?></h2>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label>First Name</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>

        <label>Last Name</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Gender</label>
        <div class="radio-group">
            <input type="radio" name="gender" value="male"   <?php echo $user['gender'] === 'male'   ? 'checked' : ''; ?>> <label>Male</label>
            <input type="radio" name="gender" value="female" <?php echo $user['gender'] === 'female' ? 'checked' : ''; ?>> <label>Female</label>
        </div>

        <label>Role</label>
        <select name="role">
            <option value="user"   <?php echo $user['role'] === 'user'   ? 'selected' : ''; ?>>User</option>
            <option value="edit"   <?php echo $user['role'] === 'edit'   ? 'selected' : ''; ?>>Edit</option>
            <option value="delete" <?php echo $user['role'] === 'delete' ? 'selected' : ''; ?>>Delete</option>
            <option value="admin"  <?php echo $user['role'] === 'admin'  ? 'selected' : ''; ?>>Admin</option>
        </select>

        <button type="submit" class="btn btn-save">Save Changes</button>
        <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
    </form>
</div>
</body>
</html>