<?php
include_once("connection.php");

$lengthQuery = $db_stickers->query("SELECT * FROM schedule LIMIT 1");
$lengthResult = $lengthQuery->fetch_array();

//truncate
$stmt = $db_stickers->prepare("TRUNCATE TABLE scheduledata");
$stmt->execute();
$stmt->close();
			
//insert
foreach ($lengthResult as $name => $day) {
	if (!is_int($name)) {
		$lengths = explode(',', $lengthResult[$name]);
		foreach($lengths as $index => $sub) {
			$id = $name . "-" . $index;
			$null = "";
		
			$stmt = $db_stickers->prepare("INSERT INTO scheduledata(id,property) VALUES (?,?)");
			$stmt->bind_param('ss', $id, $null);
			$stmt->execute();
			$stmt->close();
		}
	}
}
echo "worked";
?>