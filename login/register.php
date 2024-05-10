<?php
session_start();

// Redirect to index.php if user is already logged in
if (isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}

// initializing variables
$username = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'inventory');

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Auto-create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($db, $sql);

// REGISTER USER
if (isset($_POST['register_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); // encrypt the password before saving in the database
        $query = "INSERT INTO users (username, password) VALUES('$username', '$password')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Engineering Inventory Management System - Registration</h3>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password_1" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password_2" placeholder="Confirm Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" class="btn" name="register_user">Register</button>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
        <?php if(isset($errors) && count($errors) > 0) { ?>
            <div class="error-message">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </form>
</div>
</body>
</html>
