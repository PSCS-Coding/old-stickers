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
	function byCategory($a, $b) {
		return strnatcmp($a["category"],$b["category"]);
	}
	function byBlock($a, $b) {
		return strnatcmp($a["block"],$b["block"]);
	}
	
	function byBlackStickers($a, $b) {
		$aStickers = explode(',', $a["blackstickers"]);
		if (in_array($_SESSION['id'], $aStickers)) {
			$astr = "a";
		} else {
			$astr = "b";
		}
		
		$bStickers = explode(',', $b["blackstickers"]);
		if (in_array($_SESSION['id'], $bStickers)) {
			$bstr = "a";
		} else {
			$bstr = "b";
		}
		
		return strnatcmp($astr,$bstr);
	}
	function byGreyStickers($a, $b) {
		$aStickers = explode(',', $a["greystickers"]);
		if (in_array($_SESSION['id'], $aStickers)) {
			$astr = "a";
		} else {
			$astr = "b";
		}
		
		$bStickers = explode(',', $b["greystickers"]);
		if (in_array($_SESSION['id'], $bStickers)) {
			$bstr = "a";
		} else {
			$bstr = "b";
		}
		
		return strnatcmp($astr,$bstr);
	}
	function byWhiteStickers($a, $b) {
		$aStickers = explode(',', $a["whitestickers"]);
		if (in_array($_SESSION['id'], $aStickers)) {
			$astr = "a";
		} else {
			$astr = "b";
		}
		
		$bStickers = explode(',', $b["whitestickers"]);
		if (in_array($_SESSION['id'], $bStickers)) {
			$bstr = "a";
		} else {
			$bstr = "b";
		}
		
		return strnatcmp($astr,$bstr);
	}
?>