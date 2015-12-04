<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="stickers.css">

</head>

<?php



include_once("connection.php");

include_once("stickerfunctions.php");



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

    $facilitator = get_teacher($class['link']);

    $block = is_block($class['link']);

	$stmt = $db_stickers->prepare("INSERT INTO offerings (classname,facilitator,category,description,link,image,block,blackstickers,greystickers,whitestickers) VALUES (?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param('ssssssssss', $class['title'], $facilitator, $class['category'], $class['desc'],$class['link'], $class['content'], $block, $zero, $zero, $zero);

    $stmt->execute();

    $stmt->close();



}



// insert alotted stickers



$db_stickers->query("truncate usedstickers");



$getallottedstickers = $db_stickers->query("SELECT * FROM allottedstickers");

$allottedstickers = $getallottedstickers->fetch_row();



$getstudents = $db_attendance->query("SELECT * FROM studentdata WHERE current=1");

$studentinfo = array();

	while ($student_data = $getstudents->fetch_assoc()) {

		array_push($studentinfo, $student_data);

	}





foreach($studentinfo as $student){

    

    $stmt = $db_stickers->prepare("INSERT INTO usedstickers (studentid,blackstickers,greystickers,whitestickers,blockblackstickers,blockgreystickers,blockwhitestickers) VALUES (?,?,?,?,?,?,?)");

    $stmt->bind_param('iiiiiii', $student['studentid'], $allottedstickers[0], $allottedstickers[1], $allottedstickers[2],$allottedstickers[3],$allottedstickers[4],$allottedstickers[5]);

    $stmt->execute();

    $stmt->close();

    

}



echo "Reset complete!";

?>



</html>