<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$host = "sql200.infinityfree.com";
$user = "if0_41272147";
$password = "ADT23SOCB1574";
$database = "if0_41272147_student_attendance";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>

