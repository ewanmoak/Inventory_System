<?php

// Assuming database connection is established (replace with your connection details)
$db = mysqli_connect('localhost', 'root', '', 'inventory');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Retrieve data from form submission
$tool_id = isset($_POST['tool_id']) ? intval($_POST['tool_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
$studentId = $_SESSION['user_id']; // Assuming student ID is retrieved from session

// Check for valid data
if ($tool_id > 0 && $quantity > 0) {
  // Prepare a statement to prevent SQL injection (recommended)
  $stmt = mysqli_prepare($db, "INSERT INTO borrowed_items (student_id, id_tool, borrowed_date, quantity) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "iiii", $studentId, $tool_id, date('Y-m-d'), $quantity);

  // Execute the statement and handle success/failure
  if (mysqli_stmt_execute($stmt)) {
    // Borrow successful! Redirect to borrowed items list with a success message
    header("Location: sborrowItems_list.php?message=Borrow successful!");
    exit();
  } else {
    // Borrow failed! Redirect to borrowed items list with an error message
    $errorMessage = "Borrow failed: " . mysqli_error($db);
    header("Location: sborrowItems_list.php?message=" . urlencode($errorMessage));
    exit();
  }

  mysqli_stmt_close($stmt);
} else {
  // Invalid data! Redirect to borrowed items list with an error message
  $errorMessage = "Invalid data provided.";
  header("Location: sborrowItems_list.php?message=" . urlencode($errorMessage));
  exit();
}

mysqli_close($db); // Close connection
?>