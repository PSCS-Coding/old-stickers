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
	//echo $sub["classname"];
	//table
	echo "<table name='" . $sub["classid"] . "'>
			<caption>" . $sub["classname"] . "</caption>
			<colgroup>
				<col class='blackstickers'>
				<col class='greystickers'>
				<col class='whitestickers'>
			</colgroup>
			<tr>
				<th class='black'>Black</th>
				<th>Grey</th>
				<th>White</th>
			</tr>
			<tr>
				<td class='black'>Hello</td><td>world</td><td>!!!</td> 
			</tr>
		  </table>";
}
?>
<style>
table, th, td {
    border: 1px solid black;
}
.blackstickers {
	background-color:black;
}
.greystickers {
	background-color:#A5A5A5;
}
.whitestickers {
	background-color:white;
}
.black {
	color:white;
}
</style>