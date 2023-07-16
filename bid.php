<?php

// bid.php
$conn = mysql_connect('localhost', 'root', '', 'bite');
$bid = $_POST['bid'];  
$itemID = $_POST['itemID'];
$sql = "INSERT INTO bidders (bid, item_id) 
        VALUES ($bid, $itemID)";
db_query($sql);
$result = db_query("SELECT bid FROM bidders WHERE item_id = $itemID 
                    ORDER BY bid DESC LIMIT 1");
$highestBid = mysql_fetch_assoc($result);
$highestAmount = $highestBid['bid'];
echo $highestAmount;

?>