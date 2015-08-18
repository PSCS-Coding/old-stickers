<?php
	function byHighest($a, $b) {
		$highestA = max(strlen($a['blackstickers']), strlen($a['greystickers']), strlen($a['whitestickers']));
		$highestB = max(strlen($b['blackstickers']), strlen($b['greystickers']), strlen($b['whitestickers']));
		return strnatcmp($highestA, $highestB);
	}
  
	function byAlpha($a, $b) {
		return strnatcmp($a["classname"],$b["classname"]);
	}
	function byFacil($a, $b) {
		return strnatcmp($a["facilitator"],$b["facilitator"]);
	}
?>