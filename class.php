<!DOCTYPE html>
<html>
<?php // init
session_start();

include_once("connection.php");

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
<h2><?php echo $classresult[0]['classname']; ?></h2>
<p>
<?php echo $classresult[0]['description']; ?>

</p>
</div>

</body>
</html>