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

// Add necessary authentication, authorization, and validation here

// Delete all entries from the bidders table
// Check if session item_id is set
unset($_SESSION['item_id']);
unset($_SESSION['start_time']);
  unset($_SESSION['item_id']);
  unset($_SESSION['item_name']);
  unset($_SESSION['item_pow']);
  unset($_SESSION['item_def']);
  unset($_SESSION['item_agi']);
  unset($_SESSION['item_stam']);


if (!isset($_SESSION['item_id'])) {
    // Delete all entries from the bidders table
    mysql_query("DELETE FROM bidders");
  }


// Return a response indicating success
http_response_code(200);

// Close the database connection
mysql_close($link);
?>
