<?php
// Include connection details
include "connections.php";

// Get form data
$studentId = $_POST['student_id'];
$toolId = $_POST['id_tool'];
$quantity = $_POST['quan'];
$borrowedDate = $_POST['borrowed_date'];
$returnedDate = $_POST['returned_date']; // Optional, might be empty if not returned yet
$returnedTime = $_POST['returned_time']; // Optional, might be empty if not returned yet

// Basic validation (optional, improve based on your needs)
if (!is_numeric($studentId) || !is_numeric($toolId) || !is_numeric($quantity) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $borrowedDate) || ($returnedDate && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $returnedDate))) {
  echo "Invalid data submitted.";
  exit;
}

// Insert statement
$sql = "INSERT INTO borrowed_items (student_id, id_tool, quan, borrowed_date, returned_date, returned_time) VALUES ($studentId, $toolId, $quantity, '$borrowedDate', '$returnedDate', '$returnedTime')";

if (mysqli_query($db, $sql)) {
  echo "Successfully borrowed a tool!";
}

// Close connection (optional)
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Borrowed Items</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>

<h2>Borrowed Items</h2>
<?php
// Include connection details
include "admin_connect1.php";

// Get form data (moved inside POST check)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $student_id = $_POST['student_id'];
  $id_tool = $_POST['id_tool'];
  $quan = $_POST['quan'];
  $borrowed_date = $_POST['borrowed_date'];
  $returned_date = $_POST['returned_date'];
  $returned_time = $_POST['returned_time'];

}

// Basic validation (optional, improve based on your needs)
if (!is_numeric($studentId) || !is_numeric($toolId) || !is_numeric($quantity) || !strtotime($borrowed_date) || ($returnedDate && !strtotime($returnedDate))) {
  echo "Invalid data submitted.";
  exit;
}

// Improved validation (consider using DateTime objects for robust date handling)
if (!strtotime($borrowed_date)) {
  echo "Invalid borrowed date format. Please use YYYY-MM-DD.";
  exit();
}

if (!strtotime($returned_date)) {
  echo "Invalid returned date format. Please use YYYY-MM-DD.";
  exit();
}

// Insert data into database (using prepared statement)
$sql = "INSERT INTO borrowed_items (student_id, id_tool, quan, borrowed_date, returned_date, returned_time) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($db, $sql);

if (!$stmt) {
    echo "Error preparing statement: " . mysqli_error($db);
    exit;
  }

$borrowedDateTimestamp = strtotime($borrowedDate);
$returnedDateTimestamp = ($returnedDate) ? strtotime($returnedDate) : null; // Handle null for empty returned date


// Adjust data types based on your table schema
mysqli_stmt_bind_param($stmt, "iiisss", $student_id, $id_tool, $quan, $borrowed_date, $returned_date, $returned_time);

if (mysqli_stmt_execute($stmt)) {
  $success_message = "Borrowed Item record added successfully!";  // Set success message
} else {
  // Improved error handling (consider logging errors)
  $error = mysqli_stmt_error($stmt);
  echo "Error adding record: $error";
}



// Retrieve existing records (optional)
$sql = "SELECT * FROM borrowed_items";
$result = mysqli_query($db, $sql);

displayRecords($result);

// Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo '<div class="table-container">';
      echo "<table>";
      echo "<tr><th>Student ID:</th><th>Tool ID:</th><th>Quantity:</th><th>Borrowed Date:</th><th>Return Date:</th><th>Return Time:</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['student_id'] . "</td>";
        echo "<td>" . $row['id_tool'] . "</td>";
        echo "<td>" . $row['quan'] . "</td>";
        echo "<td>" . $row['borrowed_date'] . "</td>";
        echo "<td>" . $row['returned_date'] . "</td>";
        echo "<td>" . $row['returned_time'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo '</div>';
    } else {
      echo "Error retrieving data";
    }
  }

  mysqli_stmt_close($stmt); // Close the statement

  ?>

    <!-- Display success message if exists -->
    <?php if (!empty($success_message)): ?>
    <div class="success">
      <?php echo $success_message; ?>
    </div>
  <?php endif; ?>

    </body>
</html>