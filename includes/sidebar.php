<?php
$dbconn = pg_connect(CONNSTRING) or die ('Cannot connect: ' . pg_last_error());
?>
		<div id="sidebar"></div>
		<div id="accordion">
<?php
$categories_query = "SELECT category_id, name FROM ".SCHEMA."categories ORDER BY name ASC";
$categories_result = pg_query($categories_query) or die('Query failed: ' . pg_last_error());

// print out the results
$i = 1;
while ($categories_line = pg_fetch_array($categories_result, null, PGSQL_BOTH)) {
	echo "\t\t\t<h3>$categories_line[1]</h3>\n";
	
	$pages_query = "SELECT page_id, name FROM ".SCHEMA."pages WHERE category_id = $categories_line[0] ORDER BY name ASC";
	$pages_result = pg_query($pages_query) or die('Query failed: ' . pg_last_error());
	
	$i = 1;
	echo "\t\t\t<div>\n";
	while ($pages_line = pg_fetch_array($pages_result, null, PGSQL_BOTH)) {
		echo "\t\t\t\t<span class=\"link\" id=\"$pages_line[0]\" val=\"" . htmlspecialchars_decode($pages_line[1]) . "\">" . htmlspecialchars_decode($pages_line[1]) . "</span>";
		if ($i == pg_num_rows($pages_result)) {
			echo "\n";
		} else {
			echo "<br>\n";
		}
	}
	echo "\t\t\t</div>\n";
}

//Free resultset
pg_free_result($pages_result);
pg_free_result($categories_result);
?>
		</div>
