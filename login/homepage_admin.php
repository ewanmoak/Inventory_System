<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'login');
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$admin_content = "<h1>Welcome to the Admin Homepage!</h1>
<p>This is some content specific to the admin user.</p>";

// Check if user is admin
if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
  echo $admin_content;
} else {
  header('login.php'); // Redirect to login page if not admin
  exit();
}

if (isset($_GET['logout'])) {
  if (isset($_SESSION['success'])) {
    // Display success message from previous login (optional)
    echo $_SESSION['success'];
    unset($_SESSION['success']);
  }
}
?>

<!--
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
        <a class="nav-link" href="?logout=true">Logout</a>
      </li>
    </ul>
  </nav>
</header>

<?php if (isset($admin_content)): ?>
    <?php echo $admin_content; ?>
<?php endif; ?>

</body>
</html>
