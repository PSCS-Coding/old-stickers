<?php
function addsticker($studentid,$classid,$stickertype){
	echo $studentid . " " . $classid . " " . $stickertype;
	global $db_attendance;
	global $db_stickers;
	
	$stickertype = $stickertype . "stickers";
	
	//get all stickers for that class
	$getallstickers = $db_stickers->query("SELECT blackstickers,greystickers,whitestickers FROM offerings WHERE classid=$classid");
	
		$rowresult = array();
		while($data_result = $getallstickers->fetch_assoc()) {
			array_push($rowresult, $data_result);
		}
		echo "<pre>";
		print_r($rowresult);
		echo "</pre>";
		
		$stickercolors = array();
		if ($stickertype != "blackstickers"){
			array_push($stickercolors,"blackstickers");
		}
		if ($stickertype != "greytickers"){
			array_push($stickercolors,"greystickers");
		}
		if ($stickertype != "whitestickers"){
			array_push($stickercolors,"whitestickers");
		}
		
		$presticker = false;
		
		foreach($stickercolors as $color){ // for each sticker color other than the selected one
		echo "the celldata for " . $color . " is " . $rowresult[0][$color];
		
			if(strcmp($rowresult[0][$color],$studentid) == 0) {// if sticker is the only one already in
				$presticker = $color;
				echo "only sticker on " . $rowresult[0][$color] . " = " . $studentid;
				break;
				
			} elseif(strpos($rowresult[0][$color],",")) { // if sticker is a middle value
				echo $studentid . " already has a sticker on " . $color;
				$presticker = $color;
				break;

			} 
			
		}
		
		if($presticker==false){
	
	//get stickers in that classes cell
	$getstickers = $db_stickers->query("SELECT $stickertype FROM offerings WHERE classid=$classid");
	
		$stickersresult = array();
		while($data_result = $getstickers->fetch_assoc()) {
			array_push($stickersresult, $data_result);
		}
		
	$cell = $stickersresult[0][$stickertype];
	echo "cell = " . $cell;
	
	if($cell == "0"){
		echo "there are not stickers so just add";
		
		$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
		$stmt->bind_param('s', $studentid);
		$stmt->execute();
		
	} elseif(strpos($cell,",")) {
		echo "explode implode";
		$cellarray = explode(",",$cell);
		
		if(!in_array($studentid,$cellarray)){	
			
			array_push($cellarray,$studentid);
			$celldata = implode(",",$cellarray);
			$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
			$stmt->bind_param('s', $celldata);
			$stmt->execute();
		}
		
	}  elseif($cell == $studentid) {
		echo "thats the only student in there";
	
	} else {
		echo  "theres only one value";
		
		$updatedstudentid = $cell . "," . $studentid;
		$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
		$stmt->bind_param('s', $updatedstudentid);
		$stmt->execute();
	}
} else {
	echo "<br>";
	echo "already stickered on " . $presticker;
}

}

?>