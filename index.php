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
		<?php
		if (empty($_SESSION['id'])){
			header("Location: student.php"); /* Redirect browser */
			exit();
		}
		if (!isset($_COOKIE["slogin"])) {
		
			header('Location:login.php',true);	
		
		} else if ($_COOKIE["slogin"] == "value") {
			
			header('Location:login.php',true);
			
		}
		include_once("connection.php");
        include_once("function.php");
		include_once("stickerfunctions.php");
        include_once("sortingfunctions.php");
		
		?>
		<script>
			function updateStickers (studentid, classid, color, block) {
				if (color == 1) {
					stickercolor = "black";
				} else if (color == 2) {
					stickercolor = "grey";
				} else  if (color == 3){
					stickercolor = "white";
				}
				if (block == 1){
					block = 1;
				} else {
					block = 0;
				}
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open( "GET", "jsget.php?studentid=" + studentid + "&classid=" + classid + "&stickercolor=" + stickercolor + "&block=" + block, false );
					xmlHttp.send( null );
					console.log(xmlHttp.responseText);
				if (xmlHttp.responseText.indexOf("unstickered")>=0){
					document.getElementById(classid + "-" + color).innerHTML = '';
					if (xmlHttp.responseText.indexOf("blockunstickered")>=0) {
						state = "blockunstickered";
					} else {
						state = "unstickered";
					}
				} else if (xmlHttp.responseText.indexOf("stickered")>=0) {
					document.getElementById(classid + "-" + color).innerHTML = '✓';
					if (xmlHttp.responseText.indexOf("blockstickered")>=0) {
						state = "blockstickered";
					} else {
						state = "stickered";
					}
				} else {
					state = "not";
					
				}
				//using XML DOM NodeLists http://www.w3schools.com/dom/met_nodelist_item.asp
				if (state == "stickered") {
					//remove last remainingsticker element
					console.log(stickercolor);
					var remainingStickers = document.getElementsByClassName(stickercolor);
					
					//if no remaining stickers change remaining text
					if (remainingStickers.item(0).id == stickercolor.concat("-1")) {
						document.getElementById("remaining").innerHTML = "No Remaining Stickers";
					}
					remainingStickers.item(0).remove();
					//use 0 because element 0 in the NodeList is actually the highest ID because it goes from top to bottom http://i.imgur.com/ioGmnEr.png
				} else if (state == "unstickered") {
					//add remainingsticker element
					var sticker = document.getElementById(stickercolor.concat("list")).firstChild;
					if (sticker != null) {
						//if can clone
						sticker = sticker.cloneNode(true);
						document.getElementById(stickercolor.concat("list")).appendChild(sticker);
					} else {
						//nothing to clone, must insert
						document.getElementById(stickercolor.concat("list")).innerHTML = "<div class='".concat(stickercolor,"'>",stickercolor,"sticker</div>");
					}
				} else if (state == "blockstickered") {
					//remove last remainingsticker element
					console.log(stickercolor);
					var remainingStickers = document.getElementsByClassName("block" + stickercolor);
					
					//if no remaining stickers change remaining text
					if (remainingStickers.item(0).id == stickercolor.concat("-1")) {
						document.getElementById("remaining").innerHTML = "No Remaining Stickers";
					}
					remainingStickers.item(0).remove();
					//use 0 because element 0 in the NodeList is actually the highest ID because it goes from top to bottom http://i.imgur.com/ioGmnEr.png
				} else if (state == "blockunstickered") {
					//add remainingsticker element
					var sticker = document.getElementById("block" + stickercolor.concat("list")).firstChild;
					if (sticker != null) {
						//if can clone
						sticker = sticker.cloneNode(true);
						document.getElementById("block" + stickercolor.concat("list")).appendChild(sticker);
					} else {
						//nothing to clone, must insert
						document.getElementById("block" + stickercolor.concat("list")).innerHTML = "<div class='block".concat(stickercolor,"'>",stickercolor,"sticker</div>");
					}
				} else if (state == "not") {
					console.log("error");
				}
				//console.log(remainingStickers.item(1).id);
			}
			function sortBy (item) {
				document.cookie = "sort=".concat(item);
				
				location.reload();
			}
		</script>
    </head>
    <body>
		<form method='post' action='<?php echo basename($_SERVER['PHP_SELF']); ?>' id='main'>
        <header>
            <h2>PSCS Class Offerings</h2>
            <a class="start" href="student.php">Login</a>
			<?php if(!empty($_SESSION['id'])) echo "<a class='name'>". idToName($_SESSION['id']) . "</a>"; ?>
			<br />	
        </header>
        <?php
			
			
			//get id from session
            if(!empty($_SESSION['id'])) {
            
			echo "<a class='name' style='opacity:0.0'>http://bit.ly/1KuHmnT</a>";
		
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
		
		$getusedblock  =  $db_stickers->query("SELECT studentid,blockblackstickers,blockgreystickers,blockwhitestickers FROM usedstickers WHERE studentid=$id");
		$usedblockstickers = array();
		while($data_result = $getusedblock->fetch_row()) {
			array_push($usedblockstickers, $data_result);
		}
		$usedblockstickers = $usedblockstickers[0];
		
		if ($usedstickers[1] != 0 || $usedstickers[2] != 0 || $usedstickers[3] != 0) {
        echo "<div id='remaining-container'>";
		echo "<div id = 'remainingblock'>Remaining Stickers:</div>";
		} else {
		echo "<div id = 'remainingblock'>No Remaining Stickers</div>";
		}
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
			
			echo ("<span id='" . $stickervalue . "list'>");
			for($k=$usedstickers[$i]; $k>0; $k--){
				echo "<div class = " . $stickervalue . ">" . $stickervalue . "sticker" . "</div>";
			}
			echo ("</span>");
			
		}
		?></div><?php
		
		if ($usedblockstickers[1] != 0 || $usedblockstickers[2] != 0 || $usedblockstickers[3] != 0) {
        echo "<div id='remaining-block-container' style='float:right'>";
		echo "<div id = 'remainingblock'>Remaining Blocks:</div>";
		} else {
		echo "<div id = 'remainingblock'>No Remaining Block Stickers</div>";
		}
		for($i=1; $i<4; $i++){
			switch ($i){
				case 1:	
					$stickervalue = "blockblack";
					break;
				case 2:
					$stickervalue = "blockgrey";
					break;
				case 3:
					$stickervalue = "blockwhite";
					break;
				default:
					echo "error";
			}
			
			echo ("<span id='" . $stickervalue . "list'>");
			for($k=$usedblockstickers[$i]; $k>0; $k--){
				echo "<div class = " . $stickervalue . ">" . explode("block",$stickervalue)[1] . "sticker" . "</div>";
			}
			echo ("</span>");
            
		}
		?></div><?php
		
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
	<?php if (!empty($_COOKIE["sort"])) { echo "<br /><span class='sortbytext' style='color:white;font-weight:bold;'>Sorting by: <br>" . ucfirst($_COOKIE["sort"]) . "</span>"; }?>
        
	<table>
		<tr>
			<th onclick="sortBy('title')">Title</th>
			<th onclick="sortBy('facilitator')">Facilitator</th>
			<th onclick="sortBy('category')">Category</th>
			<th onclick="sortBy('block')">Block</th>
			<th onclick="sortBy('black')" class="stickerheader">Black Stickers</th>
			<th onclick="sortBy('grey')" class="stickerheader">Grey Stickers</th>
			<th onclick="sortBy('white')" class="stickerheader">White Stickers</th>
		</tr>
		<?php
		
		//sorting
		if (!empty($_COOKIE['sort'])) {
		switch($_COOKIE['sort']) {
			case "title":
				usort($classesresult, 'byAlpha');
				break;
			case "facilitator":
				usort($classesresult, 'byFacil');
				break;
			case "category":
				usort($classesresult, 'byCategory');
				break;
			case "block":
				usort($classesresult, 'byBlock');
				$classesresult = array_reverse($classesresult);
				break;
			
			case "black":
				usort($classesresult, 'byBlackStickers');
				break;
			case "grey":
				usort($classesresult, 'byGreyStickers');
				break;
			case "white":
				usort($classesresult, 'byWhiteStickers');
				break;
		}
		}
		
		
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
			<td class="block">
				<?php
					if($class['block'] == 0) {
						echo "";
					}
					else {
						echo "&#9733;";
					}
					if ($class['block'] == 0){
						$blockstate = 0;
					} else {
						$blockstate = 1;
					}
				?>
			</td>
			<!-- <td style="width:auto"> <?php echo $class['description']; ?> </td> -->
			<?php echo '<td id="' . $class["classid"] . '-1" style="background-color:#5F5959; text-align:center; font-family:CODE2000; color: white" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',1,' . $blockstate . ')">';
			if (strpos($class["blackstickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
			<?php echo '<td id="' . $class["classid"] . '-2" style="background-color:#A69E9E; text-align:center; font-family:CODE2000; color: #424242" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',2,' . $blockstate . ')">';
			if (strpos($class["greystickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
			<?php echo '<td id="' . $class["classid"] . '-3" style="background-color:#FFFFFF; text-align:center; font-family:CODE2000; color: black" onclick="updateStickers(' . $_SESSION["id"] . ',' . $class["classid"] . ',3,' . $blockstate . ')">';
			if (strpos($class["whitestickers"],$_SESSION["id"]	) !== false) {
				//true
				echo "✓";
			}
			echo '</td>'; ?>
		</tr>
		<?php
			}
			} else {
				echo "<a class='name'>Please Sign In</a>";
				
	    	}
		?>
	</form>
	</table>
    </body>
</html>