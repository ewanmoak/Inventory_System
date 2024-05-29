<?php

if (isset($_GET['logout'])) {
    if (isset($_GET['stay']) && $_GET['stay'] == 'true') {
      // User wants to stay logged in (implement logic based on role)
      // Here, you'll need to check the user's role (stored in session or database)
      // and redirect them to the appropriate homepage based on their role.
      // Example (assuming role is stored in session):
      if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('location: admin_homepage.php');
      } else {
        header('location: user_homepage.php'); // Replace with actual user homepage
      }
      exit();
    } else {
      // User confirms logout
      session_destroy();
      unset($_SESSION['user_id']);
      header('location: login.php');
      exit();
    }
  }
?>