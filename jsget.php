<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	$returninfo = addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
	
		if($returninfo == "stickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","remove");
		} elseif ($returninfor == "unstickered"){
			updateused($_GET['studentid'],$_GET['stickercolor']. "stickers","remove");
		}
	echo "success";
	/*echo $_GET['studentid'] . "  ";
	echo $_GET['classid'] . "  ";
	echo $_GET['stickercolor'] . "  ";
	*/
} else {
	echo "failure";
}
?>