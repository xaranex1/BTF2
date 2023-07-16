<?php

include 'include/config.php';
include 'include/tpl/top.php';

$id = $_SESSION['id'];
error_reporting(E_ALL ^ E_DEPRECATED);
$link = mysqli_connect('localhost', 'root', '', 'bite');
if (!$link) {
    die('Could not connect: ' . mysqli_error($link));
}

// Fetch the "thirst" value from the "user" table
$result = mysqli_query($link, "SELECT thirst FROM user WHERE id = $id");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $thirst = $row['thirst'];
} else {
    $thirst = 0; // Default value if the query fails or no rows are found
}

// Handle accepting the quest and deducting thirst
if (isset($_POST['accept_quest'])) {
    // Deduct 10 from the thirst value
    $newThirst = $thirst - 10;

    // Update the thirst value in the database
    mysqli_query($link, "UPDATE user SET thirst = $newThirst WHERE id = $id");

    echo $newThirst;
    exit();
}

function getRandomQuest($questsFilePath) {
    $quests = file_get_contents($questsFilePath);
    if ($quests === false || empty($quests)) {
        return array("No quests available.", 0, 0);
    }

    $questList = explode(',', $quests);
    $randomIndex = array_rand($questList);
    $randomQuest = trim($questList[$randomIndex]);
    $gold = rand(100, 1000);
    $experience = rand(1000, 5000);

    return array($randomQuest, $gold, $experience);
}

