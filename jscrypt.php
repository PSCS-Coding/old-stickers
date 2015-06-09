<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if(!empty($_GET['crypt'])){
		echo crypt($_GET['crypt'], "P9");
	}
}
?>