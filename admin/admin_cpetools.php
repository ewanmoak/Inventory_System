<?php 
include "connect.php";






$sql = "CREATE TABLE IF NOT EXISTS categories (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE,
)";
$sql = "CREATE TABLE IF NOT EXISTS tools (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    unique_id VARCHAR(255),
    name VARCHAR(255),
    date_manufactured DATE,
    expiration_date DATE,
    maintenance_date DATE,
    quantity INT(11),
    description TEXT,
    student_id VARCHAR(255),
    status VARCHAR(255),
    category_id INT(11),
  )";

mysqli_query($db, $sql);

$sql = "SELECT * FROM categories";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // We have data
    while($row = mysqli_fetch_assoc($result)) {
        echo "Category Name: " . $row["name"] . "<br>";
    }
} else {
    echo "No categories found";
}

mysqli_close($conn);
?>