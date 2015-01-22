<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

$query = "SELECT category_id, name FROM ".SCHEMA."categories ORDER BY name ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$categories = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$categories[$result_line[0]] = $result_line[1];
}

$query = "SELECT page_id, name FROM ".SCHEMA."pages ORDER BY name ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$pages = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$pages[$result_line[0]] = $result_line[1];
}

$query = "SELECT post_id, title FROM ".SCHEMA."posts ORDER BY title ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$posts = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$posts[$result_line[0]] = $result_line[1];
}

//Free resultset
pg_free_result($result);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

function makeDiv($name, $code) {
?>
		<div id="popup_<?php echo $code ?>" class="ui-widget-content">
			<div id="title" style="border: 2px solid #555555;"><big><big><b><?php echo ucfirst($name) ?></b></big></big></div>
			<table width="100%">
				<tr>
					<th>Filename</th>
					<th>File Type</th>
					<th>File Size</th>
				</tr>
<?php
	// print_r($_SERVER);
	$dir = opendir("../uploads/" . $name);
	while (false !== ($filename = readdir($dir))) {
		$files[] = $filename;
	}

	$root = "../uploads/$name/";
	sort($files);
	
	if (count($files) > 2) {
		foreach ($files as $file) {
			if (strpos($file, '.') !== (int) 0) {
				echo "\t\t\t\t<tr>\n";
				echo "\t\t\t\t\t<td>$file</td>\n";
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				echo "\t\t\t\t\t<td>" . finfo_file($finfo, $root . $file) . "</td>\n";
				finfo_close($finfo);
				echo "\t\t\t\t\t<td>" . human_filesize(filesize($root . $file)) . "</td>\n";
				echo "\t\t\t\t</tr>\n";
			}
		}
	} else {
			echo "\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t<td colspan=\"3\">There are currently no $name files uploaded</td>\n";
	}		echo "\t\t\t\t</tr>\n";
	
	echo "\t\t\t</table>\n";
	echo "\t\t</div>\n";
}
?>
		<div id="popup_cat" class="ui-widget-content">
			<div id="title" style="border: 2px solid #555555;"><big><big><b>Categories</b></big></big></div>
			<table width="100%">
				<tr>
					<th>ID</th>
					<th>Name</th>
				</tr>
<?php
foreach ($categories as $key => $value) {
	echo "\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t<td width=\"10\">$key</td><td>$value</td>\n";
	echo "\t\t\t\t</tr>\n";
}
?>
			</table>
		</div>
		<div id="popup_pag" class="ui-widget-content">
			<div id="title" style="border: 2px solid #555555;"><big><big><b>Pages</b></big></big></div>
			<table width="100%">
				<tr>
					<th>ID</th>
					<th>Name</th>
				</tr>
<?php
foreach ($pages as $key => $value) {
	echo "\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t<td width=\"10\">$key</td><td>$value</td>\n";
	echo "\t\t\t\t</tr>\n";
}
?>
			</table>
		</div>
		<div id="popup_pos" class="ui-widget-content">
			<div id="title" style="border: 2px solid #555555;"><big><big><b>Posts</b></big></big></div>
			<table width="100%">
				<tr>
					<th>ID</th>
					<th>Title</th>
				</tr>
<?php
foreach ($posts as $key => $value) {
	echo "\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t<td width=\"10\">$key</td><td>$value</td>\n";
	echo "\t\t\t\t</tr>\n";
}
?>
			</table>
		</div>
<?php
makeDiv("audio", "aud");
makeDiv("image", "img");
makeDiv("video", "vid");

if ($dbconn) {
	//Closing connection
	pg_close($dbconn);
}
?>
			<style>
				table, tr, td, th {
					border: 2px solid #555555;
					border-collapse: collapse;
					padding: 5px;
				}
			</style>