$currentQuestIndex = 0;
$questsFilePath = "quests.txt";
$randomQuest = getRandomQuest($questsFilePath);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hospoda</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .image {
            position: relative;
        }

        .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background-color: #555;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #4d0000;
            transition: width 0.3s;
        }

        #image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 200px;
            margin-bottom: 10px;
        }

        #image img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 5px;
        }

        .button-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .button {
            margin: 5px;
            padding: 10px;
            background: linear-gradient(to bottom, #4a4a4a, #800000);
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 250px;
            color: #fff;
            font-weight: bold;
            text-align: center;
            background-image: url('img/svetlybutton.png');
            background-size: cover;
            border: 2px solid #000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            font-family: 'Arial', sans-serif;
            position: relative;
        }

        .button:hover {
            background-image: url('img/tmavybutton.png');
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }

        .button img {
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 5px;
        }

        .tooltip {
            position: fixed;
            top: 0;
            left: 0;
            display: none;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            pointer-events: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #000;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            text-align: left;
            border-radius: 5px;
            color: #fff;
            font-family: 'Arial', sans-serif;
            position: relative;
            display: flex;
            align-items: center;
        }

        .modal-content .modal-image {
            width: 40%;
            max-height: 100%;
            overflow: hidden;
        }

        .modal-content .modal-image img {
            width: 100%;
            height: 100%;
        }

        .modal-content .modal-text {
            width: 60%;
            padding-left: 20px;
        }

        .modal-content .modal-text p {
            margin: 0;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #fff;
        }

        .modal-button {
            text-align: center;
            margin-top: 100px;
        }

        .mmorpg-button {
            margin-top: 250px;
            padding: 0px 0px;
            background: linear-gradient(to bottom, #4a4a4a, #4d0000);
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            color: #fff;
            font-weight: bold;
            border: 2px solid #000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            font-family: 'Arial', sans-serif;
            position: relative;
        }

        .mmorpg-button:hover {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }

        .progress-bar-caption {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            text-align: center;
            color: #fff;
            font-size: 12px;
        }

        .modal-arrow-left {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 60px;
            cursor: pointer;
            color: #fff;
        }

        .modal-arrow-right {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 60px;
            cursor: pointer;
            color: #fff;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
    <div class="image">
        <img src="/img/tavern2.jpg" alt="Small Image">
        <div class="progress-bar">
            <div class="progress-bar-fill"></div>
        </div>
        <div class="progress-bar-caption"></div>
    </div>

    <div class="button-row">
        <div class="button" onclick="openBeerModal()" onmouseover="showTooltip(event, 'Doplní energii pro další dobrodružství!')" onmouseout="hideTooltip()">
            <img src="/img/beer.png" alt="Button 1 Image">
            <span>Dát si pivo</span>
        </div>
        <div class="button" onclick="openModal()" onmouseover="showTooltip(event, 'Získej nové dovednosti a odměny s plněním úkolů.')" onmouseout="hideTooltip()">
            <img src="img/quest.png" alt="Button 2 Image">
            <span>Quest</span>
        </div>
        <div class="button" onmouseover="showTooltip(event, 'Otvírejte magic box a získávejte zajímavé itemy každý den!')" onmouseout="hideTooltip()">
            <img src="img/magicbox.png" alt="Button 3 Image">
            <span>Magic box</span>
        </div>
    </div>

    <div class="button-row">
        <div class="button" onmouseover="showTooltip(event, 'Tooltip 4')" onmouseout="hideTooltip()">
            <img src="path/to/button4-image.jpg" alt="Button 4 Image">
            <span>Button 4</span>
        </div>
        <div class="button" onmouseover="showTooltip(event, 'Tooltip 5')" onmouseout="hideTooltip()">
            <img src="path/to/button5-image.jpg" alt="Button 5 Image">
            <span>Button 5</span>
        </div>
        <div class="button" onmouseover="showTooltip(event, 'Tooltip 6')" onmouseout="hideTooltip()">
            <img src="path/to/button6-image.jpg" alt="Button 6 Image">
            <span>Button 6</span>
        </div>
    </div>

    <div class="tooltip" id="tooltip"></div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-arrow-left">&lt;</div>
            <div class="modal-image">
                <img src="img/quest1.jpg" alt="Modal Image">
            </div>
            <div class="modal-arrow-right">&gt;</div>
            <div class="modal-text">
                <h2>Questy</h2>
                <p><span id="randomQuest"><?php echo $randomQuest[0]; ?></span></p>
                <br></br>
                <h2>Zkušenosti:</h2>
                <p><img src="img/exp.png" width="45px" height="45px"><span id="experience"><?php echo $randomQuest[2]; ?></span> exp</p>
                <br></br>
                <h2>Goldy:</h2>
                <p><img src="img/coin.png" width="45px" height="45px"><span id="gold"><?php echo $randomQuest[1]; ?></span> goldu</p>
                <div id="questMessage" style="color: red; display: none;"></div>
            </div>

            <div class="modal-button">
                <form id="questForm" onsubmit="acceptQuest(); return false;">
                    <button class="mmorpg-button" name="accept_quest">Přijmout Quest</button>
                </form>
            </div>
        </div>
    </div>

    <div id="beerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-image">
                <img src="img/beer.png" alt="Modal Image">
            </div>
            <div class="modal-text">
                <p>Pivo resetuje dobrodružství a tak můžeš vesele dál pokračovat v plnění úkolů.</p>
            </div>
            <div class="modal-button">
                <form id="beerForm" onsubmit="drinkBeer(); return false;">
                    <button class="mmorpg-button" name="drink_beer">Vypít 1 pivo</button>
                </form>
            </div>
            <div id="beerMessage" style="color: red; display: none;"></div>
            <div class="progress-bar">
                <div class="countdown-bar-fill"></div>
            </div>
        </div>
    </div>

    <script>
        function showTooltip(event, tooltipText) {
            const tooltip = document.getElementById('tooltip');
            tooltip.innerHTML = tooltipText;
            tooltip.style.display = 'block';
            tooltip.style.top = event.clientY + 'px';
            tooltip.style.left = event.clientX + 'px';
        }

        function hideTooltip() {
            const tooltip = document.getElementById('tooltip');
            tooltip.style.display = 'none';
        }

        function openModal() {
            const modal = document.getElementById('myModal');
            modal.style.display = 'block';
        }

        function openBeerModal() {
            const beerModal = document.getElementById('beerModal');
            beerModal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('myModal');
            const beerModal = document.getElementById('beerModal');
            modal.style.display = 'none';
            beerModal.style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('myModal');
            const beerModal = document.getElementById('beerModal');
            if (event.target === modal) {
                closeModal();
            } else if (event.target === beerModal) {
                closeBeerModal();
            }
        });

        function acceptQuest() {
    // Handle accepting the quest and deducting thirst
    const questMessage = document.getElementById('questMessage');
    const progressBarFill = document.querySelector('.progress-bar-fill');
    const progressCaption = document.querySelector('.progress-bar-caption');
    const randomQuestElement = document.getElementById('randomQuest');
    const goldElement = document.getElementById('gold');
    const experienceElement = document.getElementById('experience');

    // Deduct 10 from the thirst value
    const newThirst = <?php echo $thirst; ?> - 10;

    if (newThirst < 0) {
        questMessage.innerHTML = "Nemůžeš pokračovat v dobrodružství, tvá žízeň klesla na nulu.";
        questMessage.style.display = 'block';
        return;
    }

    // Update the thirst value in the database
    $.ajax({
        url: 'quest.php',
        type: 'POST',
        dataType: 'json',
        data: { new_thirst: newThirst },
        success: function(response) {
            if (response.hasOwnProperty('thirst')) {
                progressBarFill.style.width = response.thirst + '%';
                progressCaption.textContent = 'Dobrodružství - ' + response.thirst + '%';
                progressCaption.style.display = 'block'; // Display the progress bar caption

                // Update the random quest, gold, and experience elements
                randomQuestElement.textContent = response.randomQuest;
                goldElement.textContent = response.gold;
                experienceElement.textContent = response.experience;
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}



        function drinkBeer() {
            // Handle drinking beer and resetting thirst
            const beerMessage = document.getElementById('beerMessage');
            const progressBarFill = document.querySelector('.progress-bar-fill');
            const progressCaption = document.querySelector('.progress-bar-caption');

            // Reset the thirst value to 100
            const newThirst = 100;

            // Update the thirst value in the database
            $.ajax({
                url: 'quest.php',
                type: 'POST',
                dataType: 'json',
                data: { new_thirst: newThirst },
                success: function(response) {
                    if (response.hasOwnProperty('thirst')) {
                        progressBarFill.style.width = response.thirst + '%';
                        progressCaption.textContent = 'Dobrodružství - ' + response.thirst + '%';

                        // Display beer count message
                        beerMessage.textContent = response.beer_count_message;
                        beerMessage.style.display = 'block';
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function resetBeerCount() {
            // Reset beer count to 0
            $.ajax({
                url: 'quest.php',
                type: 'POST',
                dataType: 'json',
                data: { reset_beer_count: 1 },
                success: function(response) {
                    // Optionally, you can add some logic here to perform additional actions or update the UI
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function startCountdown() {
            const beerCountdown = 30; // Duration of the countdown in seconds

            const countdownInterval = setInterval(function() {
                const countdownBarFill = document.querySelector('.countdown-bar-fill');
                const secondsLeft = parseInt(countdownBarFill.style.width, 10);

                if (secondsLeft <= 0) {
                    clearInterval(countdownInterval);
                    resetBeerCount();
                } else {
                    const newWidth = (secondsLeft - 1) * 100 / beerCountdown + '%';
                    countdownBarFill.style.width = newWidth;
                }
            }, 1000); // Update the countdown every second
        }

        // Call the startCountdown() function when the page loads
        $(document).ready(function() {
            startCountdown();
        });
    </script>
</body>

</html>
