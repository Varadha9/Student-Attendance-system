<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include "db.php";

$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username=$_POST['username'];
$password=$_POST['password'];

$hashed_password=password_hash($password,PASSWORD_DEFAULT);

$stmt=$conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?, 'user')");
$stmt->bind_param("ss",$username,$hashed_password);

if($stmt->execute()){
$message="Registration successful! Please login.";
}else{
$message="Username already exists!";
}

}
?>

<h2>Register</h2>

<?php
if($message!=""){
echo $message;
}
?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<button type="submit">Register</button>

</form>

<a href="login.php">Login</a>
