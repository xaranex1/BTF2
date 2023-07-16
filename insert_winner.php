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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the parameters from the request
    $item_id = $_POST['item_id'];
        
    $query = "SELECT name, SUM(bid) AS total_bid FROM bidders GROUP BY name ORDER BY total_bid DESC LIMIT 1";
    $result = mysql_query($query);
    $winner = mysql_fetch_assoc($result);
    $winner_name = $winner['name'];

        // Get the player ID from the user table based on the name from the bidders table
        $query = "SELECT user.id FROM user JOIN bidders ON user.name = bidders.name WHERE bidders.name = '$winner_name'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        $user_id = $row['id'];

        // Insert the winner into the user_item table
        $query = "INSERT INTO user_item (item_id, user_id, stat, vol) VALUES ('$item_id', '$user_id', '0', '1')";
        $result = mysql_query($query);

        $response = array('status' => 'success', 'message' => 'Winner inserted successfully');
        echo json_encode($response);
    } else {
        // It's not the current player's turn to win
        $response = array('status' => 'error', 'message' => 'Not your turn to win');
        echo json_encode($response);
    }

// Close the database connection
mysql_close($link);
?>
