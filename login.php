<DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stickers.css"> 
	</head>
	
	<body>
	<?php
	require_once("connection.php");
	
	
	$loginResult = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT * FROM login"));
	
	if (!isset($_COOKIE["slogin"])) {
		setcookie("slogin","value");
		$slogin = "value";
	} else {
		$slogin = $_COOKIE["slogin"];
	}
	
	if ($slogin == "student" || $slogin == "admin") {
		
		if (!empty($_SERVER['HTTP_REFERER'])) {
			
			header("Location:" . $_SERVER['HTTP_REFERER'],true);
			
		} else {
			
			header('Location:index.php',true);	
			
		}
		
	}
	?>
	<div id="loginbox">
	
		<form method="post">
			<input type="password" name="pass">
		</form>
	
	</div>
	
<?php
if (!empty($_POST["pass"])) {
	if ($_POST["pass"] == $loginResult["student"]) {
		setcookie("slogin", "student");
		//redirect
		if (!empty($_SERVER['HTTP_REFERER'])) {
			header("Location:" . $_SERVER['HTTP_REFERER'],true);
		} else {
			header('Location:index.php',true);	
		}
	} else if ($_POST["pass"] == $loginResult["admin"]) {
		setcookie("slogin", "admin");
		//redirect
		if (!empty($_SERVER['HTTP_REFERER'])) {
			header("Location:" . $_SERVER['HTTP_REFERER'],true);
		} else {
			header('Location:index.php',true);	
		}
	}
}
?>
</body>
</html>