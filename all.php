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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<script>
console.log("classes:");
setInterval(function () {
	if (document.getElementById("toggle").checked == true) {
		//	console.log("classes:");
			var classes = getClasses().split(",");
			var classElements = document.getElementsByClassName("class");
			
			for (var i = 0; i < Math.max(classes.length,classElements.length); i++) {
				console.log(classes[i]);
				$(document).ready(function(){
					$("<span>Hello world!</span>").insertBefore("#sortText");
				});
			}
	}
}, 3000);
function getClasses () {
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", "allupdate.php", false );
		xmlHttp.send( null );
		return xmlHttp.responseText;
}
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

	$highs = array();
	foreach($classesResult as $sub) {
		$blackstickers = getstudents($sub["classid"],"blackstickers");
		$greystickers = getstudents($sub["classid"],"greystickers");
		$whitestickers = getstudents($sub["classid"],"whitestickers");

		$blackstickers = explode(",", $blackstickers[0]);
		$greystickers = explode(",", $greystickers[0]);
		$whitestickers = explode(",", $whitestickers[0]);

		$highestVal = max(count($blackstickers), count ($greystickers), count($whitestickers));
	}
	

  function byHighest($a, $b) {
	$highestA = max(strlen($a['blackstickers']), strlen($a['greystickers']), strlen($a['whitestickers']));
	$highestB = max(strlen($b['blackstickers']), strlen($b['greystickers']), strlen($b['whitestickers']));
    return strnatcmp($highestA, $highestB);
  }

  // sort alphabetically by name
  usort($classesResult, 'byHighest');
  $classesResult = array_reverse($classesResult);//reverse
  
foreach($classesResult as $sub) {
	$blackstickers = getstudents($sub["classid"],"blackstickers");
	$greystickers = getstudents($sub["classid"],"greystickers");
	$whitestickers = getstudents($sub["classid"],"whitestickers");

	$blackstickers = explode(",", $blackstickers[0]);
	$greystickers = explode(",", $greystickers[0]);
	$whitestickers = explode(",", $whitestickers[0]);

	$highestVal = max(count($blackstickers), count ($greystickers), count($whitestickers));
	
	?>	<table class="class" name= <?php echo $sub["classid"] ?> >
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
				<td class="stickercell"> <?php if (!empty($blackstickers[$i])) echo "<div class='blackstickers'>" . idToName($blackstickers[$i]) . "</div>"; ?> </td>
				<td class="stickercell"> <?php if (!empty($greystickers[$i]))  echo "<div class='greystickers'>" . idToName($greystickers[$i]) . "</div>";  ?> </td>
				<td class="stickercell"> <?php if (!empty($whitestickers[$i])) echo "<div class='whitestickers'>" . idToName($whitestickers[$i]) . "</div>"; ?> </td> 
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
	max-width:186px;
}
.stickercell {
	height:30px;
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
	background-color:black;
	color:white;
	text-align:center;
}
.greystickers {
	background-color:grey;
	color:black;
	text-align:center;
}
.whitestickers {
	background-color:white;
	color:black;
	text-align:center;
}
.black {
	color:white;
}
</style>