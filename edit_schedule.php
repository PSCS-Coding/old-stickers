<DOCTYPE HTML>
<html>
<head>
	<title>Edit Schedule</title>
	<!--<link rel="stylesheet" type="text/css" href="stickers.css">-->
</head>
<script>
var prev;
var suffixes = [' initial','st','nd','rd','th','th','th','th','th','th','th','th','th'];
function selectSlot (classid) {
	var split = classid.split("-");
	document.getElementById("name").innerHTML = capitalize(split[0]).concat(" ",split[1],suffixes[split[1]], " slot") ;
	document.getElementById(classid).style.border = "2px solid red";
	if (prev != null) {
		document.getElementById(prev).style.border = "initial";
	}
	prev = classid;
}
function reset () {
	console.log("connecting...");
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open( "GET", "reset_schedule.php", false );
	xmlHttp.send( null );
	console.log(xmlHttp.responseText);
}
function updateTimes () {
	var classSlots = document.getElementsByClassName("class");
	var days = [];
	//date object initialization (starting at 9:00)
	for (i = 0; i <	classSlots.length; i++) {
		if (days.contains(classSlots[i].id.split("-")[0])) {
			//do it
			console.log(time.getHours() + ":" + addZero(time.getMinutes()));

			time = addMinutes(time,classSlots[i].style.height.split("px")[0]);
	
			console.log(time.getHours() + ":" + addZero(time.getMinutes()));
		} else {
			days.push(classSlots[i].id.split("-")[0]); //add
			
			//reinitialize
			var time = new Date();
			time.setHours(9);
			time.setMinutes(0);
			
			console.log(time.getHours() + ":" + addZero(time.getMinutes()));

			time = addMinutes(time,classSlots[i].style.height.split("px")[0]);
	
			console.log(time.getHours() + ":" + addZero(time.getMinutes()));
		}
	}
}
function capitalize(s)
{
    return s[0].toUpperCase() + s.slice(1);
}
function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}
</script>
<?php
	include_once("connection.php");
	include_once("stickerfunctions.php");
	include_once("function.php");
?>
<body>
	<!-- Sidebar -->
	<div id="sidebar">
        <h1 id="title" onclick="updateTimes()">Edit Slot</h1>
        <p id="name">Select a Slot</p>
		<button onclick="reset()">Reset Schedule</button>
    </div>
	<div id="schedule">
	<?php
		//get slot length data
		$lengthQuery = $db_stickers->query("SELECT * FROM schedule LIMIT 1");
		$lengthResult = $lengthQuery->fetch_array();
		
		foreach ($lengthResult as $name => $day) {
			if (!is_int($name)) {
			?>	<table id=<?php echo $name ?> class="day">
					<caption><?php echo ucfirst($name) ?></caption>
					<?php
						$lengths = explode(',', $lengthResult[$name]);
						foreach($lengths as $index => $sub) {
							echo "<tr><td id=" . $name . "-" . $index . " class='class' onclick='selectSlot(this.id)' style='height:" . $sub . "'>Class</td></tr>";
							if ($index != count($lengths) - 1) { //if not last
								echo "<tr><td class='passing'>Passing Period</td></tr>";
							}
						}
					?>
				</table>
			<?php
			}
		}
		?>
	</div>
			
</body>
</html>

<style>
* {
font-family:calibri;
}
body {
background-color:dimgrey;
}
td {
	text-align:center;
}
#schedule {
	margin-left:40%;
	margin-top:5%;
}
.day {
	float:left;
	max-width:15%;
	top:0%;
}
.class {
	background-color:#A3CDD4;
}
.passing {
	background-color:azure;
}
#sidebar {
    position: fixed;
    top: 0%;
    left: 0%;
    width: 15%;
    height: 100%;
	opacity:0.8;
	background-color: white;
	text-align:center;
}
</style>