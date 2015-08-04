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
<script>
setInterval(function () {
	if (document.getElementById("toggle").checked == true) {
		alert("Hello");
	}
}, 3000);

</script>
<body>
<?php
$classesQuery = $db_stickers->query("SELECT * FROM offerings ORDER BY classname ASC");
$classesResult = array();
while($class = $classesQuery->fetch_assoc()) {
	array_push($classesResult, $class);
}

?>

<!-- Toolbar -->

<div id="toolbar">
	<!-- Live Updates -->
	<span class="toolbarText" id="toggleText">Live Updates</span>
	<input id="toggle" type="checkbox" checked>
	
	<!-- Sorting Options -->
	<span class="toolbarText" id="sortText">Sort by</span>
	<select id="sort">
		<option>Class Name</option>
		<option>Time Added</option>
		<option>Most Stickered</option>
		<option>Facilitator</option>
	</select>
</div>

<br /><br /><br />


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
</body>
</html>
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
#toolbar {
    position: fixed;
    background-color: white;
    width: 100%;
    z-index: 5;
    opacity: 0.9;
    min-height: 4%;
    top: 0;
}
#toggle {
	float:right;
	margin-right:1%;
	margin-top:.8%;
	transform:scale(1.5);
}
#sort {
	float:left;
	font-size:12pt;
	margin-top:.6%;
	margin-left:1%;
}
.toolbarText {
	margin-top:.6%;
	font-weight:bold;
	font-size:14pt;
}
#toggleText {
	float:right;
	margin-right:7%;
}
#sortText {
	float:left;
	margin-left:2%;
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