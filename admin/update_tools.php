<?php

include "connect.php";

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