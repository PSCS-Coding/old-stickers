<?php
function addsticker($studentid,$classid,$stickertype){
	// $studentid . " " . $classid . " " . $stickertype . "<br>";
	global $db_attendance;
	global $db_stickers;
	$zero = 0;

	$stickertype = $stickertype . "stickers";
	
	//get all stickers for that class
	$getallstickers = $db_stickers->query("SELECT blackstickers,greystickers,whitestickers FROM offerings WHERE classid=$classid");
	
		$rowresult = array();
		while($data_result = $getallstickers->fetch_assoc()) {
			array_push($rowresult, $data_result);
		}
		
		$stickercolors = array();
		array_push($stickercolors,"blackstickers","greystickers","whitestickers");
		
		foreach($stickercolors as $color){
			// $rowresult[0][$color] . "<br>";
			
			if(strcmp($rowresult[0][$color],$studentid) == 0){
				// " cell is the same as studentid";
				if($color == $stickertype){
					// "was of selected color so remove";
					$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
					$stmt->bind_param('s', $zero);
					$stmt->execute();
				} else {
					// " already stickered in different color";
					break;
				}
			} elseif ($rowresult[0][$color] == 0){
				// " no stickers";
				if($color == $stickertype){
					// "zero so just add";
					$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
					$stmt->bind_param('s', $studentid);
					$stmt->execute();
				}
			} elseif(strpos($rowresult[0][$color],",")) {
				$celldata = explode(",",$rowresult[0][$color]);
				// "<pre>";
				print_r($celldata);
				// "</pre>"; 
				if (in_array($studentid,$celldata)){
					// "already in " . $color . " " . $stickertype;
					if($color == $stickertype){
						// "already stickered here so remove";
						$key = array_search($studentid,$celldata);
						unset($celldata[$key]);
						$celldata = implode(",", $celldata);
						$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
						$stmt->bind_param('s', $celldata);
						$stmt->execute();
					}
				} else {
					if($color == $stickertype){
						// "not stickered but should be ";
						array_push($celldata, $studentid);
						$celldata = implode(",", $celldata);
						$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
						$stmt->bind_param('s', $celldata);
						$stmt->execute();
					}
				}
			}
		}
	
}	
?>