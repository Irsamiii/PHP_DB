<?php
$servername = "localhost";
$username = "root";
$password = "mia_cara";
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    exit('Connection failed: ' . $conn->connect_error);
}
?>