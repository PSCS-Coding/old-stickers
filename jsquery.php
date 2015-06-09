<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if($_GET['students']==1){
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname DESC");
	
	$studentinfo = array();
		while ($student_data = $studentquery->fetch_assoc()) {
			array_push($studentinfo, $student_data);
		}
		foreach($studentinfo as $studentrow){
			echo $studentrow['studentid'] . "," . $studentrow['firstname'] . "," . $studentrow['lastname'] . "---";
		}
	} elseif ($_GET['pass']==1){
		if ($LoginResult = $db_attendance->query("SELECT * FROM login WHERE username='pscs'")){
			$LoginRow = $LoginResult->fetch_assoc();
			$LoginResult->free();
		}
		$studentPW = $LoginRow['password'];
		$adminPW = $LoginRow['adminPass'];
		$SecureAdminPW = $adminPW;
		$SecureStudentPW = $studentPW;
		echo $SecureAdminPW . "," . $SecureStudentPW;
	}
}
?>