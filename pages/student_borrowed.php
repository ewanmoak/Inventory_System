<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "borrowers"; // Make sure this is the correct database name

// Create connection
$db = mysqli_connect($servername, $username, $password);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!mysqli_query($db, $sql)) {
    die("Error creating database: " . mysqli_error($db));
}

// Select the database
mysqli_select_db($db, $dbname);

// SQL to create the users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    status VARCHAR(10) DEFAULT 'offline' NOT NULL
)";
if (!mysqli_query($db, $sql)) {
    die("Error creating users table: " . mysqli_error($db));
}

// SQL to create the tools table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS tools (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tool_name VARCHAR(50) NOT NULL,
    quantity INT(11) NOT NULL
)";
if (!mysqli_query($db, $sql)) {
    die("Error creating tools table: " . mysqli_error($db));
}

// SQL to create the borrowed_items table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS borrowed_items (
    student_id INT(11),
    id_tool INT NOT NULL,
    quan INT NOT NULL,
    borrowed_date DATE NOT NULL,
    returned_date DATE,
    returned_time TIME,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (id_tool) REFERENCES tools(id)
)";
if (!mysqli_query($db, $sql)) {
    die("Error creating borrowed_items table: " . mysqli_error($db));
} else {
    echo "Table Borrowed Items created successfully<br>";
}

// Retrieve the student ID and last accessed tool ID from the session
$student_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$last_accessed_tool_id = isset($_SESSION['last_accessed_tool_id']) ? $_SESSION['last_accessed_tool_id'] : '';

function displayRecords($result) {
    if ($result) {
        echo '<div class="table-container">';
        echo "<table>";
        echo "<tr><th>Tool ID:</th><th>Quantity:</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $itemId = $row['id_tool'];
            $isReturned = !empty($row['returned_date']); // Check if a returned date is set
            echo "<tr>";
            echo "<td>" . $row['id_tool'] . "</td>";
            echo "<td>" . $row['quan'] . "</td>";
            echo "<td>";
            if ($isReturned) {
                echo "Returned";
            } else {
                echo '<button id="returnButton_' . $itemId . '" data-item-id="' . $itemId . '">Return</button>';
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo '</div>';
    } else {
        echo "Error retrieving data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Items Form</title>
    <style>
        /* Basic form styling */
        form {
            width: fit-content;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 15px;
        }
        button[type="submit"] {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        /* Center the table */
        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        /* Table Styles */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px; /* Adjust the max width as needed */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Borrowed Items Form</h1>
<form method="post" action="process_borrow.php">
    <label for="student_id">Student ID:</label>
    <input type="number" name="student_id" id="student_id" value="<?php echo htmlspecialchars($student_id); ?>" required>
    <br>
    <label for="id_tool">Tool ID:</label>
    <input type="number" name="id_tool" id="id_tool" value="<?php echo htmlspecialchars($last_accessed_tool_id); ?>" required>
    <br>
    <label for="quan">Quantity:</label>
    <input type="number" name="quan" id="quan" min="1" required> (Enter 1 for borrowing a single tool)
    <br>
    <label for="borrowed_date">Borrowed Date:</label>
    <input type="date" name="borrowed_date" id="borrowed_date" value="<?php echo date('Y-m-d'); ?>" readonly>
    <br>
    <label for="returned_date">Returned Date:</label>
    <input type="date" name="returned_date" id="returned_date">
    <br>
    <label for="returned_time">Returned Time:</label>
    <input type="time" name="returned_time" id="returned_time">
    <br>
    <button type="submit">Submit</button>
</form>
<?php
// Retrieve existing records (optional)
$sql = "SELECT * FROM borrowed_items";
$result = mysqli_query($db, $sql);
displayRecords($result);
?>
<!-- Display success message if exists -->
<?php if (!empty($success_message)): ?>
    <div class="success">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>
<script>
    const returnButtons = document.querySelectorAll("[id^='returnButton_']");
    returnButtons.forEach(button => {
        button.addEventListener("click", function() {
            const itemId = this.dataset.itemId;
            this.textContent = "Returned";
            this.disabled = true;
            // Consider sending an AJAX request to update the status on the server-side
        });
    });
</script>
</body>
</html>
