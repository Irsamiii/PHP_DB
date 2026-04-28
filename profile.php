<?php
ob_start();
session_start();

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

// Fetch only this user's data
$id   = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }

        .sidebar {
    width: 220px;
    height: 100vh;
    background: #2c3e50;
    color: white;
    position: fixed;
    padding: 20px;
    top: 0;
    left: 0;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    color: white;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin: 15px 0;
    padding: 8px;
    border-radius: 5px;
}

.sidebar a:hover {
    background: #34495e;
}

.main {
    margin-left: 240px;
    padding: 30px;
}
        
        .card {
            background: white; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 36px; width: 100%; max-width: 480px;
            align-self: center; margin: 0 auto;
        }

        .avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: #2c3e50; color: white;
            font-size: 32px; display: flex;
            align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }

        h2 { text-align: center; color: #333; margin-bottom: 6px; }
        .role-badge {
            text-align: center; margin-bottom: 24px;
        }
        .role-badge span {
            background: #eaf4ff; color: #123c1d;
            padding: 4px 12px; border-radius: 20px; font-size: 13px;
        }

        .info-row {
            display: flex; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f0f0f0;
            font-size: 15px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; font-weight: bold; }
        .info-value { color: #333; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Connect</h2>

    <a href="dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <div class="card">

        <div class="avatar">
            <?php echo strtoupper(substr($user['fname'], 0, 1)); ?>
        </div>

        <h2><?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></h2>
        <div class="role-badge">
            <span><?php echo htmlspecialchars($user['role']); ?></span>
        </div>

        <div class="info-row">
            <span class="info-label">First Name</span>
            <span class="info-value"><?php echo htmlspecialchars($user['fname']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Last Name</span>
            <span class="info-value"><?php echo htmlspecialchars($user['lname']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Gender</span>
            <span class="info-value"><?php echo htmlspecialchars($user['gender']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value"><?php echo htmlspecialchars($user['role']); ?></span>
        </div>

    </div>
</div>

</body>
</html>