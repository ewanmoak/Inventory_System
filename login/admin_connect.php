<?php

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'inventory');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

?>