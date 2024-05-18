<?php
include "connect.php";

$cpe_content = "<h1>CPE Tools</h1>";

// Assuming you have a database table for tools (modify as needed)
// Retrieve categories
$sql_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($db, $sql_categories);

// Retrieve tools
$sql_tools = "SELECT * FROM tools";
$result_tools = mysqli_query($db, $sql_tools);

if ($result_tools) { // Check if query was successful
  // Proceed with using $result_tools
  if (mysqli_num_rows($result_tools) > 0) {
    // Loop through results
  } else {
    echo "No tools found.";
  }
  mysqli_close($db); // Close connection within successful execution block
} else {
  // Handle query error (optional)
  echo "Error retrieving tools: " . mysqli_error($db);
}

// Removed the extra closing curly brace and else statement
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin CPE Tools</title>
  <style>
    /* Optional styling for tool containers */
    .tool-container {
      display: inline-block;
      margin: 10px;
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    .tool-container img {
      width: 150px;
      height: 150px;
    }
  </style>
</head>
</html>