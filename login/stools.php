<?php

$db = mysqli_connect('localhost', 'root', '', 'inventory'); // Assuming correct connection details

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}



$stmt = mysqli_prepare($db, "SELECT id, tool_name FROM tools"); // Select id and tool_name

// Check if statement preparation was successful
if (!$stmt) {
  echo "Error preparing statement: " . mysqli_error($db);
  exit();
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $toolId = $row['id'];
    $toolName = $row['tool_name'];

    echo "<section class='section'>";
    echo "<div class='container'>";
    echo "  <div class='row mb-4 align-items-center'>";
    echo "    <div class='col-md-6' data-aos='fade-up'>";
    echo "      <div class='card'>";
    echo "        <h2>$toolName</h2>"; // Display tool name directly
    echo "        <button class='work-single.php?tool_id=$toolId'>View Details</button>";
    // ... rest of your card content (optional)
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
    echo "</section>";
  }
} else {
  echo "No tools found in the database.";
}
mysqli_stmt_close($stmt);
mysqli_close($db);
?>