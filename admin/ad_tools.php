<?php
include "connect.php";

// Create tables (if not exist)
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(255) NOT NULL  -- Renamed 'category' to 'category_name' for clarity
)";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS tools (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tool_name VARCHAR(255) NOT NULL,
  quantity INT(11) NOT NULL,
  def TEXT NOT NULL,
  category_id INT(11) NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  category_name VARCHAR(255) NOT NULL  
)";
mysqli_query($db, $sql);

// Retrieve data from tools table
$sql = "SELECT t.*, c.category_name  -- Corrected alias for category_name
        FROM tools t
        INNER JOIN categories c ON t.category_id = c.id";  // Join with categories table

$result = mysqli_query($db, $sql);

if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {
  // Process the results with accurate column names
  while ($row = mysqli_fetch_assoc($result)) {
    $tool_name = $row['tool_name'];
    $quantity = $row['quantity'];
    $def = $row['def'];
    $category_id = $row['category_id'];
    $category_name = $row['category_name']; // Access category name from the join
    // Process the retrieved data here (optional)
  }
}

mysqli_close($db); // Close the connection

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Records</title>
</head>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f1f1f1;
    }
  </style>
<body>
  <h1>Tool Records</h1>
<?php
if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {
  // Display tools in a table
  echo "<h2>Tools</h2>";
  echo "<table>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Tool Name</th>";
  echo "<th>Quantity</th>";
  echo "<th>Description</th>";
  echo "<th>Category</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  while ($row = mysqli_fetch_assoc($result)) {
    $tool_name = $row['tool_name'];
    $quantity = $row['quantity'];
    $def = $row['def']; // Renamed from 'def'
    $category_name = $row['category_name'];

    echo "<tr>";
    echo "<td>$tool_name</td>";
    echo "<td>$quantity</td>";
    echo "<td>$def</td>";
    echo "<td>$category_name</td>";
    echo "</tr>";
  }

  echo "</tbody>";
  echo "</table>";
}
?>

</body>
</html>
