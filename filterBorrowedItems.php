<?php

// Assuming a connection to your database is already established (e.g., using a separate file or included at the beginning)
include "admin_connect1.php";

// Get the selected student ID from the URL parameter (replace 'student_id' with your actual parameter name if different)
$selectedStudentId = $_GET['student_id'];

// Construct the query to filter borrowed items based on student ID
$sql = "SELECT * FROM borrowed_items WHERE student_id = '$selectedStudentId'";

// Execute the query
$result = mysqli_query($db, $sql);

// Check if the query execution was successful
if ($result) {
  // If there are results, prepare the data to send back to the client (borrowItems.js)
  $borrowedItems = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $borrowedItems[] = $row; // Add each row of data to the $borrowedItems array
  }

  // Encode the borrowed items data in JSON format for easier processing in JavaScript
  $jsonData = json_encode($borrowedItems);

  // Send the JSON data back to the client (borrowItems.js)
  header('Content-Type: application/json');
  echo $jsonData;
} else {
  // Handle query error (optional)
  echo "Error fetching borrowed items."; // Replace with more specific error handling if needed
}

// Close the database connection (assuming it's not handled elsewhere)
mysqli_close($db);

?>
