<?php
include 'include/config.php';
include 'include/tpl/top.php';

// Check if a new item is needed or an existing one is in auction
if (!isset($_SESSION['item_id'])) {
  // Generate random ID
  $random_id = rand(1, 100);

  // Get item with random ID
  $result = mysql_query("SELECT id, item, pow, def, agi, stam FROM item WHERE id = $random_id");
  $item = mysql_fetch_assoc($result);
  $item_id = $item['id'];
  $item_pow = $item['pow'];
  $item_def = $item['def'];
  $item_agi = $item['agi'];
  $item_stam = $item['stam'];
  $item_name = $item['item'];

  // Store item in session
  $_SESSION['item_id'] = $item_id;
  $_SESSION['item_name'] = $item_name;
  $_SESSION['item_pow'] = $item_pow;
  $_SESSION['item_def'] = $item_def;
  $_SESSION['item_agi'] = $item_agi;
  $_SESSION['item_stam'] = $item_stam;
} else {
  // Retrieve item details from session
  $item_id = $_SESSION['item_id'];
  $item_name = $_SESSION['item_name'];
  $item_pow = $_SESSION['item_pow'];
  $item_def = $_SESSION['item_def'];
  $item_agi = $_SESSION['item_agi'];
  $item_stam = $_SESSION['item_stam'];
}

// Check if the auction start time is stored in the session
if (!isset($_SESSION['start_time'])) {
  $_SESSION['start_time'] = time(); // Store the current time as the start time
}

// Calculate the elapsed time in seconds since the start of the auction
$elapsedTime = time() - $_SESSION['start_time'];

$pole = user_information($_SESSION['id']);
$name = $pole['name'];
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
#active-users {
  font-size: 18px;
  margin-bottom: 10px;
}
</style>

<center>
  <h2 style="color: black;"><?php echo $item_name; ?></h2>
  <div style="display: flex; align-items: center;">
    <div>
      <img src="img/item/<?php echo $item_id; ?>.jpg">
    </div>
    <div style="margin-left: 20px;">
      <table>
        <tr>
          <th>Vlastnost</th>
          <th>Hodnota</th>
        </tr>
        <tr>
          <td>Power</td>
          <td><?php echo $item_pow; ?></td>
        </tr>
        <tr>
          <td>Defense</td>
          <td><?php echo $item_def; ?></td>
        </tr>
        <tr>
          <td>Agility</td>
          <td><?php echo $item_agi; ?></td>
        </tr>
        <tr>
          <td>Stamina</td>
          <td><?php echo $item_stam; ?></td>
        </tr>
      </table>
    </div>
  </div>

  <p id="countdown"></p>
  <p id="bids"> </p>
  <p id="total-price">Celková cena: </p>
  <p id="active-users">Aktivní uživatelé na aukci: </p>
</center>


<script>
window.onload = function() {
  let countdown = Math.max(50 - <?php echo $elapsedTime; ?>, 0); // Use Math.max to ensure the countdown is not negative
  let lastBidderShown = false; // Track if the last bidder is already shown
  let bid = 5;
  let isButtonLocked = false;
  let currentPlayerId = <?php echo $_SESSION['id']; ?>;
  let hasPlayerBid = false;

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
            insertWinner.send('item_id=<?php echo $item_id; ?>&user_id=' + currentPlayerId + '&winner=' + winner);

            // Wait for another 5 seconds before deleting records
            setTimeout(() => {
              // Send AJAX request to delete all records from the "bidders" table
              let deleteRecords = new XMLHttpRequest();
              deleteRecords.open('POST', 'reload_page.php');
              deleteRecords.send();

              // Reload the page after deleting records
              deleteRecords.onload = () => {
                if (deleteRecords.status === 200) {
                  location.reload();
                }
              };
            }, 2000);
          }
        };
        xhr.send();
      }, 2000);
    }
  }, 1000);

  function updateBidders() {
    let getBidders = new XMLHttpRequest();
    getBidders.open('GET', 'get_latest_bidder.php');
    getBidders.onload = () => {
      if (getBidders.status === 200) {
        let bidders = getBidders.responseText;
        document.getElementById('bids').innerHTML = bidders;

        // Update total price by fetching the sum of bids from the server
        let getTotalPrice = new XMLHttpRequest();
        getTotalPrice.open('GET', 'get_total_price.php');
        getTotalPrice.onload = () => {
          if (getTotalPrice.status === 200) {
            let totalPrice = getTotalPrice.responseText;
            document.getElementById('total-price').innerHTML = 'Celková cena: ' + totalPrice;
          }
        };
        getTotalPrice.send();
      }
    };
    getBidders.send();
  }

  function switchTurns() {
    // Disable the bid button for the current player
    document.getElementById('bid').disabled = true;

    // Reset the hasPlayerBid flag for the next turn
    hasPlayerBid = false;

    // Get the next player ID from the server
    let getNextPlayerId = new XMLHttpRequest();
    getNextPlayerId.open('GET', 'get_next_player.php');
    getNextPlayerId.onload = () => {
      if (getNextPlayerId.status === 200) {
        currentPlayerId = parseInt(getNextPlayerId.responseText);

        // Enable the bid button for the next player
        document.getElementById('bid').disabled = false;
        document.getElementById('bid').innerText = 'Přihodit (' + bid + ')';

        // Update the player name in the bidding message
        let playerName = '<?php echo htmlspecialchars($name); ?>';
        document.getElementById('current-player').innerText = playerName;
      }
    };
    getNextPlayerId.send();
  }

  function checkActiveSessions() {
    let getActiveSessions = new XMLHttpRequest();
    getActiveSessions.open('GET', 'get_active_sessions.php');
    getActiveSessions.onload = () => {
      if (getActiveSessions.status === 200) {
        let activeSessions = parseInt(getActiveSessions.responseText);
        document.getElementById('active-users').innerHTML = 'Aktivní uživatelé na aukci: ' + activeSessions;
        if (activeSessions < 2) {
          clearInterval(timer); // Stop the countdown timer
          // Add your code to close the auction or take appropriate action
          alert('Auction closed due to insufficient active sessions.');
        }
      }
    };
    getActiveSessions.send();
  }

  // Call updateBidders, checkActiveSessions, and switchTurns every second
  setInterval(updateBidders, 1000);
  setInterval(checkActiveSessions, 1000);

  document.getElementById('bid').addEventListener('click', () => {
    if (isButtonLocked || hasPlayerBid) {
      return; // Exit if the button is locked or the player has already bid
    }

    isButtonLocked = true; // Lock the button

    // Get the bid amount entered by the user
    let userBid = parseInt(document.getElementById('user-bid').value);

    if (!isNaN(userBid) && userBid >= 0) {
      bid = userBid; // Update the bid variable with the user's bid
    }

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'insert_bid.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('item_id=<?php echo $item_id; ?>&user_id=' + <?php echo $_SESSION['id'];?> + '&bid=' + bid);

    xhr.onload = () => {
      if (xhr.status === 200) {
        // Call updateBidders to display all bidders
        updateBidders();

        // Reset lastBidderShown flag for the next tick
        lastBidderShown = false;

        // Mark that the player has bid
        hasPlayerBid = true;

        // Switch turns
        switchTurns();
      }

      // Unlock the button when another player bids
      isButtonLocked = false;
    };
  });

  // Set the initial turn to the current player
  switchTurns();
};
</script>

<center>
  <input type="number" id="user-bid" placeholder="Zadej množství příhozu">
  <button id="bid">Přihodit (<?php echo $bid; ?>)</button>
</center>
