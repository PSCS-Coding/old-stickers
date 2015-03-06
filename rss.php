<?php
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
	
	//echo '<pre>';
	//print_r($rssfeed);

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
	foreach ($rssfeed as $child) {
		echo $child['title'] . "<br />";
}
/*$feed = 'http://classes.pscs.org/feed/';
$feed_to_array = (array) simplexml_load_file($feed);
//OR $feed_to_array = (array) new SimpleXmlElement( file_get_contents($feed) );
?> <pre> <?php
print_r($feed_to_array);
?> </pre> <?php
echo "<br /><br /><br />";
foreach($feed_to_array as $child) {
echo $child['channel']['title'];
}
*/   

/*$content = file_get_contents($feed);
add_filter('post_limits','no_limits_for_feed'); 
    $x = new SimpleXmlElement($content);

    echo "<ul>";

    foreach($x->channel->item as $entry) {
        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
    }
    echo "</ul>";
*/
?>
