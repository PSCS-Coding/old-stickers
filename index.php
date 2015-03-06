<?php
include_once("rss.php");
$rssInfo = getRss();

foreach ($rssInfo as $class) {
	echo "<pre>";
	print_r($class);
	//echo $class['title'] . " " . $class[''] . "<br />";
	echo "</pre>";
}
?>