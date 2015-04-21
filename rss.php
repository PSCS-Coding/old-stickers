<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
</head>
<?php

include_once("connection.php");

$rssInfo = getRss();

foreach ($rssInfo as $class) {
	echo "<pre>";
	print_r($class);
	echo "</pre>";
	/*
	$stmt = $db_stickers->prepare("INSERT INTO classes (classname) VALUES (?)");
    $stmt->bind_param('s', $class['title']);
    $stmt->execute();
    $stmt->close();
	*/

}


function rss_to_array($tag, $array, $url) {
		$doc = new DOMdocument();
		$doc->load($url);
		$rss_array = array();
		$items = array();
		foreach($doc->getElementsByTagName($tag) AS $node) {	
			foreach($array AS $key => $value) {
				$items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
			}
			array_push($rss_array, $items);
		}
		return $rss_array;
	}
	
function getRss(){
$rss_tags = array(
		'title',
		'link',
		'guid',
		'comments',
		'description',
		'pubDate',
		'category',
	);
	$rss_item_tag = 'item';
	$rss_url = 'http://classes.pscs.org/feed';
	
	$rssfeed = rss_to_array($rss_item_tag,$rss_tags,$rss_url);

return $rssfeed;
}
?>

</html>