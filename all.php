<DOCTYPE HTML>
<html>
<?php
require_once("connection.php");
?>
<head>
	<title>All Classes</title>
</head>
<?php
$classesQuery = $db_stickers->query("SELECT * FROM offerings");
$classesResult = array();
while($class = $classesQuery->fetch_assoc()) {
	array_push($classesResult, $class);
}
foreach($classesResult as $sub) {
	echo $sub["classname"] . "<br />";
	//table
}
?>