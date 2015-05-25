<?php
	
function addsticker($studentid,$classid,$stickertype){
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
	
	echo "<pre>";
	print_r($stickers_array[0]);
	echo "</pre>";
	
	//check if student is there, if they are and color is the same as where they are then remove them
	//if not then add
	
	if(in_array($studentid,$allstickers)){
		//the student has stickered this class, find where it was
		foreach($stickers_array[0] as $sticker){// go through sticker colors
			$items = explode(",",$sticker);
			
			if(in_array($studentid,$items)){ //if it is in that color
				$key  = array_search($sticker,$stickers_array[0]);
				echo $studentid . " found in color " . $key . "<br>";
				
				if($stickervalue == $key){ //check if same color as input color
					echo "time to remove" . "<br>";
					$get_cell = $db_stickers->query("SELECT $stickertype FROM offerings WHERE classid=$classid");
					$get_cell = $get_cell->fetch_row();
					$get_cell = $get_cell[0];
					echo $get_cell . "<br>";
					
					if(strcmp($get_cell, $studentid) == 0){ // check if studentid is the only one in there and if it is set it to zero
						echo "its the studentid";
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
	}


}
?>