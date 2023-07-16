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

// Fetch the winner from the bidders table based on the number of bids
$query = "SELECT name, SUM(bid) AS total_bid FROM bidders ORDER BY total_bid DESC LIMIT 1";
$result = mysql_query($query);
$winner = mysql_fetch_assoc($result);
$winner_name = $winner['name'];

// Display the winner's name prominently
echo "<p>";
echo '<h2>Vítězem je: ' . htmlspecialchars($winner_name) . '</h2>';
echo "</p>";


?>
