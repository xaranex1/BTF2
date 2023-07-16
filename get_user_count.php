<?php


// Check if the user count is stored in the session
if (!isset($_SESSION['user_count'])) {
  // Initialize the user count
  $_SESSION['user_count'] = 1;
} else {
  // Increment or decrement the user count based on the 'action' parameter
  if ($_GET['action'] === 'increment') {
    $_SESSION['user_count']++;
  } elseif ($_GET['action'] === 'decrement') {
    $_SESSION['user_count']--;
  }
}

// Return the user count as the response
echo $_SESSION['user_count'];
