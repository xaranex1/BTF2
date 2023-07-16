<?php
include 'include/config.php';

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

// Select database
$db_selected = mysql_select_db('bite', $link);
if (!$db_selected) {
    die ('Can\'t select database: ' . mysql_error());
}

// Get POST data  
$user_id = $_POST['user_id'];
var_dump($user_id);

// Fetch user name from the user table
$sql = "SELECT name FROM user WHERE id = $user_id";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$name = $row['name'];

if (isset($_POST['item_id']) && isset($_POST['bid'])) {
  // This is a bid request
  $item_id = $_POST['item_id'];  
  $bid = $_POST['bid'];

  // Insert bid into bidders table
  $sql = "INSERT INTO bidders (item_id, name, bid) VALUES ($item_id, '$name', $bid)";
  if (mysql_query($sql)) {
    $response = array('status' => 'success', 'message' => 'Bid placed successfully');
    echo json_encode($response);
  } else {
    $response = array('status' => 'error', 'message' => 'Failed to place bid: ' . mysql_error());
    echo json_encode($response);
  }
}
?>
