<?php
include 'include/config.php';

$currentPlayerId = $_SESSION['id'];

// Get the next player ID
$sql = "SELECT MIN(id) AS next_player_id FROM user WHERE id > $currentPlayerId";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$nextPlayerId = $row['next_player_id'];

// If there is no next player, select the minimum player ID
if (!$nextPlayerId) {
  $sql = "SELECT MIN(id) AS next_player_id FROM user";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  $nextPlayerId = $row['next_player_id'];
}

echo $nextPlayerId;
?>
