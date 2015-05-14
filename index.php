<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="stickers.css">        
    </head>
    <body>
        <header>
            <h2>PSCS Class Offerings</h2>
            <a class="start" href="student.php">change user / login</a>
        </header>
        <?php
            include_once("connection.php");
            include_once("function.php");
            
            if(!empty($_SESSION['id'])) {
                echo "<a class='name'>". idToName($_SESSION['id']) . "</a>";
            }
	    else {
		echo "<a class='name'>Please Sign In</a>";
	    }
        ?>
	<?php
		if(!empty($_GET['reset'])) {
			if($_GET['reset'] == 1) {
				$init = 1;
			}
			else {
				$init = 0;
			}
		}
		else {
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
		
		if(count($classesresult) == 0) {
			echo "<p style='text-align: center'>Sorry, Class offerings could not be retrieved at this time</p>";
		}
		else {
			// QUERY STICKERS
			$facget = $db_attendance->query("SELECT facilitatorname, facilitatorid FROM facilitators ORDER BY facilitatorname ASC");
			$facilitators = array();
			while($fac_row = $facget->fetch_row()) {
				array_push($facilitators, $fac_row[0]);
			}
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
			<td style="background-color:#5F5959;"> <input type="submit" value="Check"> <?php echo $class['blackstickers']; ?> </td>
			<td style="background-color:#A69E9E;"> <input type="submit" value="Check"> <?php echo $class['greystickers']; ?> </td>
			<td style="background-color:#FFFFFF;"> <input type="submit" value="Check"> <?php echo $class['whitestickers']; ?> </td>
		</tr>
		<?php
			}
		?>
	</table>
    </body>
</html>