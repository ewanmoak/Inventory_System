<?php
// Include connection details
include "admin_connect1.php";
include "admin_connect.php";

$sql = "CREATE TABLE IF NOT EXISTS borrowed_items (
  student_id INT(11),
  FOREIGN KEY (student_id) REFERENCES users(id),
  id_tool INT NOT NULL,
  FOREIGN KEY (id_tool) REFERENCES tools(id),
  quan INT NOT NULL,
  FOREIGN KEY (quan) REFERENCES tools(quantity),
  borrowed_date DATE NOT NULL,
  returned_date DATE NOT NULL,
  returned_time TIME NOT NULL
)";

$sql = "CREATE TABLE IF NOT EXISTS tools (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tool_name VARCHAR(255) NOT NULL,
    quantity INT(11) NOT NULL,
    def TEXT NOT NULL,
    category_name VARCHAR(255) NOT NULL,
    category_id INT(11) NOT NULL
  )";


if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table Borrower's Lists created successfully";
}


// Get tool ID from the URL parameter
$toolId = $_GET['id'];

// Check if tool ID exists
$sql = "SELECT * FROM tools WHERE id = $toolId";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $toolName = $row['tool_name'];
  $quantity = $row['quantity']; // Assuming quantity exists in the tools table

  // Check if student is logged in (implement your logic here)
  // Assuming a session variable `student_id` is set for the logged-in student
  $studentId = $_SESSION['student_id'];

  // Handle borrow functionality (example using a separate borrow function)
  if (isset($_POST['borrow'])) {
    $borrowedDate = date("Y-m-d"); // Today's date
    $returnedDate = null; // Initially set returned date to null
    $returnedTime = null;  // Initially set returned time to null

    if (borrowTool($studentId, $toolId, $quantity, $borrowedDate, $returnedDate, $returnedTime)) {
      echo "<p>Successfully borrowed $toolName!</p>";
      // Update quantity in the tools table (assuming a function to update quantity)
      updateToolQuantity($toolId, $quantity - 1); // Decrement quantity on successful borrow
    } else {
      echo "<p>Error borrowing tool. Please try again.</p>";
    }
  }

  // Display tool details and a borrow form (if quantity is available)
  echo "<h2>$toolName</h2>";
  if ($quantity > 0) {
    echo "<form method='post'>";
    echo "<input type='hidden' name='id' value='$toolId'>";
    echo "<button type='submit' name='borrow' class='btn btn-primary'>Borrow Tool</button>";
    echo "</form>";
  } else {
    echo "<p>This tool is currently unavailable for borrowing.</p>";
  }
} else {
  echo "<p>Tool not found.</p>";
}


function borrowTool($studentId, $toolId, $quantity, $borrowedDate, $returnedDate, $returnedTime) {
    global $db; // Access the global $db connection variable
  
    // Check if the tool has enough quantity for borrowing
    $sql = "SELECT quantity FROM tools WHERE id = $toolId";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
  
    if ($row['quantity'] >= $quantity) {
      // Prepare and execute the insert query
      $sql = "INSERT INTO borrowed_items (student_id, id_tool, quan, borrowed_date, returned_date, returned_time) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($db, $sql);
  
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiiiis", $studentId, $toolId, $quantity, $borrowedDate, $returnedDate, $returnedTime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return true; // Return true on successful insertion
      } else {
        echo "Error preparing statement: " . mysqli_error($db);
        return false;
      }
    } else {
      echo "<p>Insufficient quantity. Only " . $row['quantity'] . " available for borrowing.</p>";
      return false;
    }
  }

  function updateToolQuantity($toolId, $newQuantity) {
    global $db; // Access the global $db connection variable
  
    // Prepare and execute the update query
    $sql = "UPDATE tools SET quantity = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);
  
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ii", $newQuantity, $toolId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    } else {
      echo "Error preparing statement: " . mysqli_error($db);
    }
  }

  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CPE TOOL</title>
  <script src="borrowItems.js"></script>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">CPE Hand Tool</a>
    </div>
  </nav>

  <main id="main">

    <section class="section">
      <div class="container">
        <div class="row mb-4 align-items-center">
          <div class="col-md-6" data-aos="fade-up">
            <?php
            $desiredToolId = 1; // The specific tool ID you want to display (replace with dynamic method)

            $stmt = mysqli_prepare($db, "SELECT id, tool_name, quantity, def, category_name, category_id FROM tools"); // Select id and tool_name

            // Check if statement preparation was successful
            if (!$stmt) {
              echo "Error preparing statement: " . mysqli_error($db);
              exit();
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();

              if ($row['id'] == $desiredToolId) {
                $toolId = $row['id'];
                $toolName = $row['tool_name'];
                $def = $row['def'];
                $quantity = $row['quantity'];
                $categoryId = $row['category_id']; // Assuming a separate category table exists
                $categoryName = $row['category_name']; // Assuming category_name is a column in the tools table (or retrieved from a separate query)

                echo "<section class='section'>";
                echo "<div class='container'>";
                echo "  <div class='row mb-4 align-items-center'>";
                echo "    <div class='col-md-6' data-aos='fade-up'>";
                echo "      <div class='card'>";
                echo "        <h2>$toolName</h2>";
                echo "        <p>ID: $toolId</p>"; // Can link to tool_details.php for details page (if applicable)
                echo "        <p>Description: $def</p>";
                echo "        <p>Quantity: $quantity</p>";
                echo "        <p>Category ID: $categoryId</p>";
                echo "        <p>Category: $categoryName</p>"; // Display category name directly

                // Check if quantity is available (optional)
                if ($quantity > 0) {
                  echo "        <a href='student_borrowed.php?tool_id=$toolId' class='btn btn-primary'>Borrow Tool</a>";
                } else {
                  echo "        <p class='text-danger'>This tool is currently unavailable for borrowing.</p>";
                }

                echo "      </div>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
                echo "</section>";
              } else {
                echo "The desired tool (ID: $desiredToolId) was not found in the database.";
              }
            } else {
              echo "No tools found in the database.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($db);
            ?>
          </div>
        </div>
      </div>
    </section>

  </main>

</body>

</html>