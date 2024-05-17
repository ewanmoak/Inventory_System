<?php

include "connect.php";


if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']); // Sanitize user input

    if (!empty($searchTerm)) {
      // Implement search logic here
      // (e.g., query database based on $searchTerm)

      // Example (replace with your actual search implementation):
      $sql = "SELECT * FROM tools WHERE name LIKE '%$searchTerm%'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        echo "<h3>Search Results for '$searchTerm':</h3>";
        // Display search results here (loop through $result)
      } else {
        echo "No matching tools found for your search.";
      }
    } else {
      echo "Please enter a search term.";
    }
  }
?>


<!DOCTYPE html>
<html>
<head>
  <style>
    .search-bar {
      position: absolute;
      top: 10px; /* Adjust top and right values for positioning */
      right: 10px;
      display: flex; /* Arrange search box and button horizontally */
    }
  </style>
</head>
<body>
  <div class="search-bar">
    <form action="" method="post">
      <input type="text" name="search" placeholder="Search CPE/IE tools...">
      <button type="submit">Search</button>
    </form>
  </div>

  <?php
    // ... your existing PHP code ...
  ?>
</body>
</html>
