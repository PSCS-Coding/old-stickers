<?php
    include_once("connection.php");
	
	$id = $_GET["id"];
    $query = $db_stickers->query("SELECT classname FROM offerings WHERE classid = $id");
	$tempvar = $query->fetch_assoc();
	$name = $tempvar['classname'];
	echo $name;
?>