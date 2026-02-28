<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $faculty_name = $_POST['faculty_name'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, faculty_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $faculty_name);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
