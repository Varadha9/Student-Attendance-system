<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $subject_name = $_POST['subject_name'];
    $date_time = $_POST['date_time'];

    $stmt = $conn->prepare("INSERT INTO attendance (student_name, subject_name, date_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $student_name, $subject_name, $date_time);

    if ($stmt->execute()) {
        echo "Attendance marked successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
