<?php

require 'include/config.php';
require 'include/tpl/top.php';

function showBidders() {
    
    // Get all bidders from bidders table
    $result = db_query('SELECT * FROM bidders');
    
    // Loop through and display each bidder
    while ($bidder = mysql_fetch_assoc($result)) {
      echo "<tr>  
             <td>{$bidder['name']}</td>
             <td>${$bidder['bid']}</td>
           </tr>";
    }
  }


  // bid.php - Handle incoming bid requests

$pole = user_information( $_SESSION['id'] );
$name = $pole['name']; 
$bid = $_POST['bid'];  
$itemID = $_POST['itemID'];

// Insert new bidder into bidders table
$sql = "INSERT INTO bidders (name, bid, item_id) 
        VALUES ('$name', $bid, $itemID)";
db_query($sql);

// Display updated bidders table
showBidders(); 


  


?>