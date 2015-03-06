<?php
include_once("rss.php");
$rssInfo = getRss();

foreach ($rssInfo as $class) {
	echo $class['title'] . " " . $class[''] . "<br />";
}
?>