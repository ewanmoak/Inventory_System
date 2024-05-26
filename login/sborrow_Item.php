<?php
include "admin_connect1.php";

// Check if user is logged in (replace with your authentication logic)
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  echo json_encode(array("error" => "Unauthorized access. Please login."));
  exit();
}

$toolId = isset($_POST['tool_id']) ? intval($_POST['tool_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($toolId > 0 && $quantity > 0) {
  $studentId = $_SESSION['user_id']; // Retrieve student ID from session
  $borrowedDate = date('Y-m-d'); // Today's date

  // Prepared statement to prevent SQL injection (recommended)
  $stmt = mysqli_prepare($db, "INSERT INTO borrowed_items (student_id, id_tool, borrowed_date, quantity) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "iiii", $studentId, $toolId, $borrowedDate, $quantity);

  if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array("message" => "Item borrowed successfully!"));
  } else {
    echo json_encode(array("error" => "Failed to add item: " . mysqli_error($db)));
  }

  mysqli_stmt_close($stmt);
} else {
  echo json_encode(array("error" => "Invalid data provided."));
}

mysqli_close($db);
?>