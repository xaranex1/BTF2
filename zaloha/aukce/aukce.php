<?php
require 'include/config.php';
require 'include/tpl/top.php';



$pole = user_information( $_SESSION['id'] );
$name = $pole['name'];
var_dump($name);
// Connect to database and get random item I
$random = rand(1, 245);
$result = db_query("SELECT id FROM item WHERE id = $random"); 
$item = mysql_fetch_assoc($result);
$itemID = $item['id'];


echo "<center>";
// Display item image and start countdown 
echo "<img src='img/item/$itemID.jpg'>";
echo "<center><p id='countdown'>10</p></center>";
echo "<button id='bidButton'>Přihodit (5)</button>"; 
echo "<p>";
echo "<div id='bidders'></div>";
echo "</center>";
?>

<script>
let itemID = <?php echo $itemID; ?>;  
// Start countdown 
let countdown = 10;
let timer = setInterval(() => {
  document.getElementById('countdown').innerHTML = countdown;
  countdown--;
  if (countdown < 0) {
    clearInterval(timer);
    location.reload();  // Refresh page after countdown
  }
}, 1000);


document.getElementById('bidButton').addEventListener('click', () => {
  let bid = 5;  // Hardcoded bid amount of $5
  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'bid.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('&bid=' + bid + '&itemID=' + itemID);
  xhr.onload = () => {
    if (xhr.status === 200) {  // Update bidders div with response
      document.getElementById('bidders').innerHTML = xhr.responseText;
    }
  }
});  
</script>

<style>
#countdown {
  text-align: center;
}
</style>

