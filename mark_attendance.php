<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['username'])){
header("Location: ../login.php");
exit();
}

include "../db.php";

$success="";
$error="";
$students=[];
$selectedClass="";
$selectedDate=date("Y-m-d");

// get classes
$classes=$conn->query("SELECT DISTINCT class FROM students ORDER BY class");

// save attendance
if(isset($_POST['mark_attendance'])){

$date=$_POST['date'];
$attendance=$_POST['attendance'] ?? [];

if(empty($attendance)){
$error="Please mark attendance";
}else{

foreach($attendance as $student_id=>$status){

$stmt=$conn->prepare("INSERT INTO attendance(student_id,date,status) VALUES(?,?,?)");
$stmt->bind_param("iss",$student_id,$date,$status);
$stmt->execute();
$stmt->close();

}

$success="Attendance saved successfully";

}

}

// load students
if(isset($_GET['class']) && isset($_GET['date'])){

$selectedClass=$_GET['class'];
$selectedDate=$_GET['date'];

$stmt=$conn->prepare("
SELECT s.id,s.roll_number,s.name,a.status
FROM students s
LEFT JOIN attendance a
ON s.id=a.student_id AND a.date=?
WHERE s.class=?
ORDER BY s.roll_number
");

$stmt->bind_param("ss",$selectedDate,$selectedClass);
$stmt->execute();
$result=$stmt->get_result();

while($row=$result->fetch_assoc()){
$students[]=$row;
}

$stmt->close();

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Mark Attendance</title>

<style>

body{
font-family:Arial;
background:#eef1f7;
padding:40px;
}

.container{
background:white;
padding:30px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:10px;
border:1px solid #ccc;
text-align:center;
}

button{
padding:10px 20px;
background:#2575fc;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

.success{color:green;}
.error{color:red;}

</style>

</head>

<body>

<div class="container">

<h2>Mark Attendance</h2>

<?php if($success!=""){ echo "<p class='success'>$success</p>"; } ?>
<?php if($error!=""){ echo "<p class='error'>$error</p>"; } ?>

<!-- select class -->

<form method="GET">

<select name="class" required>

<option value="">Select Class</option>

<?php
while($class=$classes->fetch_assoc()){
?>

<option value="<?php echo $class['class']; ?>" <?php if($selectedClass==$class['class']) echo "selected"; ?>>
<?php echo $class['class']; ?>
</option>

<?php } ?>

</select>

<input type="date" name="date" value="<?php echo $selectedDate; ?>">

<button type="submit">Load Students</button>

</form>

<?php if(!empty($students)){ ?>

<form method="POST">

<input type="hidden" name="date" value="<?php echo $selectedDate; ?>">

<table>

<tr>
<th>Roll</th>
<th>Name</th>
<th>Present</th>
<th>Absent</th>
</tr>

<?php foreach($students as $student){ ?>

<tr>

<td><?php echo $student['roll_number']; ?></td>

<td><?php echo $student['name']; ?></td>

<td>
<input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="present"
<?php if(($student['status'] ?? '')=='present') echo "checked"; ?>>
</td>

<td>
<input type="radio" name="attendance[<?php echo $student['id']; ?>]" value="absent"
<?php if(($student['status'] ?? '')=='absent') echo "checked"; ?>>
</td>

</tr>

<?php } ?>

</table>

<br>

<button type="submit" name="mark_attendance">Save Attendance</button>

</form>

<?php } ?>

<br>

<a href="../dashboard.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>
