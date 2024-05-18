<?php
// Include connection details
include "connect.php";

// Create tables (if they don't exist)
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE,
)";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS tools (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  date_manufactured DATE,
  expiration_date DATE,
  maintenance_date DATE,
  quantity INT(11),
  description TEXT,
  student_info VARCHAR(255),
  status VARCHAR(255),
  category_id INT(11),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  img_url VARCHAR(255),
)";
mysqli_query($db, $sql);

// Check for existing categories
$sql = "SELECT * FROM categories";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<h2>Existing Categories</h2>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "Category Name: " . $row["name"] . "<br>";
  }
} else {
  echo "No categories found";
}

// Add tool functionality
if (isset($_POST['submit'])) {
  // Sanitize user input (prevent SQL injection)
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $date_manufactured = mysqli_real_escape_string($db, $_POST['date_manufactured']);
  $expiration_date = mysqli_real_escape_string($db, $_POST['expiration_date']);
  $maintenance_date = mysqli_real_escape_string($db, $_POST['maintenance_date']);
  $quantity = (int)mysqli_real_escape_string($db, $_POST['quantity']); // Cast to integer
  $description = mysqli_real_escape_string($db, $_POST['description']);
  $student_info = mysqli_real_escape_string($db, $_POST['student_info']);
  $status = mysqli_real_escape_string($db, $_POST['status']);
  $category_id = (int)mysqli_real_escape_string($db, $_POST['category_id']); // Cast to integer

  // Prepare and execute insert query
  $sql = "INSERT INTO tools (unique_id, name, date_manufactured, expiration_date, maintenance_date, quantity, description, student_info, status, category_id)
          VALUES ('$name', '$date_manufactured', '$expiration_date', '$maintenance_date', $quantity, '$description', '$student_info', '$status', $category_id)";
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
    <label for="name">Tool Name:</label>
    <input type="text" name="name" id="name" required><br><br>

    <label for="date_manufactured">Date Manufactured:</label>
    <input type="date" name="date_manufactured" id="date_manufactured" required><br><br>

    <label for="expiration_date">Expiration Date:</label>
    <input type="date" name="expiration_date" id="expiration_date"><br><br>

    <label for="maintenance_date">Maintenance Date:</label>
    <input type="date" name="maintenance_date" id="maintenance_date"><br><br>

    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity" id="quantity" required><br><br>

    <label for="description">Description:</label>
    <input type="text" name="description" id="description" required><br><br>

    <label for="student_info">Student Information:</label>
    <input type="text" name="student_info" id="student_info" required><br><br>

    <label for="status">Status:</label>
    <input type="text" name="estatus" id="status"><br><br>

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
