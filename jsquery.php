<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if($_GET['students']==1){
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname ASC");
	
	$studentinfo = array();
		while ($student_data = $studentquery->fetch_assoc()) {
			array_push($studentinfo, $student_data);
		}
		foreach($studentinfo as $studentrow){
			echo $studentrow['studentid'] . "," . $studentrow['firstname'] . "," . $studentrow['lastname'] . "---";
		}
	}
}
?>