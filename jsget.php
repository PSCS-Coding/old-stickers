<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	$returninfo = addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
	
		if($returninfo == "stickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","remove");
		} elseif ($returninfo == "unstickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","add");
		}
		$studentid = $_GET['studentid'];
		$stickertype = $_GET['stickercolor'] . "stickers";
		$getused  =  $db_stickers->query("SELECT $stickertype FROM usedstickers WHERE studentid=$studentid");
		$usedstickers = array();
			while($data_result = $getused->fetch_row()) {
				array_push($usedstickers, $data_result);
			}
		$usedstickers = $usedstickers[0][0];
		//echo $usedstickers;
	echo $returninfo;
}
?>