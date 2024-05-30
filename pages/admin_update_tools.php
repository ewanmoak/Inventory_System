<?php

include "admin_connect.php";

$tool_id = $_POST["tool_id"]; // Assuming your form has a hidden field with tool ID
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING); // Sanitize name
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING); // Sanitize description

$sql = "UPDATE tool_records 
        SET name = ?, description = ?
        WHERE tool_id = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("sss", $name, $description, $tool_id); // Bind parameters to prevent SQL injection

if ($stmt->execute()) {
  echo "Tool record updated successfully!";
} else {
  echo "Error updating record: " . $db->error;
}

$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Tool Record</title>

  <script>
    const updateButton = document.getElementById('update-button'); // Replace with your button ID

updateButton.addEventListener('click', function() {
  const toolId = document.getElementById('tool-id').value; // Assuming tool ID is in an input field with ID 'tool-id'
  const name = document.getElementById('name').value; // Assuming name is in an input field with ID 'name'
  const description = document.getElementById('description').value; // Assuming description is in an input field with ID 'description'

  // Send AJAX request to update_tool.php (replace with your server-side script)
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_tool.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      if (xhr.responseText === 'success') {
        console.log('Tool record updated successfully!');
        // Optionally, update the UI to reflect the changes (e.g., display a success message)
      } else {
        console.error('Error updating record:', xhr.responseText);
        // Optionally, display an error message to the user
      }
    } else {
      console.error('Error updating record:', xhr.statusText);
    }
  };

  xhr.send('tool_id='+toolId+'&name='+encodeURIComponent(name)+'&description='+encodeURIComponent(description)); // Encode special characters
});

  </script>
</head>
<body>
  <h1>Update Tool Record</h1>
  <?php
  // Assuming you have a script to retrieve tool information based on ID (modify as needed)
  $tool_info = get_tool_info($tool_id); // Replace with your function to retrieve data
  if ($tool_info) {
  ?>
  <form action="update_tool_record.php" method="post">
    <input type="hidden" name="tool_id" value="<?php echo $tool_info['tool_id']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $tool_info['name']; ?>">
    <br>
    <label for="description">Description:</label>
    <textarea name="description" id="description"><?php echo $tool_info['description']; ?></textarea>
    <br>
    <input type="submit" value="Update Tool Record">
  </form>
  <?php } else { ?>
    <p>Error: Could not find tool record with ID: <?php echo $tool_id; ?></p>
  <?php } ?>

</body>
</html>