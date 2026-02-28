<?php
include 'db.php';

$sql = "SELECT * FROM attendance ORDER BY date_time DESC";
$result = $conn->query($sql);

$attendanceList = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $attendanceList[] = $row;
    }
}

echo json_encode($attendanceList);
?>
