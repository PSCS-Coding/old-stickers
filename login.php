<DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stickers.css"> 
	</head>
	
	<script>
		function triggerAnimation() {
			console.log("triggered");
			document.getElementById("sjw").innerHTML = "<div class='spinner'><div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div></div>";
		}
	</script>
	
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
		<p style="padding:0;margin:5%">Please Log In</p>
		<form method="post">
			<input type="password" name="pass" id="logininput">
		</form>
		
		<div id="sjw">
			<button id="submitlogin" onclick="triggerAnimation()" style="margin-top:2%">Submit</button>
		</div>
		
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