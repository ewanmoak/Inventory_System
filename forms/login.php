<?php
  //session_start();
  include "logout.php";

  // Redirect to homepage_student if user is already logged in
  if (isset($_SESSION['user_id'])) {
    header('location: homepage_student.php');
    exit();
  }

  // initializing variables
  $user_id = "";
  $errors = array(); 

  // Connect to the database
  $db = mysqli_connect('localhost', 'root', '', 'login');

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

  // Auto-create table if it doesn't exist (consider a separate script for production)
  $sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL
  )";
  mysqli_query($db, $sql);

  // LOGIN USER
  if (isset($_POST['login_user'])) {
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($user_id)) {
      array_push($errors, "User ID is required");
    }
    if (empty($password)) {
      array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
      $query = "SELECT * FROM users WHERE user_id='$user_id'";
      $results = mysqli_query($db, $query);
    
      if (mysqli_num_rows($results) == 1) {
        $row = mysqli_fetch_assoc($results);

        // Hashing user-entered password before comparison
        $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Use a cost of at least 12

        if (password_verify($password, $row['password'])) { // Verify with hashed password
          $_SESSION['user_id'] = $user_id;
          $role = $row['role'];  // Assuming a user_type field exists

          if ($role === "admin") {
            $_SESSION['success'] = "Welcome Admin, you are now logged in";
            header('location: homepage_admin.php');  // Redirect to admin homepage
          } else {
            $_SESSION['success'] = "You are now logged in";
            header('location: homepage_student.php');  // Redirect to student homepage
          }
          exit();
        } else {
          array_push($errors, "Wrong User ID/password combination");
        }
      } else {
        array_push($errors, "Wrong User ID/password combination");
      }
    }
  }
?>