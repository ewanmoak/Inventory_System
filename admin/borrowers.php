<?php
session_start();
include "connect";

// Check if user is logged in and admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "admin") {
  header('location: login.php'); // Redirect to login if not admin
  exit();
}

// Include connection script (modify path as needed)

// Define variables (optional, for filtering or searching borrowers)
$search_term = ""; // Placeholder for search term

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'borrowers');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Build query to fetch borrowers (modify as needed)
$sql = "SELECT * FROM borrowers";

// Add search functionality (optional)
if ($search_term) {
  $sql .= " WHERE (name LIKE '%$search_term%' OR borrower_id LIKE '%$search_term%')"; 
}

$result = mysqli_query($db, $sql);

// Check if query was successful
if (!$result) {
  echo "Error retrieving borrowers: " . mysqli_error($db);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Homepage - Borrowers</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <nav>
    <ul>
      <li><a href="admin_cpetools.php">CPE Tools</a></li>
      <li><a href="admin_ietools.php">IE Tools</a></li>
      <li class="active"><a href="#">Borrowers</a></li>
      <li><a href="?logout=1">Logout</a></li>
    </ul>
  </nav>

  <h1>Borrowers</h1>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="text" name="search" placeholder="Search Borrowers">
    <button type="submit">Search</button>
  </form>

  <?php if ($result->num_rows > 0) { ?>
  <table>
    <thead>
      <tr>
        <th>Borrower ID</th>
        <th>Name</th>
        </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['borrower_id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } else { ?>
    <p>No borrowers found.</p>
  <?php } ?>

  <?php
mysqli_close($db); // Close database connection
?>

</body>
</html>
