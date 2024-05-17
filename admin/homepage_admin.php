<?php
session_start();
include "connect.php";

$admin_content = "<h1>Welcome to the Admin Homepage!</h1>
<p>This is some content specific to the admin user.</p>";

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
  header('location: login.php'); // Redirect to login page (assuming it exists)
  exit();
}

// Check if user is admin
if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
  echo $admin_content;
} else {
  // Handle non-admin users (e.g., redirect to a different page)
  echo "You are not authorized to access this page.";
}

if (isset($_GET['logout'])) {
  if (isset($_SESSION['success'])) {
    // Display success message from previous login (optional)
    echo $_SESSION['success'];
    unset($_SESSION['success']);
  }

  // Confirmation message and logout link
  echo "Are you sure you want to log out?";
  ?>
  <a href="logout.php">Yes, Log Out</a>
  <a href="#">Cancel</a>
  <?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="d-flex flex-column h-100 justify-content-center">
  <h1 class="text-center">Dashboard</h1>
  <nav class="bg-light d-flex flex-column px-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="ad_cpetools.php">CPE Tools</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ad_ietools.php">IE Tools</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#users">Users Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </nav>
</header>

<?php if (isset($admin_content)): ?>
  <?php echo $admin_content; ?>
<?php endif; ?>

</body>
</html>
