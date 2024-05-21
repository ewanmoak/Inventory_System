<?php
include "connect1.php";

$sql = "CREATE TABLE IF NOT EXISTS borrowers(
   id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   student_no INT(30) NOT NULL,
   FOREIGN KEY (student_no) REFERENCES users(user_id),
   program TEXT(255) NOT NULL,
   tool_no INT(11) NOT NULL,
   FOREIGN KEY (tool_no) REFERENCES tools(id)  -- Added closing parenthesis here
  )";
  
if (!mysqli_query($db, $sql)){
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table list created successfully";
}

$sql = "SELECT * FROM list";
$result = mysqli_query($db, $sql);

if (!result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {

  while ($row = mysqli_fetch_assoc(result)){
    $student_no = $row['student_no'];
    $program = $row['program'];
    $tool_no = $row['tool_no'];
  }
}

mysqli_closw($db);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Borrowers</title>
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
  <h1>Borrower's Record</h1>

  <?php
  // Include connection details
  include "connect.php";

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr><th>Student Number</th><th>Program</th><th>Tool ID</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['student_no'] . "</td>";
        echo "<td>" . $row['program'] . "</td>";
        echo "<td>" . $row['tool_no'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "Error retrieving data";
    }
  }

  // Process form submission (if submitted)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no = $_POST['student_no'];
    $program = $_POST['program'];
    $tool_no = $_POST['tool_no'];

    // Validate input (optional, add checks for data types, etc.)
    if (empty($student_no) || empty($program) || empty($tool_no)) {
      echo "Please fill in all required fields.";
    } else {
      // Insert data into database
      $sql = "INSERT INTO list (student_no, program, tool_no) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($db, $sql);
      mysqli_stmt_bind_param($stmt, "iss", $student_no, $program, $tool_no);
      if (mysqli_stmt_execute($stmt)) {
        echo "Maintenance record added successfully!";
      } else {
        echo "Error adding record: " . mysqli_error($db);
      }
      mysqli_stmt_close($stmt);
    }
  }

  // Retrieve existing records (optional)
  $sql = "SELECT * FROM list";
  $result = mysqli_query($db, $sql);

  ?>

  <h2>Borrower's Record</h2>
  <form method="post">
    <label for="student_no">Student Number:</label>
    <input type="number" name="student_no" id="student_no" required><br>
    <label for="program">Program:</label>
    <input type="text" name="program" id="program" required><br>
    <label for="tool_no">Tool ID:</label>
    <input type="number" name="tool_no" id="tool_no" required><br>
    <button type="submit">Add Record</button>
  </form>

  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

</body>
</html>
