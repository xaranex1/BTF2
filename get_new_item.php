<?

// get_new_item.php
$conn = mysql_connect('localhost', 'root', '', 'bite');
$random = rand(1, 245);
$result = db_query("SELECT id FROM item WHERE id = $random", $conn); 
$item = mysql_fetch_assoc($result);
$itemID = $item['id'];
echo $itemID;

?>