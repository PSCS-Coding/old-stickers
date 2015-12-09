<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if ($_GET['block'] == 0){
		$block = "";
	} elseif($_GET['block'] == 1){
		$block = "block";
	}
	echo $block;
	$returninfo = addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
	
		if($returninfo == "stickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","remove",$_GET['block']);
		} elseif ($returninfo == "unstickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","add",$_GET['block']);
		}
		$studentid = $_GET['studentid'];
		$stickertype = $block . $_GET['stickercolor'] . "stickers";
		$getused  =  $db_stickers->query("SELECT $stickertype FROM usedstickers WHERE studentid=$studentid");
		$usedstickers = array();
			while($data_result = $getused->fetch_row()) {
				array_push($usedstickers, $data_result);
			}
		$usedstickers = $usedstickers[0][0];
		if($usedstickers < 0){
				$returninfo = addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
			
				if($returninfo == "stickered"){
					updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","remove",$_GET['block']);
				} elseif ($returninfo == "unstickered"){
					updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","add",$_GET['block']);
				}
				$returninfo = null;
		}
		
	echo $returninfo;
}
?>