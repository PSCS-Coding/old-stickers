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
$zero = "0";
foreach ($feed as $class) {
	$stmt = $db_stickers->prepare("INSERT INTO offerings (classname,facilitator,category,description,image,blackstickers,greystickers,whitestickers) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssssss', $class['title'], $class['creator'], $class['category'], $class['desc'], $class['content'], $zero, $zero, $zero);
    $stmt->execute();
    $stmt->close();

}

// insert alotted stickers

$db_stickers->query("truncate usedstickers");

$getallottedstickers = $db_stickers->query("SELECT * FROM allottedstickers");
$allottedstickers = $getallottedstickers->fetch_row();

echo "<pre>";;
print_r($allottedstickers);
echo "</pre>";

$getstudents = $db_attendance->query("SELECT * FROM studentdata WHERE current=1");
$studentinfo = array();
	while ($student_data = $getstudents->fetch_assoc()) {
		array_push($studentinfo, $student_data);
	}


foreach($studentinfo as $student){
    
    $stmt = $db_stickers->prepare("INSERT INTO usedstickers (studentid,blackstickers,greystickers,whitestickers) VALUES (?,?,?,?)");
    $stmt->bind_param('iiii', $student['studentid'], $allottedstickers[0], $allottedstickers[1], $allottedstickers[2]);
    $stmt->execute();
    $stmt->close();
    
}

?>

</html>