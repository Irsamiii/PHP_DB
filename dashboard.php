<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
}

$role = $_SESSION['role'];

// Get all users
$result = mysqli_query($conn, "SELECT * FROM users");
$i = 1;
$totalUsers = mysqli_num_rows($result);
?>

<link rel="stylesheet" href="style.css">

<div class="sidebar">
    <h2>Connect</h2>
    <a href="#">Home</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">

    <div class="card">
        <h2>Welcome, <?php echo $_SESSION['fname']; ?></h2>
    </div>

    <div class="card">
        <h3>Total Users: <?php echo $totalUsers; ?></h3>
    </div>

    <div class="card">
        <h3>Users List</h3>

        <table>
            <tr>
                <th>Number</th>
                <th>Username</th>
                <th>Email</th>
                <?php if ($role == 'admin') echo "<th>Actions</th>"; ?>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['email']; ?></td>

                    <?php if ($role == 'admin') { ?>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">
                                <button class="btn btn-edit">Edit</button>
                            </a>

                            <a href="delete.php?id=<?php echo $row['id']; ?>">
                                <button class="btn btn-delete">Delete</button>
                            </a>
                        </td>
                    <?php } ?>

                </tr>
            <?php } ?>
        </table>

    </div>

</div>
