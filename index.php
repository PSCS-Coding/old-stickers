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

$result = $db_stickers->query("SELECT * FROM offerings");
$classesresult = array();
while ($data_result = $result->fetch_assoc()) {
	array_push($classesresult, $data_result);
}
	
?>
<h2> Offerings </h2>
<table>
<tr>
<th> Class Name</th>
<th> Facilitator </th>
<th> Block </th>
<!-- <th> Description </th> -->
<th> Black stickers </th>
<th> Grey stickers </th>
<th> White stickers </th>
</tr>
<?php
foreach($classesresult as $class){
?> <tr>
<td> 
<a href="class.php?classid=<?php echo $class['classid'];?>" > <?php echo $class['classname']; ?> </a>
</td>
<td> <?php echo $class['facilitatorid']; ?> </td>
<td> <?php echo $class['block']; ?> </td>
<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
<td> <?php echo $class['blackstickers']; ?> </td>
<td> <?php echo $class['greystickers']; ?> </td>
<td> <?php echo $class['whitestickers']; ?> </td>
</tr>
<?php
}
?> </html>