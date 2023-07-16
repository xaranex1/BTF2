<?php
// Start or resume the session
session_start();

// Function to count the number of active users based on sessions
function countActiveUsers() {
  $activeUsers = array(); // Array to store unique active users

  // Iterate through all active sessions
  foreach ($_SESSION as $key => $value) {
    // Check if the session key represents a user ID (adjust this based on your session structure)
    if (strpos($key, 'user_id_') === 0) {
      $userId = substr($key, 8); // Extract the user ID from the session key

      // Add the user ID to the array of active users (avoid duplicates)
      if (!in_array($userId, $activeUsers)) {
        $activeUsers[] = $userId;
      }
    }
  }

  // Return the count of active users
  return count($activeUsers);
}

// Usage example
$activeUserCount = countActiveUsers();
echo "Number of active users: " . $activeUserCount;
?>
