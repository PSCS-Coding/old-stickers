<DOCTYPE HTML>
<html>
<?php
require_once("connection.php");
?>
<head>
	<title>Admin Console</title>
<head>
	<div id="all">
		<div id="alottedstickers" style="height:25%;width:25%">
			<?php
			//here
			$stickersQuery = $db_stickers->query("SELECT * FROM alottedstickers LIMIT 1");
			$stickersResult = $stickersQuery->fetch_array();
			?><form method="post">
				<input type="range" id="black" name="black" min="0" max="10" step="1" value="<?php echo $stickersResult['blackstickers'] ?>" oninput="updateTextInput(this.value, 'blackp');"><span id="blackp"><?php echo $stickersResult['blackstickers'] ?></span><br />
				<input type="range" id="grey"  name="grey"  min="0" max="10" step="1" value="<?php echo $stickersResult['greystickers']  ?>" oninput="updateTextInput(this.value, 'greyp');"><span id="greyp"><?php echo $stickersResult['greystickers'] ?></span><br />
				<input type="range" id="white" name="white" min="0" max="10" step="1" value="<?php echo $stickersResult['whitestickers'] ?>" oninput="updateTextInput(this.value, 'whitep');"><span id="whitep"><?php echo $stickersResult['whitestickers'] ?></span>
				<input type="submit" name="submit" value="submit">
			</form>
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
</style>
