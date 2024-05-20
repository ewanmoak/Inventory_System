<?php
// Include connection details
include "connect.php";

// Create tables (if they don't exist)
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(255) NOT NULL,

)";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS tools (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tool_name VARCHAR(255) NOT NULL,
  quantity INT(11) NOT NULL,
  def TEXT NOT NULL,
  category_id INT(11) NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id),
)";
mysqli_query($db, $sql);

// Check for existing categories
$sql = "SELECT * FROM categories";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<h2>Existing Categories</h2>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "Category Name: " . $row["category_name"] . "<br>";
  }
} else {
  echo "No categories found";
}

// Add tool functionality
if (isset($_POST['submit'])) {
  // Sanitize user input (prevent SQL injection)
  $tool_name = mysqli_real_escape_string($db, $_POST['tool_name']);
  $quantity = (int)mysqli_real_escape_string($db, $_POST['quantity']); // Cast to integer
  $def = mysqli_real_escape_string($db, $_POST['def']);
  $category_id = (int)mysqli_real_escape_string($db, $_POST['category_id']); // Cast to integer

  // Prepare and execute insert query
  $sql = "INSERT INTO tools (id, tool_name, quantity, def, category_id,)
          VALUES ('$tool_name', $quantity, '$def', $category_id)";
  if (mysqli_query($db, $sql)) {
    echo "<br>Tool added successfully!";
  } else {
    echo "<br>Error adding tool: " . mysqli_error($db);
  }
}

// HTML form for adding tools
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Management System</title>
</head>
<body>
  <h1>Add New Tool</h1>
  <form method="post">
    <label for="tool_name">Tool Name:</label>
    <input type="text" name="tool_name" id="tool_name" required><br><br>

    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity" id="quantity" required><br><br>

    <label for="def">Description:</label>
    <input type="text" name="def" id="df" required><br><br>

    <label for="category_id">Category ID:</label>
    <input type="text" name="category_id" id="category_id"><br><br>

    <?php

// Define categories and their prefixes
$categories = array(
  "CPE Tools" => "af",
  "IE Tools" => "ag"
);

?>

<label for="category_id">Category:</label>
<select name="category_id" id="category_id" required>
  <option value="">Select Category</option>
  <?php foreach ($categories as $category => $prefix) : ?>
    <optgroup label="<?php echo $category; ?>">
      <?php for ($i = 1; $i <= 50; $i++) : ?>
        <option value="<?php echo $prefix . $i; ?>">
          <?php echo $prefix . $i; ?>
        </option>
      <?php endfor; ?>
    </optgroup>
  <?php endforeach; ?>
</select>
    </select><br><br>

    <button type="submit">Add Tool</button>
  </form>
</body>
</html>
