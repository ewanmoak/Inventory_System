<?php
// Include connection details
include "connect.php";

$sql = "CREATE TABLE IF NOT EXISTS tool_maintenance (
  tool_id INT(11) NOT NULL,
  FOREIGN KEY (tool_id) REFERENCES tools(id),
  maintenance_date DATE NOT NULL,
  note TEXT NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table tool_maintenance created successfully";
}

$sql = "SELECT * FROM tool_maintenance";
$result = mysqli_query($db, $sql);

if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {
  // Process the results (optional)
  while ($row = mysqli_fetch_assoc($result)) {
    $tool_id = $row['tool_id'];
    $maintenance_date = $row['maintenance_date'];
    $note = $row['note'];
  }
}

mysqli_close($db); // Close the connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Maintenance Records</title>
  <style>
  body {
  font-family: Arial, sans-serif;
  margin: 20px;
}

h1, h2 {
  margin-bottom: 10px;
}

/* Table Styles */

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

/* Form Styles */

form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="date"],
textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 10px;
  cursor: pointer;
  border-radius: 4px;
}

/* Error Styles (Optional) */

.error {
  color: red;
  font-weight: bold;
  margin-top: 10px;
}
</style>
</head>

<body>
  <h1>Tool Maintenance Records</h1>

  <?php
  // Include connection details
  include "connect.php";

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr><th>Tool ID</th><th>Maintenance Date</th><th>Note</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['tool_id'] . "</td>";
        echo "<td>" . $row['maintenance_date'] . "</td>";
        echo "<td>" . $row['note'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "Error retrieving data";
    }
  }

  // Process form submission (if submitted)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_id = $_POST['tool_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $note = $_POST['note'];

    // Validate input (optional, add checks for data types, etc.)
    if (empty($tool_id) || empty($maintenance_date) || empty($note)) {
      echo "Please fill in all required fields.";
    } else {
      // Insert data into database
      $sql = "INSERT INTO tool_maintenance (tool_id, maintenance_date, note) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($db, $sql);
      mysqli_stmt_bind_param($stmt, "iss", $tool_id, $maintenance_date, $note);
      if (mysqli_stmt_execute($stmt)) {
        echo "Maintenance record added successfully!";
      } else {
        echo "Error adding record: " . mysqli_error($db);
      }
      mysqli_stmt_close($stmt);
    }
  }

  // Retrieve existing records (optional)
  $sql = "SELECT * FROM tool_maintenance";
  $result = mysqli_query($db, $sql);

  ?>

  <h2>Add New Maintenance Record</h2>
  <form method="post">
    <label for="tool_id">Tool ID:</label>
    <input type="number" name="tool_id" id="tool_id" required><br>
    <label for="maintenance_date">Maintenance Date:</label>
    <input type="date" name="maintenance_date" id="maintenance_date" required><br>
    <label for="note">Note:</label>
    <textarea name="note" id="note" rows="5" required></textarea><br>
    <button type="submit">Add Record</button>
  </form>

  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

</body>
</html>
