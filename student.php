<?php	
session_start(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Student page </title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="stickers.css">
	</head>
<body>
	<?php
	include_once("connection.php");	
	include_once("function.php");
	include_once("stickerfunctions.php");
	
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname ASC");
	
	$studentinfo = array();
	while ($student_data = $studentquery->fetch_assoc()) {
		array_push($studentinfo, $student_data);
	}
	
	if(!empty($_POST['studentselect'])){
		$_SESSION['id'] = $_POST['studentselect'];
	}
	?>
	<div class='classdata'>
	<a class="back" href="index.php">Back</a>
	<form method='post' action='<?php echo basename($_SERVER['PHP_SELF']); ?>' id='main'>
	<select name='studentselect'>
		<?php 
			foreach($studentinfo as $student){
				echo "<option value=" . $student['studentid'] . ">". $student['firstname'] . " " . substr($student['lastname'], 0, 1) . "</option>";
			}
		?>
	</select>
	<input type="submit" value="Sign In" name="submit"> 
	<?php 
		if (!empty($_SESSION['id'])){
			echo "Currently signed in as " . idToName($_SESSION['id']); 
		} else {
			echo "Please sign in";
		}
		?>
	<br>
		
	<h3> Currently Stickered Classes </h3>
	<p>
	<?php
		if(!empty($_SESSION['id'])){
		$blackstickers = getclasses($_SESSION['id'], "blackstickers");
		$greystickers = getclasses($_SESSION['id'], "greystickers");
		$whitestickers = getclasses($_SESSION['id'], "whitestickers");
		
		$stickersQuery = $db_stickers->query("SELECT * FROM allottedstickers LIMIT 1");
		$stickersResult = $stickersQuery->fetch_array();
		
		if ($stickersResult["blackstickers"] - count($blackstickers) != 0 ||
			$stickersResult["greystickers"] - count($greystickers) != 0 ||
			$stickersResult["whitestickers"] - count($whitestickers) != 0) {
			
			echo "Unused Stickers:";
		}
		
		if ($stickersResult["blackstickers"] - count($blackstickers) != 0) {
			echo "<br />" . ($stickersResult["blackstickers"] - count($blackstickers)) . " unused Black Stickers";
		}
		if ($stickersResult["greystickers"] - count($greystickers) != 0) {
			echo "<br />" . ($stickersResult["greystickers"] - count($greystickers)) . " unused Grey Stickers";
		}
		if ($stickersResult["whitestickers"] - count($whitestickers) != 0) {
			echo "<br />" . ($stickersResult["whitestickers"] - count($whitestickers)) . " unused White Stickers";
		}
		$highest = max(count($blackstickers),count($greystickers),count($whitestickers));		
		
		?>
		<table style="margin-top:0">
			<tr>
				<th class='black'>Black</th>
				<th class='grey'>Grey</th>
				<th class='white'>White</th>
			</tr>
		<?php
		for ($i = 0; $i < $highest; $i++) {
			
			?>
			
			<tr>
				<td> <?php if (!empty($blackstickers[$i])) echo "<div>" . classidToName($blackstickers[$i]) . "</div>"; ?> </td>
				<td> <?php if (!empty($greystickers[$i]))  echo "<div>" . classidToName($greystickers[$i]) . "</div>";  ?> </td>
				<td> <?php if (!empty($whitestickers[$i])) echo "<div>" . classidToName($whitestickers[$i]) . "</div>"; ?> </td> 
			</tr>
			
			<?php
		
		}
		?>
			<tfoot>
				<tr>
					<td class='black'><?php echo $stickersResult["blackstickers"] - count($blackstickers) ?> unused</td>
					<td class='grey'><?php echo $stickersResult["greystickers"] - count($greystickers) ?> unused</td>
					<td class='white'><?php echo $stickersResult["whitestickers"] - count($whitestickers) ?> unused</td>
				</tr>
			</tfoot>
		</table>
		<?php
		foreach($blackstickers as $sticker){
			echo "<div class = " . "black" . ">" . classidToName($sticker) . "</div>";
		}			

		foreach($greystickers as $sticker){
			echo "<div class = " . "grey" . ">" . classidToName($sticker) . "</div>";
		}
		
		foreach($whitestickers as $sticker){
			echo "<div class = " . "white" . ">" . classidToName($sticker) . "</div>";
		}
		}
	 ?>
	</p>
	</div>
	</form>
</body>
</html>