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
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
<title>Class Info For:<?php echo $classid; ?></title>
</head>
<body>

<div class="classdata">
<a href="index.php">Back</a>
</div>


<?php







?>
</body>
</html>