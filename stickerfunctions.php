<?php
include_once("function.php");
include_once("connection.php");
global $db_attendance;
global $db_stickers;

function resetstickers(){
	global $db_attendance;
	global $db_stickers;
	$db_stickers->query("TRUNCATE `offerings`");
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
}

function get_teacher($url){
	$text = file_get_contents($url);
	$regex = "/<span>(.*?)<\/span>/";
	
	if (preg_match_all($regex, $text ,$matches)) {
			$string = $matches[1][0];
			$string = str_replace("(", null, $string);
			$string = str_replace(")", null, $string);
			return $string;
	}
}

function is_block($url){
	$text = file_get_contents($url);
	$regex = "/<span class=block>(.*?)<\/span>/";
	
	if (strpos($text, '<span class="block">This is a block class.</span>')) {
		return "1";
	} else {
		return "0";
	}
}

function classidToName($id)
{
    global $db_attendance;
	global $db_stickers;
    $query = $db_stickers->query("SELECT classname FROM offerings WHERE classid = $id");
	$tempvar = $query->fetch_assoc();
	$name = $tempvar['classname'];
    return($name);
}

function getstudents($classid,$stickercolor){ // gets studentids of students that have stickered a class
	global $db_attendance;
	global $db_stickers;
	
	$getstickers = $db_stickers->query("SELECT $stickercolor FROM offerings WHERE classid=$classid");
	$allstickers = array();
	while($data_result = $getstickers->fetch_row()) {
		array_push($allstickers, $data_result);
	}
	$allstickers = $allstickers[0];
	
	//echo "<pre>";
	//print_r($allstickers);
	//echo "</pre>";
	
	return($allstickers);
}

function getclasses($studentid,$stickercolor){
	global $db_attendance;
	global $db_stickers;

	$returninfo = array();
	
	$getclasses = $db_stickers->query("SELECT $stickercolor FROM offerings");
	$allclasses = array();
	
	while($data_result = $getclasses->fetch_row()) {
		array_push($allclasses, $data_result[0]);
	}
	
	for($i = 0; $i < count($allclasses); $i++ ){
		$students = explode(",", $allclasses[$i]);
			if (in_array($studentid,$students)){
				$k = $i+1;
				array_push($returninfo,$k);
			}
	}
	
	return($returninfo);
}
	
	
function updateused($studentid,$stickertype,$update,$block){ // updates used stickers
	global $db_attendance;
	global $db_stickers;
	
	if ($block == 1){
		$stickertype = "block" . $stickertype;
	}
	
	$getused  =  $db_stickers->query("SELECT $stickertype FROM usedstickers WHERE studentid=$studentid");
	$usedstickers = array();
		while($data_result = $getused->fetch_row()){
			array_push($usedstickers, $data_result);
		}
		$usedstickers = $usedstickers[0][0];
		
		if ($update == "add"){
			$usedstickers++;
		} elseif ($update == "remove"){
			$usedstickers--;
		}
			$stmt = $db_stickers->prepare("UPDATE usedstickers SET $stickertype = ? WHERE studentid=$studentid");
			$stmt->bind_param('s', $usedstickers);
			$stmt->execute(); 
}
	
function addsticker($studentid,$classid,$stickertype){ // adds / removes stickers from classes
	global $db_attendance;
	global $db_stickers;
	
	//update stickertype to 0,1,2
	switch ($stickertype){
		case "black":
			$stickervalue = 0;
			break;
		case "grey":
			$stickervalue = 1;
			break;
		case "white":
			$stickervalue = 2;
			break;
		default:
			echo "error, undefined stickertype";
	}
	
	$stickertype = $stickertype . "stickers"; //add the word stickers to the type for queries
	
	//get all stickers for that class
	$getstickers = $db_stickers->query("SELECT blackstickers,greystickers,whitestickers FROM offerings WHERE classid=$classid");
	
	//put results into an array
	$stickers_array = array();
	
	while($data_result = $getstickers->fetch_row()) {
		array_push($stickers_array, $data_result);
	}
	
	//take all individual stickers and put them in one array
	$items = array();
	$allstickers = array();
	foreach ($stickers_array[0] as $sticker){
		$items = explode(",",$sticker);
		foreach($items as $item){
			array_push($allstickers, $item);
		}
	}

	//check if student is there, if they are and color is the same as where they are then remove them
	//if not then add
	
	if(in_array($studentid,$allstickers)){
		//the student has stickered this class, find where it was
		foreach($stickers_array[0] as $sticker){// go through sticker colors
			$items = explode(",",$sticker);
			
			if(in_array($studentid,$items)){ //if it is in that color
				$key  = array_search($sticker,$stickers_array[0]);
				
				if($stickervalue == $key){ //check if same color as input color
					$get_cell = $db_stickers->query("SELECT $stickertype FROM offerings WHERE classid=$classid");
					$get_cell = $get_cell->fetch_row();
					$get_cell = $get_cell[0];
					
					if(strcmp($get_cell, $studentid) == 0){ // check if studentid is the only one in there and if it is set it to zero
						$zero = 0;
						$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
						$stmt->bind_param('s', $zero);
						$stmt->execute();
						return "unstickered";
						
					} else { //otherwise explode and remove
						$cell_array = explode(",",$get_cell);
						$key = array_search($studentid,$cell_array);
						unset($cell_array[$key]); //remove studentid
						$cell_data = implode(",", $cell_array);
						$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
						$stmt->bind_param('s', $cell_data);
						$stmt->execute();
						return "unstickered";

					}
					
				}
			}
		}
			} else {// studentid is not in array
				$get_cell = $db_stickers->query("SELECT $stickertype FROM offerings WHERE classid=$classid");
				$get_cell = $get_cell->fetch_row();
				$get_cell = $get_cell[0];
				
				if(strcmp($get_cell,"0") == 0){ // no numbers so just add
					$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
					$stmt->bind_param('s', $studentid);
					$stmt->execute();
					return "stickered";
					
				} else { //add to end of explosion
					$cell_array = explode(",",$get_cell);
					array_push($cell_array,$studentid);
					$cell_data = implode(",", $cell_array);
					$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
					$stmt->bind_param('s', $cell_data);
					$stmt->execute();
					return "stickered";
				}
			}


}
	
// thing to call reset must be after reset function
if (!empty($_GET['reset'])){
	resetstickers();
}
?>