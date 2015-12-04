<?php
	require_once("connection.php");
	
	
	$loginResult = mysqli_fetch_assoc(mysqli_query($db_stickers, "SELECT * FROM login"));
	
	if (!isset($_COOKIE["slogin"])) {
		setcookie("slogin","value");
	}
	
	if ($_COOKIE["slogin"] == "student" || $_COOKIE["slogin"] == "admin") {
		
		if (!empty($_SERVER['HTTP_REFERER'])) {
			
			header("Location:" . $_SERVER['HTTP_REFERER'],true);
			
		} else {
			
			header('Location:index.php',true);	
			
		}
		
	}
?>
	
	<form method="post">
		<input type="password" name="pass">
	</form>
	
<?php
if (!empty($_POST["pass"])) {
	if ($_POST["pass"] == $loginResult["student"]) {
		setcookie("slogin", "student");
		echo "student";
	} else if ($_POST["pass"] == $loginResult["admin"]) {
		setcookie("slogin", "admin");
		echo "admin";
	}
}
?>