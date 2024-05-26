<?php
// Include connection details
include "admin_connect.php";

$sql = "CREATE TABLE IF NOT EXISTS tool_maintenance (
  tool_id INT(11),
  FOREIGN KEY (tool_id) REFERENCES tools(id),
  maintenance_date DATE NOT NULL,
  note TEXT NOT NULL,
  email VARCHAR(255) NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table tool_maintenance created successfully";
}
/*
// ---- Email content preparation (assuming maintenance description is available)
$recipient_email = "recipient@example.com"; // Replace with actual recipient email
$subject = "Tool Maintenance Reminder: " . $tool_name;
$maintenance_description = "Sample maintenance description"; // Replace with actual description

$body = "This is a friendly reminder that the maintenance for " . $tool_name . " is due on " . $maintenance_date . ".

Please refer to the following description for the maintenance procedure:

" . $maintenance_description . "

If the maintenance has already been performed, you can disregard this email.

Thank you.";

// ---- Send email notification
$mail = new PHPMailer(true);

try {
  // Server settings (replace with your email server details if needed)
  $mail->SMTPDebug = 0; // Set to 0 or 2 for detailed debugging
  $mail->isSMTP();
  $mail->Host = 'smtp.example.com'; // Replace with your SMTP server address
  $mail->SMTPAuth = true;
  $mail->Username = $dianeendaya4@gmail.com;
  $mail->Password = $nvzn wisg wwrs zhme;
  $mail->SMTPSecure = 'tls'; // Adjust encryption if needed (e.g., 'ssl')
  $mail->Port = 587; // Replace with your SMTP port

  // Sender and recipient information
  $mail->setFrom($sender_email, 'Tool Maintenance System');
  $mail->addAddress($recipient_email);
  $mail->addReplyTo($sender_email, 'Tool Maintenance System');

  // Content
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $body;

  $mail->send();
  echo 'Message has been sent successfully.';
} catch (Exception $e) {
  echo "Error sending email: " . $e->getMessage();
}

mysqli_close($db); // Close the connection

?>

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
*/
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
  include "admin_connect.php";

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr><th>Tool ID</th><th>Maintenance Date</th><th>Note</th><th>Email</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['tool_id'] . "</td>";
        echo "<td>" . $row['maintenance_date'] . "</td>";
        echo "<td>" . $row['note'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
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
    $email = $_POST['email'];
  }
    // Validate input (add checks for data types, etc.)
if (empty($tool_id) || empty($maintenance_date) || empty($note) || empty($email)) {
  echo "Please fill in all required fields.";
} else {
  // Improved validation (consider adding more specific checks)
  if (!strtotime($maintenance_date)) {
    echo "Invalid date format. Please use YYYY-MM-DD.";
    exit(); // Stop script execution on invalid date
  }

  // Insert data into database
  $sql = "INSERT INTO tool_maintenance (tool_id, maintenance_date, note, email) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($db, $sql);

  // Optional: Adjust data types based on your table schema
  mysqli_stmt_bind_param($stmt, "isss", $tool_id, $maintenance_date, $note, $email);

  if (mysqli_stmt_execute($stmt)) {
    echo "Maintenance record added successfully!";
  } else {
    // Improved error handling
    $error = mysqli_stmt_error($stmt);
    echo "Error adding record: $error";
  }

  mysqli_stmt_close($stmt); // Close the statement
  
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
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>
    <button type="submit">Add Record</button>
  </form>

  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

</body>
</html>