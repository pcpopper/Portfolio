<?php
require '../secure/connection.php';
$dbconn = pg_connect(CONNSTRING) or die ('Cannot connect: ' . pg_last_error());

function printPost($title, $body, $date) {
?>
<div id="holder">
	<div id="title"><h2><?php echo $title ?></h2></div>
	<div id="body"><?php echo $body ?></div>
	<div id="date">Last updated: <?php echo $date ?></div>
</div>
<script>clickHandlers();</script>
<?php
}

if ($_GET['id'] == 0) {
	$pages_query = "SELECT * FROM ".SCHEMA."posts ORDER BY date_updated DESC LIMIT 3";
} else {
	$pages_query = "SELECT * FROM ".SCHEMA."posts WHERE page_id = " . $_GET['id'] . " ORDER BY date_updated DESC";
}
$pages_result = pg_query($pages_query) or die('Query failed: ' . pg_last_error());

if (pg_num_rows($pages_result) == 0) {
	$title = "Error: 404 Not Found!";
	$body = "<h3>I am sorry, this page is a Schrödinger's page, either it exists or it doesn't.</h3><p>Unfortunately, due to either poor programming or bad database upkeep, you are looking at an unopened box.</p>";
	$date = "2014-11-25 13:13:36";
	printPost($title, $body, $date);
} else {
	while ($pages_line = pg_fetch_array($pages_result, null, PGSQL_BOTH)) {
		$title = htmlspecialchars_decode($pages_line[1]);
		$body = htmlspecialchars_decode($pages_line[2]);
		$date = $pages_line[3];
		printPost($title, $body, $date);
	}
}

//Free resultset
pg_free_result($pages_result);

//Closing connection
pg_close($dbconn);


// $xml=simplexml_load_file("content.xml") or die("Error: Cannot create object");
// 
// foreach($xml->children() as $div) {
// 	if ($div['content'] == $_GET['content']) {
// 		foreach($div->children() as $item) {
// 		$body = $item->body;
// 		
// 		// replace vid tags
// 		$body = preg_replace('/\$\$vid=([^\s]+)=([^\s]+)=([^\s]+)\$\$/', '<center><video width="$3" controls>' . 
// 																				  '	<source src="$1" type="$2">' . 
// 																				  '	Your browser does not support the video tag.' . 
// 																				  '</video></center>', $body);
// 		// replace image tags
// 		$body = preg_replace('/\$\$img\=([^\s]+)\$\$/', '<img src="$1">', $body);
// 		
// 		// replace link tags
// 		$body = preg_replace('/\$\$link\=([^\s]+)=([^\s]+)\$\$/', '<span class="link link2" id="$1">$2</span>', $body);
// 		$body = preg_replace('/\$\'/', ' ', $body);
// 		
// 		// replace html tags
// 		$body = preg_replace('/(\##)([^\s]+)(\##)/', '<$2>', $body);
?>
<script>
// $(function () {
// 	history.pushState('', '', '?id=<?php echo $_GET['id'] ?>');
// });
</script>