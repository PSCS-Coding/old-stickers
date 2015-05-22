<DOCTYPE HTML>
<html>
<?php
require_once("connection.php");
?>
<head>
	<title>Admin Console</title>
<head>
<div id="all">
	<div id="container" style="max-width:680px;margin:1em auto 0;background-color:lightgrey;border-radius:15px;height:500px">
		<div id="alottedstickers" style="height:25%;width:25%;float:left;margin:20px;background-color:grey">
			<?php
			//here
			if (!empty($_POST['submitstickers'])) {
				$stmt = $db_stickers->prepare("UPDATE alottedstickers SET blackstickers = ?, greystickers = ?, whitestickers = ?");
				$stmt->bind_param('iii', $_POST['black'], $_POST['grey'], $_POST['white']);
				$stmt->execute();
				$stmt->close();	
			}
			$stickersQuery = $db_stickers->query("SELECT * FROM alottedstickers LIMIT 1");
			$stickerWeightQuery = $db_stickers->query("SELECT * FROM stickerweight LIMIT 1");
			$stickersResult = $stickersQuery->fetch_array();
			?><form method="post">
				<div id="blackdiv" class="stickerdiv">Black Stickers</div><input type="range" id="black" name="black" min="0" max="10" step="1" value="<?php echo $stickersResult['blackstickers'] ?>" oninput="updateTextInput(this.value, 'blackp');"><span id="blackp"><?php echo " " . $stickersResult['blackstickers'] ?></span><br />
				<div id="greydiv"  class="stickerdiv">Grey Stickers</div> <input type="range" id="grey"  name="grey"  min="0" max="10" step="1" value="<?php echo $stickersResult['greystickers']  ?>" oninput="updateTextInput(this.value, 'greyp');"><span id="greyp"><?php echo $stickersResult['greystickers'] ?></span><br />
				<div id="whitediv" class="stickerdiv">White Stickers</div><input type="range" id="white" name="white" min="0" max="10" step="1" value="<?php echo $stickersResult['whitestickers'] ?>" oninput="updateTextInput(this.value, 'whitep');"><span id="whitep"><?php echo $stickersResult['whitestickers'] ?></span><br />
				<input type="submit" name="submitstickers" value="submit">
			</form>
		</div>

		<div id="stickerweight" style="height:25%;width:25%;float:right;margin:20px;background-color:grey">
			<?php
			//here
			if (!empty($_POST['submitweight'])) {
				$stmt = $db_stickers->prepare("UPDATE alottedstickers SET blackstickers = ?, greystickers = ?, whitestickers = ?");
				$stmt->bind_param('iii', $_POST['black'], $_POST['grey'], $_POST['white']);
				$stmt->execute();
				$stmt->close();	
			}
			$stickersQuery = $db_stickers->query("SELECT * FROM alottedstickers LIMIT 1");
			$stickersResult = $stickersQuery->fetch_array();
			?><form method="post">
				<div id="blackdivW" class="stickerdiv">Black Stickers</div><input type="range" id="black" name="black" min="0" max="15" step=".5" value="<?php echo $stickersResult['blackstickers'] ?>" oninput="updateTextInput(this.value, 'blackpW');"><span id="blackpW"><?php echo " " . $stickersResult['blackstickers'] ?></span><br />
				<div id="greydivW"  class="stickerdiv">Grey Stickers</div> <input type="range" id="grey"  name="grey"  min="0" max="15" step=".5" value="<?php echo $stickersResult['greystickers']  ?>" oninput="updateTextInput(this.value, 'greypW');"><span id="greypW"><?php echo $stickersResult['greystickers'] ?></span><br />
				<div id="whitedivW" class="stickerdiv">White Stickers</div><input type="range" id="white" name="white" min="0" max="15" step=".5" value="<?php echo $stickersResult['whitestickers'] ?>" oninput="updateTextInput(this.value, 'whitepW');"><span id="whitepW"><?php echo $stickersResult['whitestickers'] ?></span><br />
				<input type="submit" name="submitweight" value="submit">
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
</style>
