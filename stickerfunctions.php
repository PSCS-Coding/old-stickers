<?php
function updateused($studentid,$stickertype,$update){
	global $db_attendance;
	global $db_stickers;
	
	$getused  =  $db_stickers->query("SELECT $stickertype FROM usedstickers WHERE studentid=$studentid");
	$usedstickers = array();
		while($data_result = $getused->fetch_row()) {
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
	
function addsticker($studentid,$classid,$stickertype){
	// $studentid . " " . $classid . " " . $stickertype . "<br>";
	global $db_attendance;
	global $db_stickers;
	
	$getBlackStickers = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT blackstickers FROM offerings WHERE classid = $classid ORDER BY name DESC LIMIT 1"));
	$getGreyStickers  = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT greystickers  FROM offerings WHERE classid = $classid ORDER BY name DESC LIMIT 1"));
	$getWhiteStickers = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT whitestickers FROM offerings WHERE classid = $classid ORDER BY name DESC LIMIT 1"));

	$blackArray = explode(",", $getBlackStickers);
	$greyArray  = explode(",", $getGreyStickers);
	$whiteArray = explode(",", $getWhiteStickers);
	
	$mergeArray = array();
	
	foreach ($blackArray as $sub) { array_push($mergeArray, $sub); }
	foreach ($greyArray  as $sub) { array_push($mergeArray, $sub); }
	foreach ($blackArray as $sub) { array_push($mergeArray, $sub); }

	foreach($mergeArray as $sub) {
		if ($sub == $studentid) {
			//you've alredy stickered this class, so delete sticker
			
			//find out which color the sticker is
			foreach($blackArray as $child) {
				if ($child == $studentid) {
					unset($child);
					$implodedBlackStickers = implode(',', $blackArray);
					$stmt = $db_server->prepare('UPDATE offerings SET blackstickers = ? WHERE classid = $classid');
					$stmt->bind_param('s', $implodedBlackStickers);
					$stmt->execute();
					$stmt->close();
				}
				break;
			}
			foreach($greyArray as $child) {
				if ($child == $studentid) {
					unset($child);
					$implodedGreyStickers = implode(',', $greyArray);
					$stmt = $db_server->prepare('UPDATE offerings SET greystickers = ? WHERE classid = $classid');
					$stmt->bind_param('s', $implodedGreyStickers);
					$stmt->execute();
					$stmt->close();
				}
				break;
			}
			foreach($whiteArray as $child) {
				if ($child == $studentid) {
					unset($child);
					$implodedGreyStickers = implode(',', $greyArray);
					$stmt = $db_server->prepare('UPDATE offerings SET greystickers = ? WHERE classid = $classid');
					$stmt->bind_param('s', $implodedGreyStickers);
					$stmt->execute();
					$stmt->close();
				}
				break;
			}
			$deletedSticker == true;
		}
		return "unstickered";
		break;
	}
	if ($deletedsticker != true) {
		//you haven't stickered this class, so add sticker
		
		//find out which 
		if ($stickertype == "black") {
			array_push($studentid, $blackArray);
			$implodedBlackStickers = implode(',', $blackArray);
			$stmt = $db_server->prepare('UPDATE offerings SET blackstickers = ? WHERE classid = $classid');
			$stmt->bind_param('s', $implodedBlackStickers);
			$stmt->execute();
			$stmt->close();
		}
		if ($stickertype == "grey") {
			array_push($studentid, $greyArray);
			$implodedGreyStickers = implode(',', $greyArray);
			$stmt = $db_server->prepare('UPDATE offerings SET greystickers = ? WHERE classid = $classid');
			$stmt->bind_param('s', $implodedGreyStickers);
			$stmt->execute();
			$stmt->close();
		}
		if ($stickertype == "black") {
			array_push($studentid, $blackArray);
			$implodedGreyStickers = implode(',', $greyArray);
			$stmt = $db_server->prepare('UPDATE offerings SET greystickers = ? WHERE classid = $classid');
			$stmt->bind_param('s', $implodedGreyStickers);
			$stmt->execute();
			$stmt->close();
		}
		return "stickered";
	}
}
	
?>