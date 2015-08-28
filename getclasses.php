<?php
include_once("connection.php");

$slot = $_GET["slot"];
$classQuery = $db_stickers->query("SELECT property FROM scheduledata WHERE id ='$slot' LIMIT 1");
echo $classQuery->fetch_array()[0];
?>