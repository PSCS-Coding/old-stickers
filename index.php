<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
		<title> PSCS Offerings </title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="stickers.css">    
				<style>
					@font-face {
						font-family:CODE2000;
						src: url(CODE2000.TTF);
					}
				</style>
		<script>
			function updateStickers (studentid, classid, color) {
				if (color == 1) {
					stickercolor = "black";
				} else if (color == 2) {
					stickercolor = "grey";
				} else  if (color == 3){
					stickercolor = "white";
				}
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open( "GET", "jsget.php?studentid=" + studentid + "&classid=" + classid + "&stickercolor=" + stickercolor, false );
					xmlHttp.send( null );
					console.log(xmlHttp.responseText);
				if(xmlHttp.responseText.indexOf("unstickered")>=0){
					document.getElementById(classid + "-" + color).innerHTML = '';
				} else if (xmlHttp.responseText.indexOf("stickered")>=0) {
					document.getElementById(classid + "-" + color).innerHTML = '✓';
				}
				//using XML DOM NodeLists http://www.w3schools.com/dom/met_nodelist_item.asp
				var remainingStickers = document.getElementsByClassName(stickercolor);
				document.getElementById(remainingStickers.item(remainingStickers.length - 1).id).remove();
				//console.log(remainingStickers.length);
				//console.log(remainingStickers.item(1).id);
			}
		</script>
    </head>
    <body>
		<form method='post' action='<?php echo basename($_SERVER['PHP_SELF']); ?>' id='main'>
        <header>
            <h2>PSCS Class Offerings</h2>
            <a class="start" href="student.php">change user / login</a>
			<br />
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
				unset($_GET['reset']);
			} else {
				$init = 0;
			}
		} else {
			$init = 0;
		}
		
		if($init) {
			include_once("reset.php");
		}
		// render stickers for the side
		
		$id = $_SESSION['id'];
		$getused  =  $db_stickers->query("SELECT * FROM usedstickers WHERE studentid=$id");
		$usedstickers = array();
		while($data_result = $getused->fetch_row()) {
			array_push($usedstickers, $data_result);
		}
		$usedstickers = $usedstickers[0];
		
		echo "<div class = 'remaining'>Remaining:</div>";
		
		for($i=1; $i<4; $i++){
			switch ($i){
				case 1:
					$stickervalue = "black";
					break;
				case 2:
					$stickervalue = "grey";
					break;
				case 3:
					$stickervalue = "white";
					break;
				default:
					echo "error";
			}
			for($k=$usedstickers[$i]; $k>0; $k--){
				echo "<div class = " . $stickervalue . " id='white-" . $k ."'>" . $stickervalue . "sticker " . "</div>";
			}
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
	<table align="center">
		<tr>
			<th>Title</th>
			<th>Facilitator</th>
			<th>Catagories</th>
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
			<td><?php 
				if($class['category'] == "Occupational Education") {
						echo "Occupational Ed";
					}
					else {
						echo $class['category'];
					}
				?> 
			</td>
			<td>
				<?php
					if($class['block'] == 0) {
						echo "";
					}
					else {
						echo "Block";
					}
				?>
			</td>
			<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
			<?php echo '<td id="' . $class["classid"] . '-1" style="background-color:#5F5959; text-align:center; font-family:CODE2000;" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',1)">';
			if (strpos($class["blackstickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
			<?php echo '<td id="' . $class["classid"] . '-2" style="background-color:#A69E9E; text-align:center; font-family:CODE2000;" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',2)">';
			if (strpos($class["greystickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
			<?php echo '<td id="' . $class["classid"] . '-3" style="background-color:#FFFFFF; text-align:center; font-family:CODE2000;" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',3)">';
			if (strpos($class["whitestickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
		</tr>
		<?php
			}
		?>
	</form>
	</table>
    </body>
</html>