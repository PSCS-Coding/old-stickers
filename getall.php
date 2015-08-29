<?php
	include_once("connection.php");
	
	$query = $db_stickers->query("SELECT classid FROM offerings");
	while ($row = $query->fetch_assoc()) {
		echo $row['classid'] . ",";
	}
?>