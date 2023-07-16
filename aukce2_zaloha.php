<?php
include 'include/config.php';
include 'include/tpl/top.php';

// Generate random ID
$random_id = rand(1, 100);
$pole = user_information($_SESSION['id']);
$name = $pole['name'];

// Get item with random ID
$result = db_query("SELECT id FROM item WHERE id = $random_id");
$item = mysql_fetch_assoc($result);
$item_id = $item['id'];
?>

<style>
#countdown {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 48px;
}
#total-price {
  font-size: 24px;
}
</style>

<center>
  <img src="img/item/<?php echo $item_id; ?>.jpg">

  <p id="countdown">10</p>
  <p id="total-price">Celková cena: </p>
  <p id="bids"> </p>
</center>

<script>
let countdown = 10;
let lastBidderShown = false; // Track if last bidder is already shown

let timer = setInterval(() => {
  document.getElementById('countdown').innerHTML = countdown;
  countdown--;

  if (countdown < 0) {
    clearInterval(timer);
    setTimeout(() => {
      // Wait for 5 seconds before displaying the winner
      let xhr = new XMLHttpRequest();
      xhr.open('GET', 'get_winner.php');
      xhr.onload = () => {
        if (xhr.status === 200) {
          let winner = xhr.responseText;
          document.getElementById('bids').innerHTML += " " + winner;

          // Insert winner into user_item table
          let insertWinner = new XMLHttpRequest();
          insertWinner.open('POST', 'insert_winner.php');
          insertWinner.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          insertWinner.send('item_id=<?php echo $item_id; ?>&user_id=<?php echo $_SESSION['id']; ?>&winner=' + winner);

          // Wait for another 5 seconds before reloading the page
          setTimeout(() => {
            // Send AJAX request to delete all records from the "bidders" table
            let deleteRecords = new XMLHttpRequest();
            deleteRecords.open('POST', 'reload_page.php');
            deleteRecords.send();

            location.reload();
          }, 5000);
        }
      };
      xhr.send();
    }, 1000);
  }
}, 1000);

function updateBidders() {
  let getBidders = new XMLHttpRequest();
  getBidders.open('GET', 'get_latest_bidder.php');
  getBidders.onload = () => {
    if (getBidders.status === 200) {
      let bidders = getBidders.responseText;
      document.getElementById('bids').innerHTML = bidders;
      
      // Calculate and display the total price
      let bids = bidders;
      let totalPrice = 0;
      for (let i = 0; i < bids.length; i++) {
        totalPrice += parseInt(bids.innerText);
      }
      document.getElementById('total-price').innerText = 'Celková cena itemu: ' + totalPrice;
    }
  };
  getBidders.send();
}

// Call updateBidders every second
setInterval(updateBidders, 1000);
</script>

<center>
<button id="bid">Přihodit (5)</button>
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
    if (xhr.status === 200) {
      // Get bidder name from PHP
      let name = '<?php echo htmlspecialchars($name); ?>';

      // Call updateBidders to display all bidders
      updateBidders();
      
      // Reset lastBidderShown flag for the next tick
      lastBidderShown = false;
    }
  };
});
</script>
