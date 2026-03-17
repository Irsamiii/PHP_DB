<?php
include 'connection.php';
if (isset($_POST['submit'])){
$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$stmt = $conn->prepare("INSERT INTO users (fname,lname,email,password,gender) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss",$first_name,$last_name,$email,$password,$gender);
if($stmt->execute()){
    echo "New record created successfully";
}else{
    echo "Error: " .$stmt->error;
}
$stmt->close();
$conn->close();
}
?>
<html>
    <a class = "btn btn-info" href = "signup.html"><br><br>Back</a>
     <a class = "btn btn-info" href = "read.php"><br><br>View Record</a>
    
</html>