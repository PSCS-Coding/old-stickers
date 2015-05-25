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
	
	$getBlackStickers = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT blackstickers FROM offerings WHERE classid = $classid ORDER BY classid DESC LIMIT 1"));
	$getGreyStickers  = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT greystickers  FROM offerings WHERE classid = $classid ORDER BY classid DESC LIMIT 1"));
	$getWhiteStickers = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT whitestickers FROM offerings WHERE classid = $classid ORDER BY classid DESC LIMIT 1"));

	$blackArray = $getBlackStickers;
	$greyArray  = $getGreyStickers;
	$whiteArray = $getWhiteStickers;
	
	$mergeArray = array();
	
	foreach ($blackArray as $sub) { array_push($mergeArray, $sub); }
	foreach ($greyArray  as $sub) { array_push($mergeArray, $sub); }
	foreach ($blackArray as $sub) { array_push($mergeArray, $sub); }
	
	foreach($mergeArray as $sub) {
		$deletedsticker = false;
		if ($sub == $studentid) {
			//you've alredy stickered this class, so delete sticker
			
			//find out which color the sticker is
			foreach($blackArray as $child) {
				if ($child == $studentid) {
					print_r($blackArray);
					$key = array_search($studentid,$blackArray);
					echo $key;
					unset($key);
					print_r($blackArray);
					$implodedBlackStickers = implode(',', $blackArray);
					$stmt = $db_stickers->prepare('UPDATE offerings SET blackstickers = ? WHERE classid = ?');
					$stmt->bind_param('ss', $implodedBlackStickers, $classid);
					$stmt->execute();
					$stmt->close();
						
					$deletedSticker = true;
					return "unstickered";
				}
				break;
			}
			foreach($greyArray as $child) {
				if ($child == $studentid) {
					unset($child);
					$implodedGreyStickers = implode(',', $greyArray);
					$stmt = $db_stickers->prepare('UPDATE offerings SET greystickers = ? WHERE classid = ?');
					$stmt->bind_param('ss', $implodedGreyStickers, $classid	);
					$stmt->execute();
					$stmt->close();
						
					$deletedSticker = true;
					return "unstickered";
				}
				break;
			}
			foreach($whiteArray as $child) {
				if ($child == $studentid) {
					unset($child);
					$implodedWhiteStickers = implode(',', $whiteArray);
					$stmt = $db_stickers->prepare('UPDATE offerings SET whitestickers = ? WHERE classid = ?');
					$stmt->bind_param('ss', $implodedWhiteStickers, $classid);
					$stmt->execute();
					$stmt->close();
						
					$deletedSticker = true;
					return "unstickered";
				}
				break;
			}
		}
		break;
	}
	if ($deletedsticker != true) {
		//you haven't stickered this class, so add sticker
		
		//find out which 
		if ($stickertype == "black") {
			if ($blackArray == 0) {
				array_push($blackArray, $studentid);
				$implodedBlackStickers = implode(',', $blackArray);
				$stmt = $db_stickers->prepare('UPDATE offerings SET blackstickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $implodedBlackStickers, $classid); 
				$stmt->execute();
				$stmt->close();
			} else {
				$stmt = $db_stickers->prepare('UPDATE offerings SET blackstickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $studentid, $classid); 
				$stmt->execute();
				$stmt->close();
			}
		}
		if ($stickertype == "grey") {
			if ($greyArray == 0) {
				array_push($greyArray, $studentid);
				$implodedGreyStickers = implode(',', $greyArray);
				$stmt = $db_stickers->prepare('UPDATE offerings SET stickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $implodedGreyStickers, $classid); 
				$stmt->execute();
				$stmt->close();
			} else {
				$stmt = $db_stickers->prepare('UPDATE offerings SET greystickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $studentid, $classid); 
				$stmt->execute();
				$stmt->close();
			}
		}
		if ($stickertype == "white") {
			if ($whiteArray == 0) {
				array_push($whiteArray, $studentid);
				$implodedWhiteStickers = implode(',', $whiteArray);
				$stmt = $db_stickers->prepare('UPDATE offerings SET whitestickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $implodedWhiteStickers, $classid);
				$stmt->execute();
				$stmt->close();
			} else {
				$stmt = $db_stickers->prepare('UPDATE offerings SET whitestickers = ? WHERE classid = ?');
				$stmt->bind_param('ss', $studentid, $classid); 
				$stmt->execute();
				$stmt->close();
			}
		}
		return "stickered";
	}
}
	
?>