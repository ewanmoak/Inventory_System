<?php
session_start();

// Redirect to index.php if user is already logged in
if (isset($_SESSION['user_id'])) {
  header('location: index.php');
  exit();
}

// initializing variables
$user_id = "";
$errors = array(); 

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'login');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Auto-create table if it doesn't exist (consider a separate script for production)
$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(10) NOT NULL,
  name VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL,
)";
mysqli_query($db, $sql);

// LOGIN USER
if (isset($_POST['login_user'])) {
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($user_id)) {
        array_push($errors, "User ID is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE user_id='$user_id' AND password='$password'";
        $results = mysqli_query($db, $query);
    
        if (mysqli_num_rows($results) == 1) {
          $row = mysqli_fetch_assoc($results);
          // Assuming password is not hashed (for testing only, use secure hashing in production)
          $password = $row['password'];
    
        if ($password === $password) { // Replace with password_verify for production
            $_SESSION['user_id'] = $user_id;
            $role = $row['role'];  // Assuming a user_type field exists

        if ($role === "admin") {
          $_SESSION['success'] = "Welcome Admin, you are now logged in";
          header('location: homepage_admin.php');  // Redirect to admin homepage
        } else {
          $_SESSION['success'] = "You are now logged in";
          header('location: homepage_student.php');  // Redirect to student homepage
          exit();
        }
 
          } else {
            array_push($errors, "Wrong User ID/password combination");
          }
        } else {
          array_push($errors, "Wrong User ID/password combination");
        }
      }
    }
    


// LOGOUT USER
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('location: login.php');
    print_r($_POST);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Engineering Inventory Management System</h3>
        <div class="input-box">
            <input type="text" name="user_id" placeholder="User ID" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="remember-forgot">
            <label><input type="checkbox" name="remember">Remember Me</label>
            <a href="#">Forgot Password</a>
        </div>
        <button type="submit" class="btn" name="login_user">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
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
