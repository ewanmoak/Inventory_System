<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
   
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            color: #666;
            transition: color 0.3s ease;
        }
        .logout:hover {
            color: #333;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logout" onclick="location.href='index.php?logout=true'">
        <i class='bx bx-log-out-circle'></i> Logout
    </div>
    <div class="welcome">
        <h2>Engineering Inventory Management System</h2>
        <p>Hi <?php echo $_SESSION['username']; ?>,</p>
    </div>
    <div class="content">

        <p>This is the home page. You can add your content here.</p>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
