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
	
	if (!isset($_COOKIE["slogin"])) {
		
			header('Location:login.php',true);	
		
		} else if ($_COOKIE["slogin"] == "value") {
			
			header('Location:login.php',true);
			
		}
		
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname ASC");
	
	$studentinfo = array();
	while ($student_data = $studentquery->fetch_assoc()) {
		array_push($studentinfo, $student_data);
	}
	
	if(!empty($_POST['studentselect'])){
		$_SESSION['id'] = $_POST['studentselect'];
		header("Location: index.php"); //redirect
	}
	?>
	<div class='classdata'>
	<div id='login'>
	<br />
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
			echo "<span id='name'>" . idToName($_SESSION['id']) . "</span>"; 
		} else {
			echo "<span id='name'>Please sign in</span>";
		}
		?>
	</div>
	<br>
	<p>
	<?php
	if(!empty($_SESSION['id'])){
		$blackstickers = getclasses($_SESSION['id'], "blackstickers");
		$greystickers = getclasses($_SESSION['id'], "greystickers");
		$whitestickers = getclasses($_SESSION['id'], "whitestickers");
		
		if (!(empty($blackstickers) && empty($greystickers) && empty($whitestickers))) {
		?> <h3> Currently Stickered Classes </h3> <?php
			
		$stickersQuery = $db_stickers->query("SELECT * FROM allottedstickers LIMIT 1");
		$stickersResult = $stickersQuery->fetch_array();
		
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
				<td> <?php if (!empty($blackstickers[$i])) echo "<div><a href='class.php?classid=" . $blackstickers[$i] . "'>" . classidToName($blackstickers[$i]) . "</a></div>"; ?> </td>
				<td> <?php if (!empty($greystickers[$i]))  echo "<div><a href='class.php?classid=" . $greystickers[$i] . "'>" . classidToName($greystickers[$i]) . "</a></div>";  ?> </td>
				<td> <?php if (!empty($whitestickers[$i])) echo "<div><a href='class.php?classid=" . $whitestickers[$i] . "'>" . classidToName($whitestickers[$i]) . "</a></div>"; ?> </td> 
			</tr>
			
			<?php
		
		}
		?>
			<tfoot>
				<tr>
					<td class='black'><?php echo $stickersResult["blackstickers"] - count($blackstickers) ?> unused black</td>
					<td class='grey'><?php echo $stickersResult["greystickers"] - count($greystickers) ?> unused grey</td>
					<td class='white'><?php echo $stickersResult["whitestickers"] - count($whitestickers) ?> unused white</td>
				</tr>
			</tfoot>
		</table>
		<?php
			} else {
				?> <h3> No Stickered Classes! </h3> <?php
			}
		} else {
			?> <h3> Please Sign In! </h3> <?php
		}
	 ?>
	</p>
	</div>
	</form>
</body>
</html>