<?php	
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
<title> Class View </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script>
	$(function() {
		$('.sticker').draggable();
	});
</script>

	
</head>

<body>
<header>
<h2> PSCS Class Offerings </h2>
<a class='start' href='student.php'>change user / login</a>

<?php
	include_once("connection.php");
	include_once("function.php");
	
	if(!empty($_SESSION['id'])){
		echo "<a class='name'>" . idToName($_SESSION['id']) . "</a>";
	?></header><div class='stickerlist'>
	<?php
	$studentid = $_SESSION['id'];
	$querystickers = $db_stickers->query("SELECT * FROM usedstickers WHERE studentid=$studentid");
	$usedstickers = array();
	while ($data_result = $querystickers->fetch_assoc()) {
		array_push($usedstickers, $data_result);
	}
	
	for($i = $usedstickers[0]['blackstickers']; $i>0; $i--){
		echo "<div class='sticker black'>blacksticker</div>";
	}
	
	for($i = $usedstickers[0]['greystickers']; $i>0; $i--){
		echo "<div class='sticker grey'>greysticker</div>";
	}
	
	for($i = $usedstickers[0]['whitestickers']; $i>0; $i--){
		echo "<div class='sticker white'>whitesticker</div>";
	}
	?>
	<div> <?php
	} else {
		echo "<a class='name'>Please Sign In</a>";
	}
	?>
<?php
if(!empty($_GET['reset'])){
	if($_GET['reset']==1){
		$init = 1;
	} else {
		$init = 0;
	}
} else {
	$init = 0;
}

if ($init){
include_once("reset.php");
}

// query offerings
$result = $db_stickers->query("SELECT * FROM offerings");
$classesresult = array();
while ($data_result = $result->fetch_assoc()) {
	array_push($classesresult, $data_result);
}

if(count($classesresult)==0){
	echo "<p style='text-align:center;'> Sorry, Class offerings could not be retrieved at this time </p>";
} else {

//query stickers
$facget = $db_attendance->query("SELECT facilitatorname, facilitatorid FROM facilitators ORDER BY facilitatorname ASC");

$facilitators = array();
	while ($fac_row = $facget->fetch_row()) {
		array_push ($facilitators, $fac_row[0]);
	}
	
?>
<!-- render table -->
<table>
<tr>
<th> Title</th>
<th> Facilitator </th>
<th> Block </th>
<th class="stickerheader"> Black stickers </th>
<th class="stickerheader"> Grey stickers </th>
<th class="stickerheader"> White stickers </th>
</tr>
<?php
foreach($classesresult as $class){
?> <tr>
<td> 
<a href="class.php?classid=<?php echo $class['classid'];?>" > <?php echo $class['classname']; ?> </a> </td>
<td> <?php echo $class['facilitator']; ?> </td>
<td> 

<?php 
if($class['block']==0){
	echo "Non-Block";
} else {
	echo "Block";
}

?> 

</td>
<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
<td class="sticker-container" style="background-color:#5F5959;"> <?php echo $class['blackstickers']; ?> </td>
<td class="sticker-container" style="background-color:#A69E9E;"> <?php echo $class['greystickers']; ?> </td>
<td class="sticker-container" style="background-color:#FFFFFF;"> <?php echo $class['whitestickers']; ?> </td>
</tr>
<?php
}
}
?>
</body>
</html>