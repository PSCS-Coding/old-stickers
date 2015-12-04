<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="stickers.css">

<style>
    .spinner {
  margin: 100px auto 0;
  width: 70px;
  text-align: center;
}

.spinner > div {
  width: 18px;
  height: 18px;
  background-color: #333;

  border-radius: 100%;
  display: inline-block;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    transform: scale(1.0);
  }
}
</style>

</head>
<div id="reset">
    <p> Reset in progress </p>
        <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<?php
/*


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
*/
?>



</html>