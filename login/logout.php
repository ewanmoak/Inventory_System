<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'login');
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

if (isset($_GET['logout'])) {
  // Logout logic
  session_destroy(); // Destroy session data
  header('location: login.php'); // Redirect to login page
  exit();
}

?>