<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include "db.php";

$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username=$_POST['username'];
    $password=$_POST['password'];

    $stmt=$conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $result=$stmt->get_result();

    if($result->num_rows>0){

        $user=$result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['username']=$user['username'];

            header("Location: dashboard.php");
            exit();

        }else{
            $error="Incorrect password!";
        }

    }else{
        $error="User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>

body{
font-family: Arial;
background:#eef1f7;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.login-box{
background:white;
padding:30px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
width:300px;
text-align:center;
}

input{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ccc;
border-radius:5px;
}

button{
width:100%;
padding:10px;
background:#2575fc;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#6a11cb;
}

.error{
color:red;
}

</style>
</head>

<body>

<div class="login-box">

<h2>Login</h2>

<?php
if($error!=""){
echo "<p class='error'>$error</p>";
}
?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<br>

<a href="register.php">Register</a>

</div>

</body>
</html>
