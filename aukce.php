<?php
require 'include/config.php';
require 'include/tpl/top.php';

// Generate random ID 
$random_id = rand(1, 100); 
$pole = user_information( $_SESSION['id'] );
$name = $pole['name'];

// Get item with random ID
$result = db_query("SELECT id FROM item WHERE id = $random_id");
$item = mysql_fetch_assoc($result);
$item_id = $item['id'];

// Display item image
echo "<img src='img/item/$item_id.jpg'>";  

// Start 10 second countdown
echo "<p id='countdown'>10</p>";  
?>

<script>
let countdown = 10;
let timer = setInterval(() => {
  document.getElementById('countdown').innerHTML = countdown;
  countdown--;
  if (countdown < 0) {
    clearInterval(timer);
    // Get next item after countdown ends
    $result = db_query("SELECT id FROM items WHERE id = $random_id");
    $item = mysql_fetch_assoc($result);
    $item_id = $item['id'];  
    echo "<center><img src='img/item/$item_id.jpg'></center>";

  }
}, 1000);
</script>
<center>
<button id="bid">Bid $5</button>
<div id="bids"></div>  
</center>

<script>
let bid = 5;
document.getElementById('bid').addEventListener('click', () => {
  document.getElementById('bid').disabled = true;
  
  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'insert_bid.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('item_id=<?php echo $item_id; ?>&bid=' + bid);
  
  xhr.onload = () => {
    document.getElementById('bid').disabled = false;
    if (xhr.status == 200) {  
      // Get bidder name from PHP
      let name = '<?php echo $name; ?>'; 
      
      // Display bid and name
      document.getElementById('bids').innerHTML += bid + ' - ' + name + '<br>'; 
    } 
  }
});  
</script>
