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




// Generate a random item ID from 1 to 254
$random_id = rand(1, 254);

// Retrieve item information based on the random ID
$result = mysql_query("SELECT id FROM item WHERE id = $random_id");
$item = mysql_fetch_assoc($result);
$item_id = $item['id'];

// Prepare the response as JSON
$response = array(
    'item_id' => $item_id
);

// Set the content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);



?>
