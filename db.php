<?php
$servername = "localhost";
$username = "root"; 
$password = "varad@111";     
$dbname = "student_attendance"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
