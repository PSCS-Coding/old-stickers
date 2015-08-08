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
			
			
</body>
</html>

<style>
.day {
	float:left;
}
.class {
	background-color:red;
}
.passing {
	background-color:azure;
}
</style>