<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if(!empty($_GET['students'])){
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname DESC");
	
	$studentinfo = array();
		while ($student_data = $studentquery->fetch_assoc()) {
			array_push($studentinfo, $student_data);
		}
		foreach($studentinfo as $studentrow){
			echo $studentrow['studentid'] . "," . $studentrow['firstname'] . "," . $studentrow['lastname'] . "---";
		}
	} elseif (!empty($_GET['pass'])){
		if ($LoginResult = $db_attendance->query("SELECT password,adminPass FROM login WHERE username='pscs'")){
			$LoginRow = $LoginResult->fetch_assoc();
			$LoginResult->free();
		}
		$studentPW = $LoginRow['password'];
		$adminPW = $LoginRow['adminPass'];
		$SecureAdminPW = crypt($adminPW, "P9");
		$SecureStudentPW = crypt($studentPW, "P9");
		echo $SecureAdminPW . "," . $SecureStudentPW;
	}
}
?>