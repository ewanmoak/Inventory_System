<?php
include "connect.php";
include "functions.php";


$notifications = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $notifications[] = $row;
  }
}

?>