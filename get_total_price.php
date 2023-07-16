<?php
require 'include/config.php';
error_reporting(E_ALL ^ E_DEPRECATED);
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

// Select database
$db_selected = mysql_select_db('bite', $link);
if (!$db_selected) {
    die ('Can\'t select database : ' . mysql_error());
}


// Perform a query to retrieve the sum of bids from the bidders table
$query = "SELECT SUM(bid) AS total_price FROM bidders";
$result = mysql_query($query);

if ($result) {
  // Fetch the total price from the query result
  $row = mysql_fetch_assoc($result);
  $totalPrice = $row['total_price'];

  // Send the total price as the response
  echo $totalPrice;
} else {
  // Handle query error
  echo "Error occurred while retrieving total price.";
}

?>
