<DOCTYPE HTML>
<html>
<?php
require_once("connection.php");
?>
<head>
	<title>All Classes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="stickers.css">  
</head>
<?php
$classesQuery = $db_stickers->query("SELECT * FROM offerings");
$classesResult = array();
while($class = $classesQuery->fetch_assoc()) {
	array_push($classesResult, $class);
}
?>
<!-- Enclosing Classes Table -->
<?php
foreach($classesResult as $sub) {
	//echo $sub["classname"];
	//table
	?>	<table name= <?php echo $sub["classid"] ?> >
			<caption> <?php echo $sub["classname"] ?> </caption>
			<colgroup>
				<col class='blackstickers'>
				<col class='greystickers'>
				<col class='whitestickers'>
			</colgroup>
			<tr>
				<th class='black'>Black</th>
				<th class='grey'>Grey</th>
				<th class='white'>White</th>
			</tr>
			<tr>
				<td class='black'>Hello</td><td>world</td><td>!!!</td> 
			</tr>
		 </table>
	<?php
}
?>
<style>
table, th, td, caption {
    border: 1px solid black;
}
table {
	float:left;
	margin:1%;
	width:10%;
}
caption {
	opacity: 0.5;
    overflow-y: scroll;
    background-color: white;
    width: 100%;
    height: 2%;
	padding-top:1%;
	padding-bottom:2%;
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