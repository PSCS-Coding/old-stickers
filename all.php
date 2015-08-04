<DOCTYPE HTML>
<html>
<?php
include_once("connection.php");
include_once("stickerfunctions.php");
include_once("function.php");
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
//get student stickers
foreach($classesResult as $sub) {
	$blackstickers = getstudents($sub["classid"],"blackstickers");
	$greystickers = getstudents($sub["classid"],"greystickers");
	$whitestickers = getstudents($sub["classid"],"whitestickers");

	$blackstickers = explode(",", $blackstickers[0]);
	$greystickers = explode(",", $greystickers[0]);
	$whitestickers = explode(",", $whitestickers[0]);

	$highestVal = max(count($blackstickers), count ($greystickers), count($whitestickers));
	
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
			<?php 
			for ($i = 0; $i < $highestVal; $i++) {
			?>
			<tr>
				<td> <?php if (!empty($blackstickers[$i])) echo idToName($blackstickers[$i]); ?> </td>
				<td> <?php if (!empty($greystickers[$i])) echo idToName($greystickers[$i]);   ?> </td>
				<td> <?php if (!empty($whitestickers[$i])) echo "<span class='whitestickers'>" . idToName($whitestickers[$i]) . "</span>"; ?> </td> 
			</tr>
			<?php
			}
			?>
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
	background-color:#272525;
	color:white;
}
.greystickers {
	background-color:#A5A5A5;
	color:black;
}
.whitestickers {
	background-color:white;
	color:black;
}
.black {
	color:white;
}
</style>