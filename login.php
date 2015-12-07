<DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stickers.css"> 
	</head>
	
	<script>
		
		function triggerAnimation() {
			console.log("triggered");
			document.getElementById("sjw").innerHTML = "<div class='spinner'><div class='rect1'></div><div class='rect2'></div><div class='rect3'></div><div class='rect4'></div><div class='rect5'></div></div>";
			setTimeout(func, 4000);
		}
		
function func() {
    document.getElementById("loginform").submit();
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
	
	if ($_GET["admin"] != true) {
		if ($slogin == "student" || $slogin == "admin") {
				header('Location:index.php',true);	
		}
	}
	?>
	<div id="loginbox">
		<?php if (!isset($_GET['admin'])) { ?>
		<p style="padding:0;margin:5%">Please Log In</p>
		<?php } else if ($_GET['admin'] == true) { ?>
		<p style="padding:0;margin:5%">Please Enter Admin Password</p>
		<?php } ?>
		<form method="post" id="loginform">
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
			header('Location:index.php',true);	
	} else if ($_POST["pass"] == $loginResult["admin"]) {
		setcookie("slogin", "admin");
		//redirect
			header('Location:admin.php',true);	
	}
}
?>
</body>
</html>