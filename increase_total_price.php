<?php
session_start();

// Check if the bid amount is provided in the request
if (isset($_POST['bid'])) {
  $bid = intval($_POST['bid']); // Convert the bid amount to an integer
  
  // Check if the total price is set in the session
  if (isset($_SESSION['total_price'])) {
    $_SESSION['total_price'] += $bid; // Increase the total price by the bid amount
  } else {
    $_SESSION['total_price'] = $bid; // Initialize the total price with the bid amount
  }
}
?>
