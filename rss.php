<?php
function rss_to_array($tag, $array, $url) {
		$doc = new DOMdocument();
		$doc->load($url);
		$rss_array = array();
		$items = array();
		foreach($doc->getElementsByTagName($tag) AS $node) {	
			foreach($array AS $key => $value) {
				$items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
			}
			array_push($rss_array, $items);
		}
		return $rss_array;
	}
	
function getRss(){
$rss_tags = array(
		'title',
		'link',
		'guid',
		'comments',
		'description',
		'pubDate',
		'category',
	);
	$rss_item_tag = 'item';
	$rss_url = 'http://classes.pscs.org/feed';
	
	$rssfeed = rss_to_array($rss_item_tag,$rss_tags,$rss_url);

return $rssfeed;
}
?>
