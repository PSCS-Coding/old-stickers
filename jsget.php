<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
		addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
	echo "success";
	/*echo $_GET['studentid'] . "  ";
	echo $_GET['classid'] . "  ";
	echo $_GET['stickercolor'] . "  ";
	*/
} else {
	echo "failure";
}
?>