<?php

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('location: login.php');
    print_r($_POST);
    exit();
}
?>