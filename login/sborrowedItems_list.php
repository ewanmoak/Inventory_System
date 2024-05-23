<?php


$db = mysqli_connect('localhost', 'root', '', 'borrowers');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Sample data (replace with actual database connection and retrieval logic)
$sql = "CREATE TABLE IF NOT EXISTS borrowed_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT NOT NULL,  -- Foreign key referencing student table
  id_tool INT NOT NULL,     -- Foreign key referencing tools table
  borrowed_date DATE,
  returned_date DATE,
  return_time DATETIME,
  FOREIGN KEY (student_id) REFERENCES list(student_no),  -- Link to student table
  FOREIGN KEY (id_tool) REFERENCES tools(id)        -- Link to tools table
)";


if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table tool_maintenance created successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrowed Items List</title>
</head>
<body>

  <h1>Borrowed Items</h1>

  <?php if (!empty($borrowedItems)): ?>
    <ul id="borrowed-items-list">
      <?php foreach ($borrowedItems as $item): ?>
        <li><?php echo $item; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No items currently borrowed.</p>
  <?php endif; ?>

</body>
</html>