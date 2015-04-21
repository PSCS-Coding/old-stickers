<?php
// Sets a new MySQLi instance
	$db_hostname = 'localhost';
	$db_username = 'root';
	$db_password = '';
	$db_database = 'pscsorg_stickers';
	$db_stickers = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if ($db_stickers->connect_error) { die('Connect Error (' . $db_stickers->connect_errno . ') '  . $db_stickers->connect_error); }
        // THIS LINE TELLS THE SERVER TO UNDERSTAND US AS IN THE PACIFIC TIME ZONE
        $db_stickers->query("SET time_zone='US/Pacific';");
?>