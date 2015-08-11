<?php
include_once("connection.php");

$classesQuery = $db_stickers->query("SELECT * FROM offerings ORDER BY classname ASC");
$classesResult = array();
while($class = $classesQuery->fetch_assoc()) {
	array_push($classesResult, $class);
}

	function byHighest($a, $b) {
		$highestA = max(strlen($a['blackstickers']), strlen($a['greystickers']), strlen($a['whitestickers']));
		$highestB = max(strlen($b['blackstickers']), strlen($b['greystickers']), strlen($b['whitestickers']));
		return strnatcmp($highestA, $highestB);
	}

	// sort alphabetically by name
	usort($classesResult, 'byHighest');
	$classesResult = array_reverse($classesResult);//reverse
  
	echo json_encode($classesResult)
?>
