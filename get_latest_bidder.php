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

// Retrieve the latest bidder from the "bidders" table
$result = mysql_query("SELECT name FROM bidders ORDER BY id DESC LIMIT 1");
$latestBidder = mysql_fetch_assoc($result);

if ($latestBidder) {
  $bidderName = $latestBidder['name'];
  echo $bidderName;
} else {
  echo "Žádný přihazujicí...";
}
?>
