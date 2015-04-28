<!DOCTYPE html>
<html>
<head>
<title> Class View </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
</head>
<?php
$init = 0;
if ($init){
include_once("rss.php");
}

include_once("connection.php");

// query offerings
$result = $db_stickers->query("SELECT * FROM offerings");
$classesresult = array();
while ($data_result = $result->fetch_assoc()) {
	array_push($classesresult, $data_result);
}

//query stickers
$facget = $db_attendance->query("SELECT * FROM facilitators ORDER BY facilitatorname ASC");

$facilitators = array();
	while ($fac_row = $facget->fetch_row()) {
		array_push ($facilitators, $fac_row[0]);
	}
	
?>
<!-- render table -->
<h2> Offerings </h2>
<table>
<tr>
<th> Class Name</th>
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
<td> <?php echo $class['facilitatorid']; ?> </td>
<td> <?php 
if($class['block']==0){
	echo "Non-Block";
} else {
	echo "Block";
}

?> </td>
<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
<td> <?php echo $class['blackstickers']; ?> </td>
<td> <?php echo $class['greystickers']; ?> </td>
<td> <?php echo $class['whitestickers']; ?> </td>
</tr>
<?php
}
?> </html>