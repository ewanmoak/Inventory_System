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

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'login');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Auto-create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(10) NOT NULL,
  name VARCHAR(30) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
)";
mysqli_query($db, $sql);

// REGISTER USER
if (isset($_POST['register_user'])) {
  $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation
  if (empty($user_id)) {
    array_push($errors, "User ID is required");
  }
  if (empty($name)) { // Check for empty name
    array_push($errors, "Name is required");
  }
  if (empty($email)) { // Check for empty name
    array_push($errors, "Email is required");
  }
  if (empty($password_1)) {
    array_push($errors, "Password is required");
  }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // register user if there are no errors in the form
  if (count($errors) == 0) {
    // **Use a secure hashing algorithm instead of md5!**
    $password_1 = password_hash($password_1, PASSWORD_BCRYPT); // Example using bcrypt
  
    // **Add a field for role in your database and form**
    $role = isset($_POST['role']) ? $_POST['POST']['role'] : ''; // Get the selected role from the form
  
    // **Validate role (optional, depending on your implementation)**
    $validRoles = ['student', 'admin']; // Example allowed roles
    if (!in_array($role, $validRoles)) {
      $errors[] = "Invalid role selected.";
    }
  
    if (empty($errors)) {
      $query = "INSERT INTO users (user_id, name, email, password, role) VALUES('$user_id', '$name', '$email', '$password_1', '$role')";
      mysqli_query($db, $query);
  
      $_SESSION['user_id'] = $user_id;
      $_SESSION['name'] = $name;  // Store name in session
  
      // **Redirect based on role**
      if ($role === 'student') {
        $_SESSION['success'] = "You are now registered and logged in as a student.";
        header('location: student_dashboard.php');
      } else if ($role === 'admin') {
        $_SESSION['success'] = "You are now registered and logged in as an admin.";
        header('location: admin_dashboard.php');
      } else {
        // Handle unexpected role (optional)
        $_SESSION['error'] = "An error occurred during registration.";
        header('location: registration.php'); // Redirect back to registration
      }
    }
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
    <style>
    /* General styles */
body {
  font-family: sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f0f0;
}

/* Wrapper styles */
.wrapper {
  background-color: #fff;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  width: 400px;
}

/* Form styles */
form {
  display: flex;
  flex-direction: column;
}

h3 {
  text-align: center;
  margin-bottom: 20px;
}

.input-box {
  margin-bottom: 15px;
  position: relative;
}

.input-box input {
  width: 95%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
}

.input-box i {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  color: #ccc;
  font-size: 18px;
}

.input-box input:focus + i,
.input-box input:valid + i {
  color: #999;
}

/* Role selection styles */
.role {
  margin-bottom: 15px;
  display: flex;
  align-items: center;
}

.role label {
  margin-right: 10px;
}

/* Button styles */
.btn {
  background-color: #671111;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 15px;
}

.btn:hover {
  background-color: #671111;
}

/* Login link styles */
.login-link {
  text-align: center;
  margin-top: 15px;
}

.login-link a {
  color: #671111;
  text-decoration: none;
}

/* Error message styles */
.error-message {
  background-color: #f0ad4e;
  color: #fff;
  padding: 10px;
  border-radius: 3px;
  margin-top: 15px;
}

.error-message p {
  margin-bottom: 5px;
}
</style>

</head>
<body>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Admin Registration</h3>
        <div class="input-box">
            <input type="text" name="user_id" placeholder="User ID" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="text" name="name" placeholder="Name" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="text" name="email" placeholder="Email" required>
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
        <div class="role">
              <label for="role">Select Role:</label>
              <input type="radio" id="role-admin" name="role" value="admin" required>
              <label for="role-admin">Admin</label>
              <input type="radio" id="role-student" name="role" value="student" required>
              <label for="role-user">Student</label>
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
