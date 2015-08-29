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
	//border select
	document.getElementById(classid).style.border = "2px solid red";
	if (prev != null) {
		document.getElementById(prev).style.border = "initial";
	}
	prev = classid;
	
	//left
	var split = classid.split("-");
	document.getElementById("name").innerHTML = capitalize(split[0]).concat(" ",split[1],suffixes[split[1]], " slot");
	
	//right
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET","getclasses.php?slot=" + document.getElementById(classid).id,false);
	xmlHttp.send(null);
	
	if (xmlHttp.responseText != "") {
		var classes = xmlHttp.responseText.split(",");
		
		document.getElementById("classes").innerHTML = "";
		for (var i = 0; i < classes.length; i++) {
			document.getElementById("classes").innerHTML += idToName(classes[i]).concat("<br />");
		}
	} else {
		document.getElementById("classes").innerHTML = "";
	}
}
function reset () {
	console.log("connecting...");
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open( "GET", "reset_schedule.php", false );
	xmlHttp.send( null );
	console.log(xmlHttp.responseText);
}
function idToName (id) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "classconvert.php?id=" + id, false);
	xmlHttp.send(null);
	return xmlHttp.responseText;
}
function updateTimes () {
	var classSlots = document.getElementsByClassName("class");
	var days = [];
	//date object initialization (starting at 9:00)
	for (i = 0; i <	classSlots.length; i++) {
		if (!days.contains(classSlots[i].id.split("-")[0])) {
			days.push(classSlots[i].id.split("-")[0]); //add
			
			//reinitialize
			var time = new Date();
			time.setHours(9);
			time.setMinutes(0);
		}
		//add time
		classSlots[i].innerHTML = time.getHours() + ":" + addZero(time.getMinutes());

		time = addMinutes(time,classSlots[i].style.height.split("px")[0]);
	
		classSlots[i].innerHTML = classSlots[i].innerHTML + " - " + time.getHours() + ":" + addZero(time.getMinutes());
		
		//add 5 minute passing period
		time = addMinutes(time,5);
	}
}
function capitalize(s) {
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
	<div id="leftsidebar">
        <h1 id="title">Edit Slot</h1>
        <p id="name">Select a Slot</p>
		<button onclick="reset()">Reset Schedule</button>
    </div>
	<div id="rightsidebar">
        <h1 id="title">Classes</h1>
		<p id="classes">Select a slot</p>
		
		<button onclick="addclass()">Add Class</button>
		<select id="classselect">
			<option selected>Select a Class</option>
		</select>
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
<script>
	updateTimes();
</script>
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
	margin-left:35%;
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
#leftsidebar {
    position: fixed;
    top: 0%;
    left: 0%;
    width: 15%;
    height: 100%;
	opacity:0.8;
	background-color: white;
	text-align:center;
}
#rightsidebar {
    position: fixed;
    top: 0%;
    right: 0%;
    width: 15%;
    height: 100%;
	opacity:0.8;
	background-color: white;
	text-align:center;
}
</style>