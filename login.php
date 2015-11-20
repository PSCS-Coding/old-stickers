<?php
	require_once("connection.php");
	
	session_start();
	
	if (!empty($_SESSION["login"])) {
		
		if (!empty($_SERVER['HTTP_REFERER'])) {
			
			header("Location:" . $_SERVER['HTTP_REFERER'],true);
			
		} else {
			
			header('Location:index.php',true);	
			
		}
		
	}
	
	$loginResult = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT * FROM login"));
	
	
	
?>