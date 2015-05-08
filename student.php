<!DOCTYPE html>
<html>
	<head>
		<title> Student page </title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="stickers.css">
	</head>
<body>
	<?php
	include_once("connection.php");	
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname ASC");
	$studentinfo = array();
	while ($student_data = $studentquery->fetch_assoc()) {
		array_push($studentinfo, $student_data);
}
	?>
	<select>
		<?php 
			foreach($studentinfo as $student){
				echo "<option value=" . $student['studentid'] . ">". $student['firstname'] . " " . substr($student['lastname'], 0, 1) . "</option>";
			}
		?>
	</select>
	<div>
	
	</div>
</body>
</html>