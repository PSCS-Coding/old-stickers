<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
</head>
<?php

include_once("connection.php");

$db_stickers->query("truncate offerings");

$rss = new DOMDocument();
$rss->load('http://classes.pscs.org/feed/');
$feed = array();
foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array (
        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
		'category' => $node->getElementsByTagName('category')->item(0)->nodeValue,
        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
        'creator' => $node->getElementsByTagName('creator')->item(0)->nodeValue,
        'content' => $node->getElementsByTagName('encoded')->item(0)->nodeValue,
        'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
        );
    array_push($feed, $item);
}
foreach($feed as &$k){
    $img = $k['content'];
    if (preg_match('/src="(.*?)"/', $img, $matches)) {
            $src = $matches[1];
            $k['content'] = $src;
    }
}

foreach ($feed as $class) {

	$stmt = $db_stickers->prepare("INSERT INTO offerings (classname,facilitator,category,description) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $class['title'], $class['creator'], $class['category'], $class['desc']);
    $stmt->execute();
    $stmt->close();

}
?>

</html>