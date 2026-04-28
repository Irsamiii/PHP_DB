<?php
include 'connection.php';
if (isset($_POST['submit'])){
    $first_name = $_POST['fname'];
    $last_name  = $_POST['lname'];
    $email      = $_POST['email'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hashing
    $gender     = $_POST['gender'];
    $role       = 'user'; // default role for new signups

    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, gender, role) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $password, $gender, $role);

    if ($stmt->execute()) {

    // get the new user id
    $user_id = $stmt->insert_id;

    // start session
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;
    $_SESSION['fname'] = $first_name;

    // redirect to dashboard
    header("Location: dashboard.php");
    exit();
} else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<body>
    <a href="signup.html">Back to Signup</a>
</body>
</html>
    
</html>