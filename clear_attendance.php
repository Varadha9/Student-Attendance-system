<?php
include 'db.php';

$sql = "DELETE FROM attendance";

if ($conn->query($sql) === TRUE) {
    echo "All attendance records cleared.";
} else {
    echo "Error: " . $conn->error;
}
?>
