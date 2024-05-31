<?php
session_start();

// Database connection details for the login database
$loginServername = "localhost";
$loginUsername = "root";
$loginPassword = "";
$loginDbname = "login";

// Database connection details for the inventory database
$inventoryServername = "localhost";
$inventoryUsername = "root";
$inventoryPassword = "";
$inventoryDbname = "inventory";

// Database connection details for the borrowers database
$borrowersServername = "localhost";
$borrowersUsername = "root";
$borrowersPassword = "";
$borrowersDbname = "borrowers";

// Create connection to the login database
$loginDb = new mysqli($loginServername, $loginUsername, $loginPassword, $loginDbname);
if ($loginDb->connect_error) {
    die("Login database connection failed: " . $loginDb->connect_error);
}

// Create connection to the inventory database
$inventoryDb = new mysqli($inventoryServername, $inventoryUsername, $inventoryPassword, $inventoryDbname);
if ($inventoryDb->connect_error) {
    die("Inventory database connection failed: " . $inventoryDb->connect_error);
}

// Create connection to the borrowers database
$borrowersDb = new mysqli($borrowersServername, $borrowersUsername, $borrowersPassword, $borrowersDbname);
if ($borrowersDb->connect_error) {
    die("Borrowers database connection failed: " . $borrowersDb->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $studentId = $_POST['student_id'];
    $toolId = $_POST['id_tool'];
    $quantity = $_POST['quan'];
    $borrowedDate = $_POST['borrowed_date'];
    $returnedDate = $_POST['returned_date']; // Optional, might be empty if not returned yet
    $returnedTime = $_POST['returned_time']; // Optional, might be empty if not returned yet

    // Basic validation (optional, improve based on your needs)
    if (!is_numeric($studentId) || !is_numeric($toolId) || !is_numeric($quantity) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $borrowedDate) || ($returnedDate && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $returnedDate))) {
        echo "Invalid data submitted.";
        exit;
    }

    // Check if student ID exists in users table of the login database
    $checkStudentSql = "SELECT * FROM users WHERE id = ?";
    $checkStmt = $loginDb->prepare($checkStudentSql);
    $checkStmt->bind_param("i", $studentId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo "Invalid student ID.";
        $checkStmt->close();
        $loginDb->close();
        $inventoryDb->close();
        $borrowersDb->close();
        exit;
    }
    $checkStmt->close();

    // Check if tool ID exists in tools table of the inventory database
    $checkToolSql = "SELECT * FROM tools WHERE id = ?";
    $checkToolStmt = $inventoryDb->prepare($checkToolSql);
    $checkToolStmt->bind_param("i", $toolId);
    $checkToolStmt->execute();
    $resultTool = $checkToolStmt->get_result();

    if ($resultTool->num_rows == 0) {
        echo "Invalid tool ID.";
        $checkToolStmt->close();
        $loginDb->close();
        $inventoryDb->close();
        $borrowersDb->close();
        exit;
    }
    $checkToolStmt->close();

    // Insert statement into the borrowers database
    $sql = "INSERT INTO borrowed_items (student_id, id_tool, quan, borrowed_date, returned_date, returned_time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $borrowersDb->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iiisss", $studentId, $toolId, $quantity, $borrowedDate, $returnedDate, $returnedTime);

        if ($stmt->execute()) {
            echo "Successfully borrowed a tool!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $borrowersDb->error;
    }

    // Close connections
    $loginDb->close();
    $inventoryDb->close();
    $borrowersDb->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 40px;
        }

        h1, h2 {
            margin-bottom: 10px;
        }

        header {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

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

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #800000; /* Maroon */
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

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="homepage_student.php">Home</a>
            <a href="borrowedItems_list.php">Borrowed Tools</a>
        </nav>
    </header>
    <div class="table-container">
        <form method="POST" action="process_borrow.php">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>

            <label for="id_tool">Tool ID:</label>
            <input type="text" id="id_tool" name="id_tool" required>

            <label for="quan">Quantity:</label>
            <input type="number" id="quan" name="quan" required>

            <label for="borrowed_date">Borrowed Date:</label>
            <input type="date" id="borrowed_date" name="borrowed_date" required>

            <label for="returned_date">Returned Date (optional):</label>
            <input type="date" id="returned_date" name="returned_date">

            <label for="returned_time">Returned Time (optional):</label>
            <input type="time" id="returned_time" name="returned_time">

            <button type="submit">Borrow Tool</button>
        </form>
    </div>
</body>
</html>
