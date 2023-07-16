<?php
include 'include/config.php';
error_reporting(E_ALL ^ E_DEPRECATED);
$id = $_SESSION['id'];
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


// Handle drinking beer and increasing thirst
if (isset($_POST['drink_beer'])) {
    $beerLimit = 10; // Set the limit of beers per day
    $maxThirst = 100; // Set the maximum thirst value

    if ($thirst === $maxThirst) {
        // Return an error message
        $response = array('error' => "Your thirst is already at the maximum level. You can't drink more beer.", 'thirst' => $thirst);
        echo json_encode($response);
        exit();
    }

    if ($beerCount < $beerLimit) {
        // Calculate the remaining thirst increase needed
        $remainingIncrease = min($maxThirst - $thirst, 10);

        // Increase thirst by the remaining increase
        $newThirst = $thirst + $remainingIncrease;
        // Update the thirst value in the database
        mysqli_query($link, "UPDATE user SET thirst = $newThirst WHERE id = $id");

        // Increase the beer count
        $newBeerCount = $beerCount + 1;
        // Update the beer count value in the database
        mysqli_query($link, "UPDATE user SET beer_count = $newBeerCount WHERE id = $id");

        $response = ['thirst' => $newThirst];
        echo json_encode($response);
        exit();
    } else {
        // Prepare the response with the beer count message
        $response = array(
            'thirst' => $thirst,
            'beer_count_message' => "Nemůžeš již vypít další pivo. Počkej do 60 minut."
        );
        echo json_encode($response);
        exit();
    }
}

// Handle resetting the beer count
if (isset($_POST['reset_beer_count'])) {
    $currentTime = time();
    $lastUpdatedTime = strtotime($lastUpdated);
    $timeDiff = $currentTime - $lastUpdatedTime;
    $timeDiffMinutes = round($timeDiff / 60); // Calculate the time difference in minutes

    if ($timeDiffMinutes >= 60) {
        // Reset the beer count to zero in the "user" table
        mysqli_query($link, "UPDATE user SET beer_count = 0 WHERE id = $id");

        // Prepare the success response
        $response = array('status' => 'success');
    } else {
        // Prepare the error response
        $response = array('status' => 'error', 'message' => 'You can reset the beer count only after 60 minutes.');
    }

    // Return the response as JSON
    echo json_encode($response);
    exit();
}

?>

