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
			
	?>
			<table id="monday" class="day">
				<caption>Monday</caption>
				<?php
					$lengths = explode(',', $lengthResult["monday"]);
					foreach($lengths as $sub) {
						echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
						echo "<tr><td class='passing'>Passing Period</td></tr>";
					}
				?>
			</table>
			
			<table id="tuesday" class="day">
				<caption>Tuesday</caption>
				<?php
					$lengths = explode(',', $lengthResult["tuesday"]);
					foreach($lengths as $sub) {
						echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
						echo "<tr><td class='passing'>Passing Period</td></tr>";
					}
				?>
			</table>
			
			<table id="wednesday" class="day">
				<caption>Wednesday</caption>
				<?php
					$lengths = explode(',', $lengthResult["wednesday"]);
					foreach($lengths as $sub) {
						echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
						echo "<tr><td class='passing'>Passing Period</td></tr>";
					}
				?>
			</table>
			
			<table id="thursday" class="day">
				<caption>Thursday</caption>
				<?php
					$lengths = explode(',', $lengthResult["thursday"]);
					foreach($lengths as $sub) {
						echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
						echo "<tr><td class='passing'>Passing Period</td></tr>";
					}
				?>
			</table>
			
			<table id="friday" class="day">
				<caption>Friday</caption>
				<?php
					$lengths = explode(',', $lengthResult["friday"]);
					foreach($lengths as $sub) {
						echo "<tr><td class='class' style='height:" . $sub . "'>Class</td></tr>";
						echo "<tr><td class='passing'>Passing Period</td></tr>";
					}
				?>
			</table>
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