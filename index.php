<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
$init = 0;
if ($init){
include_once("rss.php");
}

include_once("connection.php");

$result = $db_stickers->query("SELECT * FROM classes");
$classesresult = array();
while ($data_result = $result->fetch_assoc()) {
	array_push($classesresult, $data_result);
}
	
?>
<table>
<tr>
<th> class </th>
<th> facilitator </th>
<th> block </th>
<th> black stickers </th>
<th> grey stickers </th>
<th> white stickers </th>
</tr>
<?php
foreach($classesresult as $class){
?> <tr>
<td> <?php echo $class['classname']; ?> </td>
<td> <?php echo $class['facilitatorid']; ?> </td>
<td> <?php echo $class['block']; ?> </td>
<td> <?php echo $class['blackstickers']; ?> </td>
<td> <?php echo $class['greystickers']; ?> </td>
<td> <?php echo $class['whitestickers']; ?> </td>
</tr>
<?php
}
?> </html>