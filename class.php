<?php	
session_start(); 
?>
<!DOCTYPE html>
<html>
<?php // init

include_once("connection.php");
include_once("stickerfunctions.php");
include_once("function.php");

if(!empty($_GET['classid'])){
	$_SESSION['classid'] = $_GET['classid']; 
	
} elseif(!empty($_SESSION['classid'])){
	
} else {
	echo "A class has not been chosen";
}
$classid = $_SESSION['classid'];

include_once("connection.php");

$classquery = $db_stickers->query("SELECT * FROM offerings WHERE classid=$classid");
$classresult = array();
while ($data_result = $classquery->fetch_assoc()) {
	array_push($classresult, $data_result);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
<title><?php echo $classresult[0]['classname']; ?></title>
</head>
<body>

<div class="classdata">
<a class="back" href="index.php">Back</a>
<h3><?php echo $classresult[0]['classname'] . ", taught by " . $classresult[0]['facilitator']; ?></h3>
<p>


<?php echo $classresult[0]['description'];
if (preg_match('/<p/',$classresult[0]["image"])){
} else {
	?><img src='<?php echo $classresult[0]["image"]; ?>'>
<?php	
}
?>
</p>
<?php 
//render students that have stickered this class
$blackstickers = getstudents($classid,"blackstickers");
$greystickers = getstudents($classid,"greystickers");
$whitestickers = getstudents($classid,"whitestickers");

$blackstickers = explode(",", $blackstickers[0]);
$greystickers = explode(",", $greystickers[0]);
$whitestickers = explode(",", $whitestickers[0]);

foreach($blackstickers as $sticker){
	echo "<div class = " . "blacksticker" . ">" . idToName($sticker) . "</div>";
}

foreach($greystickers as $sticker){
	echo "<div class = " . "greysticker" . ">" . idToName($sticker) . "</div>";
}

foreach($whitestickers as $sticker){
	echo "<div class = " . "whitesticker" . ">" . idToName($sticker) . "</div>";
}
?>
</div>

</body>
</html>