<?php

function fetchNotifications() {
  // Replace with your actual server-side script URL
  $url = '/get-notifications.php'; 

  try {
    $response = fetch($url);
    if (!($response->ok)) {
      throw new Exception("Error fetching notifications: " . $response->status);
    }
    
    $data = json_decode($response->getBody(), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("Error decoding notification data: " . json_last_error_msg());
    }
    
    return $data;
  } catch (Exception $e) {
    // Handle errors (e.g., log the error or display a user-friendly message)
    echo "Failed to fetch notifications: " . $e->getMessage();
    return []; // Return an empty array in case of error
  }
}

// Example usage (call this function from your main script)
$notifications = fetchNotifications();
if (!empty($notifications)) {
  updateNotifications($notifications);
} else {
  // Handle case where no notifications are retrieved (e.g., display message)
  echo "No notifications found.";
}
