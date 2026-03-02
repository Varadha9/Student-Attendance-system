<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Attendance System</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  Student Attendance System
</header>

<nav>
  <ul>
    <li><a href="#home">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>

    <?php if(!isset($_SESSION['username'])): ?>
      <li><a href="#register">Register</a></li>
      <li><a href="#login">Login</a></li>
    <?php else: ?>
      <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- HOME -->
<section id="home">
  <h2>Welcome to the Student Attendance System</h2>
  <p>This system allows faculty members to register and login.</p>
</section>

<!-- ABOUT -->
<section id="about">
  <h2>About</h2>
  <p>This system helps faculty manage student attendance digitally.</p>
</section>

<!-- CONTACT -->
<section id="contact">
  <h2>Contact Us</h2>
  <form>
    <input type="text" placeholder="Name" required><br>
    <input type="email" placeholder="Email" required><br>
    <textarea placeholder="Message" required></textarea><br>
    <button type="submit">Submit</button>
  </form>
</section>

<!-- REGISTER -->
<section id="register">
  <h2>Register as Faculty</h2>
  <form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="faculty_name" placeholder="Faculty Name" required><br>
    <button type="submit">Register</button>
  </form>
</section>

<!-- LOGIN -->
<section id="login">
  <h2>Login as Faculty</h2>
  <form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
  </form>
</section>

<footer>
  &copy; 2025 Student Attendance System. All rights reserved.
</footer>

</body>
</html>
