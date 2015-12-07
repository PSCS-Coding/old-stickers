<DOCTYPE HTML>
<html>
<?php
require_once("connection.php");

if (!isset($_COOKIE['slogin'])) {
			header('Location:login.php',true);
} else if ($_COOKIE['slogin'] != "admin" || $_COOKIE['slogin'] != "value") {
			header('Location:login.php?admin=true',true);
}
?>
<head>
	<title>Admin Console</title>
<head>
<div id="all">
	<div id="container" style="max-width:800px;margin:1em auto 0;background-color:lightgrey;border-radius:15px;height:500px">
		<p id="allottedtext">Allotted Stickers</p>
		<div id="allottedstickers">
			<?php
			//here
			if (!empty($_POST['submitstickers'])) {
				$stmt = $db_stickers->prepare("UPDATE allottedstickers SET blackstickers = ?, greystickers = ?, whitestickers = ?");
				$stmt->bind_param('iii', $_POST['blackAllotted'], $_POST['greyAllotted'], $_POST['whiteAllotted']);
				$stmt->execute();
				$stmt->close();	
			}
			$stickersQuery = $db_stickers->query("SELECT * FROM allottedstickers LIMIT 1");
			$stickersResult = $stickersQuery->fetch_array();
			?><form name="stickerform" method="post">
				<div class="rangecontent">
				<div id="blackdiv" class="stickerdiv">Black Stickers</div><input type="range" id="black" class="ranged" name="blackAllotted" min="0" max="10" step="1" value="<?php echo $stickersResult['blackstickers'] ?>" oninput="updateTextInput(this.value, 'blackS');"><span class="label" id="blackS"><?php echo " " . $stickersResult['blackstickers'] ?></span><br /><br />
				<div id="greydiv"  class="stickerdiv">Grey Stickers</div> <input type="range" id="grey"  class="ranged" name="greyAllotted"  min="0" max="10" step="1" value="<?php echo $stickersResult['greystickers']  ?>" oninput="updateTextInput(this.value, 'greyS');"><span class="label" id="greyS"><?php echo $stickersResult['greystickers'] ?></span><br /><br />
				<div id="whitediv" class="stickerdiv">White Stickers</div><input type="range" id="white" class="ranged" name="whiteAllotted" min="0" max="10" step="1" value="<?php echo $stickersResult['whitestickers'] ?>" oninput="updateTextInput(this.value, 'whiteS');"><span class="label" id="whiteS"><?php echo $stickersResult['whitestickers'] ?></span><br /><br />
				<input type="submit" name="submitstickers" value="submit">
				</div>
			</form>
		</div>
		
		<p id="weighttext">Sticker Weight</p>
		<div id="stickerweight">
			<?php
			//sticker weight
			if (!empty($_POST['submitweight'])) {
				$stmt = $db_stickers->prepare("UPDATE stickerweight SET blackvalue = ?, greyvalue= ?, whitevalue = ?");
				$stmt->bind_param('ddd', $_POST['blackWeight'], $_POST['greyWeight'], $_POST['whiteWeight']);
				$stmt->execute();
				$stmt->close();	
			}
			$weightQuery = $db_stickers->query("SELECT * FROM stickerweight LIMIT 1");
			$weightResult = $weightQuery->fetch_array();
			?><form name="weightform" method="post">
				<div class="rangecontent">
				<div id="blackdivW" class="stickerdiv">Black Stickers</div><input type="range" id="black" class="ranged" name="blackWeight" min="0" max="15" step=".5" value="<?php echo $weightResult['blackvalue'] ?>" oninput="updateTextInput(this.value, 'blackW');"><span id="blackW" class="label"><?php echo " " . $weightResult['blackvalue'] ?></span><br /><br />
				<div id="greydivW"  class="stickerdiv">Grey Stickers</div> <input type="range" id="grey"  class="ranged" name="greyWeight"  min="0" max="15" step=".5" value="<?php echo $weightResult['greyvalue']  ?>" oninput="updateTextInput(this.value, 'greyW');"><span id="greyW" class="label"><?php echo $weightResult['greyvalue'] ?></span><br /><br />
				<div id="whitedivW" class="stickerdiv">White Stickers</div><input type="range" id="white" class="ranged" name="whiteWeight" min="0" max="15" step=".5" value="<?php echo $weightResult['whitevalue'] ?>" oninput="updateTextInput(this.value, 'whiteW');"><span id="whiteW" class="label"><?php echo $weightResult['whitevalue'] ?></span><br /><br />
				<input type="submit" name="submitweight" value="submit">
				</div>
			</form>
		</div>
	</div>
</div>
</html>
<script>
function updateTextInput(val, span) {
document.getElementById(span).innerHTML = val;
    }
</script>
<style>
* {
font-family:sans-serif;
}
#allottedtext {
}
#weighttext {
}
#stickerweight {
height:25%;
width:45%;
float:left;
margin:20px;
background-color:#A5A5A5
}
#allottedstickers {
width:45%;
height:25%;
float:left;
margin:20px;
background-color:#A5A5A5;
}

.ranged {
float:right;
}
.label {
margin-left:5%;
font-weight:bold;
text-align:center;
}
.stickerdiv {
height:20px;
width:110px;
text-align:center;
border-radius:5px;
display:inline-block;
}
#blackdiv {
background-color:black;
color:white;
}
#blackdivW {
background-color:black;
color:white;
}
#greydiv {
background-color:grey;
color:white;
}
#greydivW {
background-color:grey;
color:white;
}
#whitediv {
background-color:white;
color:black;
border: 1px solid;
}
#whitedivW {
background-color:white;
color:black;
border: 1px solid;
}
.rangecontent {
margin: 3%;
}
</style>
