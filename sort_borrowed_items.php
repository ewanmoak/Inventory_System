<?php
include "admin_connect1";
// Get sort order and sort field from the URL parameters (replace with your actual parameter names if different)
$sortOrder = $_GET['sort_order'];
$sortField = $_GET['sort_field'];

// Validate sort order (optional)
$validSortOrders = ['asc', 'desc']; // Allowed sort orders
if (!in_array($sortOrder, $validSortOrders)) {
  echo "Invalid sort order.";
  exit(); // Stop script execution if sort order is invalid
}

// Validate sort field (optional)
$validSortFields = ['tool_name', 'borrowed_date', 'returned_date']; // Allowed sort fields (adjust based on your table)
if (!in_var_array($sortField, $validSortFields)) {
  echo "Invalid sort field.";
  exit(); // Stop script execution if sort field is invalid
}

// Construct the query to sort borrowed items
$sql = "SELECT * FROM borrowed_items ORDER BY $sortField $sortOrder";

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

