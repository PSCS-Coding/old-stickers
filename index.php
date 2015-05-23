<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="stickers.css">    
		<script>
			
			function updateStickers (studentid, classid, color) {
				if (color == 1) {
					stickercolor = "black";
				} else if (color == 2) {
					stickercolor = "grey";
				} else {
					stickercolor = "white";
				}
				document.getElementById(classid + "-" + color).innerHTML = '✓';
				console.log(studentid);
				console.log(classid);
				console.log(stickercolor);
			}
			</script>
    </head>
    <body>
		<form method='post' action='<?php echo basename($_SERVER['PHP_SELF']); ?>' id='main'>
        <header>
            <h2>PSCS Class Offerings</h2>
            <a class="start" href="student.php">change user / login</a>
			<input type="submit" name="submit" value="Submit">
        </header>
        <?php
            include_once("connection.php");
            include_once("function.php");
			include_once("stickerfunctions.php");
            
			//get id from session
            if(!empty($_SESSION['id'])) {
                echo "<a class='name'>". idToName($_SESSION['id']) . "</a>";
            } else {
				echo "<a class='name'>Please Sign In</a>";
	    	}
		
		//if reset is true
		if(!empty($_GET['reset'])) {
			if($_GET['reset'] == 1) {
				$init = 1;
			} else {
				$init = 0;
			}
		} else {
			$init = 0;
		}
		
		if($init) {
			include_once("reset.php");
		}
		
		// QUERY OFFERINGS
		$result = $db_stickers->query("SELECT * FROM offerings");
		$classesresult = array();
		while($data_result = $result->fetch_assoc()) {
			array_push($classesresult, $data_result);
		}
		
		//insert stickers
		
		foreach($classesresult as $class){
			if(!empty($_POST[$class['classid']])){
				addsticker($_SESSION['id'], $class['classid'], $_POST[$class['classid']]);
			}
		}
		
		if(count($classesresult) == 0) {
			echo "<p style='text-align: center'>Sorry, Class offerings could not be retrieved at this time</p>";
		} else {
			// QUERY FACILITATORS
			$facget = $db_attendance->query("SELECT facilitatorname, facilitatorid FROM facilitators ORDER BY facilitatorname ASC");
			$facilitators = array();
			
			while($fac_row = $facget->fetch_row()) {
				array_push($facilitators, $fac_row[0]);
			}
		}
		// REQUERY OFFERINGS FOR TABLE
		$result = $db_stickers->query("SELECT * FROM offerings");
		$classesresult = array();
		while($data_result = $result->fetch_assoc()) {
			array_push($classesresult, $data_result);
		}
	?>
	
	<!-- RENDER TABLE -->
	<table>
		<tr>
			<th>Title</th>
			<th>Facilitator</th>
			<th>Block</th>
			<th class="stickerheader">Black Stickers</th>
			<th class="stickerheader">Grey Stickers</th>
			<th class="stickerheader">White Stickers</th>
		</tr>
		<?php
			foreach($classesresult as $class) {
		?>
		<tr>
			<td>
				<a href="class.php?classid=<?php echo $class['classid'];?>"> <?php echo $class['classname']; ?> </a>
			</td>
			<td><?php echo $class['facilitator']; ?></td>
			<td>
				<?php
					if($class['block'] == 0) {
						echo "Non-Block";
					}
					else {
						echo "Block";
					}
				?>
			</td>
			<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
			<?php echo '<td id="' . $class["classid"] . '-1" style="background-color:#5F5959;" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',1)"></td>'; ?>
			<td style="background-color:#A69E9E;"> <input type="checkbox" name = "<?php echo $class['classid']; ?>" value="<?php echo 'grey' ?>"> <?php echo $class['greystickers']; ?> </td>
			<td style="background-color:#FFFFFF;"> <input type="checkbox" name = "<?php echo $class['classid']; ?>" value="<?php echo 'white' ?>"> <?php echo $class['whitestickers']; ?> </td>
		</tr>
		<?php
			}
		?>
	</form>
	</table>
    </body>
</html>