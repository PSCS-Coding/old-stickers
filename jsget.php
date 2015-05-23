<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
echo "return";
if(!empty($_GET)){
	addsticker($_GET['studentid'],$_GET['classid'],$_GET['stickercolor']);
}
?>