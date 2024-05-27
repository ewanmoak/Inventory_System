<?php

// Assuming database connection is established (replace with your connection details)
$db = mysqli_connect('localhost', 'root', '', 'inventory');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Retrieve student ID from session
$studentId = $_SESSION['user_id']; // Assuming student ID is retrieved from session

// Get borrowed items for the student
$sql = "SELECT bi.id AS borrow_id, t.tool_name, t.image, bi.quantity, bi.borrowed_date 
        FROM borrowed_items bi
        INNER JOIN tools t ON bi.id_tool = t.id
        WHERE bi.student_id = ?";

$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $studentId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Check for borrowed items
if (mysqli_num_rows($result) > 0) {

  echo "<h2>Borrowed Items</h2>";

  echo "<table>
          <thead>
            <tr>
              <th>Tool Name</th>
              <th>Image</th>
              <th>Quantity</th>
              <th>Borrowed Date</th>
            </tr>
          </thead>
          <tbody>";

  // Loop through borrowed items and display information
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>" . $row['tool_name'] . "</td>
            <td><img src='" . $row['image'] . "' alt='" . $row['tool_name'] . "' width='100'></td>
            <td>" . $row['quantity'] . "</td>
            <td>" . $row['borrowed_date'] . "</td>
          </tr>";
  }

  echo "</tbody>
        </table>";

} else {
  echo "You haven't borrowed any items yet.";
}

mysqli_stmt_close($stmt); // Close prepared statement
mysqli_close($db); // Close connection

// Check for message in query parameter (optional)
if (isset($_GET['message'])) {
  $message = urldecode($_GET['message']); // Decode message
  echo "<p class='message'>$message</p>"; // Display message (add styling as needed)
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrowed Items List</title>
  <link rel="stylesheet" href="style.css">
  <script src="borrowItems.js"></script>
</head>
<body>
  <header>
    <h1>Borrowed Items</h1>
  </header>

  <main>
    <ul id="borrowed-items-list">
      <?php if (!empty($borrowedItems)): ?>
        <?php foreach ($borrowedItems as $item): ?>
          <li>
            <span class="item-name"><?php echo $item; ?></span>
          </li>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="no-items-message">No items currently borrowed.</p>
      <?php endif; ?>
    </ul>
  </main>

  <script src="borrowItems.js"></script>
</body>
</html>