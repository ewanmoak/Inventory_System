<?php
include "connect.php";
include "search.php";

// Create tables (if not exist)
/*
$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(255) NOT NULL  -- Renamed 'category' to 'category_name' for clarity
)";
mysqli_query($db, $sql);
*/
$sql = "CREATE TABLE IF NOT EXISTS tools (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tool_name VARCHAR(255) NOT NULL,
  quantity INT(11) NOT NULL,
  def TEXT NOT NULL,
  category_name VARCHAR(255) NOT NULL,
  category_id INT(11) NOT NULL,
)";
mysqli_query($db, $sql);

// Retrieve data from tools table
$sql = "SELECT * FROM tools";
$result = mysqli_query($db, $sql);

if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {
  // Process the results with accurate column names
  while ($row = mysqli_fetch_assoc($result)) {
    $tool_name = $row['tool_name'];
    $quantity = $row['quantity'];
    $def = $row['def'];
    $category_name = $row['category_name'];
    $category_id = $row['category_id']; 
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
  border: 5px solid #ddd;
  padding: 10px;
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
  <h1>Tool Records</h1>

  <?php
  // Include connection details
  include "connect.php";

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr>
              <th>Tool Name</th>
              <th>Quantity</th>
              <th>Description</th>
              <th>Category</th>
              <th>Category ID</th>
              <th>Action</th> </tr>";
  
      while ($row = mysqli_fetch_assoc($result)) {
        $tool_id = $row['id']; // Assuming an 'id' column exists
  
        echo "<tr>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['tool_name'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['quantity'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['def'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['category_name'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['category_id'] . "</span></td>";
  
        // Edit and Delete buttons with tool ID as data attribute
        echo "<td>
                  <button class='edit-btn' data-id='$tool_id'>Edit</button>
                  <button class='delete-btn' data-id='$tool_id'>Delete</button>
                </td>";
        echo "</tr>";
      }
  
      echo "</table>";
    } else {
      echo "Error retrieving data";
    }
  }

  // Process form submission (if submitted)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_name = $_POST['tool_name'];
    $quantity = $_POST['quantity'];
    $def = $_POST['def'];
    $category_name = $_POST['category_name'];
    $category_id = $_POST['category_id'];

    // Validate input (optional, add checks for data types, etc.)
    if (empty($tool_name) || empty($quantity) || empty($def) || empty($category_name) || empty($category_id)) {
      echo "Please fill in all required fields.";
    } else {
      // Insert data into database
      $sql = "INSERT INTO tools (tool_name, quantity, def, category_name, category_id ) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($db, $sql);
      mysqli_stmt_bind_param($stmt, "iss", $tool_name, $quantity, $def, $category_name, $category_id);
      if (mysqli_stmt_execute($stmt)) {
        echo "Tool record added successfully!";
      } else {
        echo "Error adding record: " . mysqli_error($db);
      }
      mysqli_stmt_close($stmt);
    }
  }

  // Retrieve existing records (optional)
  $sql = "SELECT * FROM tools";
  $result = mysqli_query($db, $sql);

  ?>

<button id="add-tool-btn">Add</button>

<div id="add-tool-container" style="display: none;">  <h2>Add New Tool Record</h2>
  <form method="post" id="add-tool-form">
    <label for="tool_name">Tool Name:</label>
    <input type="text" name="tool_name" id="tool_name" required><br>
    <label for="def">Description:</label>
    <textarea name="def" id="def" rows="5" required></textarea><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" required><br>
    <label for="category_name">Category:</label>
    <input type="text" name="category_name" id="category_name" required><br>
    <label for="quantity">Category ID:</label>
    <input type="text" name="category_id" id="category_id" required><br>
    <button type="submit">Add Record</button>
  </form>
</div>

  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

</body>
<script>
const addToolButton = document.getElementById('add-tool-btn');
const addToolContainer = document.getElementById('add-tool-container');

addToolButton.addEventListener('click', function() {
  addToolContainer.style.display = (addToolContainer.style.display === 'none') ? 'block' : 'none';
});

  </script>



<script>
const editButtons = document.querySelectorAll('.edit-btn');
console.log(editButtons);
const deleteButtons = document.querySelectorAll('.delete-btn');

// Loop through edit buttons and add click event listener
editButtons.forEach(button => {
  button.addEventListener('click', function() {
    const span = this.parentElement.previousElementSibling.firstChild; // Get the corresponding span element (data cell)
    // Toggle contenteditable attribute (on for edit, off for save)
    span.setAttribute('contenteditable', span.getAttribute('contenteditable') === 'false' ? 'true' : 'false');
  });
});

// Loop through delete buttons and add click event listener
deleteButtons.forEach(button => {
  button.addEventListener('click', function() {
    const toolId = this.dataset.id; // Get tool ID from data attribute

    // Confirmation prompt before sending delete request
    if (confirm("Are you sure you want to delete this record?")) {
      // Send AJAX request to delete record
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'delete_tool.php'); // Replace with your server-side script for deletion
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Handle successful deletion (e.g., remove row from table)
          console.log('Record deleted successfully');
          // Update table content (optional)
          // You can reload the entire table or update the specific row
        } else {
          console.error('Error deleting record:', xhr.statusText);
        }
      };
      xhr.send(`tool_id=${toolId}`); // Send tool ID as data in POST request
    }
  });
});

// **Functionality for updating database based on changes (with error handling)**
const table = document.querySelector('table');

table.addEventListener('blur', function(event) {
  if (event.target.tagName === 'SPAN' && event.target.contentEditable === 'true') {
    const span = event.target;
    const toolId = span.dataset.id;
    const newValue = span.textContent; // Get the updated value

    // Send AJAX request to update record
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_tool.php'); // Replace with your server-side script for update
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Handle successful update
        console.log('Record updated successfully');
        // Update table content (optional)
        // You can update the specific cell content here
        span.textContent = newValue; // Update cell content locally
      } else {
        console.error('Error updating record:', xhr.statusText);
        // Display error message to user (optional)
        alert('Error updating record. Please try again.');
      }
    };
    xhr.send('tool_id='+toolId+'&new_value='+newValue); // Send tool ID and new value
  }
});
</script>
</html>
