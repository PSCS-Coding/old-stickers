<?php
// Sets a new MySQLi instance for the stickers table
	$db_hostname = 'localhost';
	$db_username = 'root';
	$db_password = 'root';
	$db_database = 'pscsorg_stickers';
	$db_stickers = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($db_stickers->connect_error) { die('Connect Error (' . $db_stickers->connect_errno . ') '  . $db_stickers->connect_error); }
        // THIS LINE TELLS THE SERVER TO UNDERSTAND US AS IN THE PACIFIC TIME ZONE
        $db_stickers->query("SET time_zone='US/Pacific';");
		
// Sets a new MySQLi instance for the normal attendance tables
	$db_hostname = 'localhost';
	$db_username = 'root';
	$db_password = 'root';
	$db_database = 'pscsorg_attendance';
	$db_attendance = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($db_attendance->connect_error) { die('Connect Error (' . $db_attendance->connect_errno . ') '  . $db_attendance->connect_error); }
        // THIS LINE TELLS THE SERVER TO UNDERSTAND US AS IN THE PACIFIC TIME ZONE
        $db_attendance->query("SET time_zone='US/Pacific';");
		
?>