<?php
include_once("rss.php");
include_once("connection.php");

$rssInfo = getRss();

foreach ($rssInfo as $class) {
	echo "<pre>";
	print_r($class);
	//echo $class['title'] . " " . $class[''] . "<br />";
	echo "</pre>";
	$stmt = $db_stickers->prepare("INSERT INTO classes (classname) VALUES (?)");
    $stmt->bind_param('s', $class['title']);
    $stmt->execute();
    $stmt->close();

}
?>