<?php
ob_start();
session_start();

// Protect dashboard - only admins allowed
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['edit', 'delete', 'admin'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        .navbar {
            background: #2c3e50; color: white;
            padding: 16px 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar h1 { font-size: 20px; }
        .navbar a { color: #e74c3c; text-decoration: none; font-size: 14px; }
        .container { padding: 30px; }
        h2 { margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th { background: #2c3e50; color: white; padding: 12px 16px; text-align: left; font-size: 14px; }
        td { padding: 12px 16px; border-bottom: 1px solid #eee; font-size: 14px; color: #444; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9f9f9; }
        .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-block; }
        .btn-edit { background: #3498db; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn-edit:hover { background: #2980b9; }
        .btn-delete:hover { background: #c0392b; }
        .success { background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Admin Dashboard</h1>
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp;|&nbsp;
        <a href="logout.php">Logout</a>
    </span>
</div>

<div class="container">
    <h2>All Users</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p class="success"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['fname']); ?></td>
                    <td><?php echo htmlspecialchars($row['lname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td>
                        <?php if (in_array($_SESSION['role'], ['edit', 'admin'])): ?>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <?php endif; ?>
                        <?php if (in_array($_SESSION['role'], ['delete', 'admin'])): ?>
                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-delete"
                               onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center;">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>