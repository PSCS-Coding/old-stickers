<DOCTYPE HTML>
<html>
<head>
	<title>Edit Schedule</title>
	<!--<link rel="stylesheet" type="text/css" href="stickers.css">-->
</head>
<?php
	include_once("connection.php");
	include_once("stickerfunctions.php");
	include_once("function.php");
?>
<body>
	<!-- Sidebar -->
	<div id="sidebar">
        <h1 id="title">Edit Slot</h1>
        <p>hello world</p>
    </div>
	<div id="schedule">
	<?php
		//get slot length data
		$lengthQuery = $db_stickers->query("SELECT * FROM schedule LIMIT 1");
		$lengthResult = $lengthQuery->fetch_array();
		
		foreach ($lengthResult as $name => $day) {
			if (!is_int($name)) {
			?>	<table id=<?php echo $name ?> class="day">
					<caption><?php echo ucfirst($name) ?></caption>
					<?php
						$lengths = explode(',', $lengthResult[$name]);
						foreach($lengths as $index => $sub) {
							echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
							if ($index != count($lengths) - 1) { //if not last
								echo "<tr><td class='passing'>Passing Period</td></tr>";
							}
						}
					?>
				</table>
			<?php
			}
		}
		?>
	</div>
			
</body>
</html>

<style>
* {
font-family:calibri;
}
body {
background-color:dimgrey;
}
#title {
	text-align:center;
}
#schedule {
	margin-right:30%;
	margin-top:5%;
}
.day {
	float:right;
	max-width:15%;
	top:0%;
}
.class {
	background-color:#A3CDD4;
}
.passing {
	background-color:azure;
}
#sidebar {
    position: fixed;
    top: 0%;
    left: 0%;
    width: 15%;
    height: 100%;
	opacity:0.8;
	background-color: white;
}
</style>