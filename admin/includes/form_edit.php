<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

if (!isset($_GET['type']) || !isset($_GET['action']) || !isset($_GET['id'])) {
	header("location: ./");
}

if (isset($_POST['submit'])) {
	switch ($_GET['type']) {
		case "cat":
			if (preg_match("/</", $_POST['name']) > 0 || preg_match("/\;/", $_POST['name']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['name']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "update", 'UPDATE '.SCHEMA.'categories SET name = $1 WHERE category_id = $2');
			$result = pg_execute($dbconn, "update", array(htmlspecialchars($_POST['name']), $_GET['id'])) or die('Query failed: ' . pg_last_error());
			echo 'Category "' . htmlspecialchars($_POST['name']) . '" was successfully updated.';
			break;
		case "pos":
			if (preg_match("/</", $_POST['title']) > 0 || preg_match("/\;/", $_POST['title']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['title']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "update", 'UPDATE '.SCHEMA.'posts SET title = $1, body = $2, page_id = $3, date_updated = DEFAULT WHERE post_id = $4');
			$result = pg_execute($dbconn, "update", array(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['body']), $_POST['page'], $_GET['id'])) or die('Query failed: ' . pg_last_error());
			
			echo 'Post "' . htmlspecialchars($_POST['title']) . '" was successfully updated.';
			break;
		case "pag":
			if (preg_match("/</", $_POST['page']) > 0 || preg_match("/\;/", $_POST['page']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['page']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "update", 'UPDATE '.SCHEMA.'pages SET name = $1 WHERE page_id = $2');
			$result = pg_execute($dbconn, "update", array(htmlspecialchars($_POST['page']), $_GET['id'])) or die('Query failed: ' . pg_last_error());
			
			echo 'Page "' . htmlspecialchars($_POST['page']) . '" was successfully updated.';
			break;
	}

	//Free resultset
	pg_free_result($result);
} else {
?>
					<style>
						label {
							font-size: initial;
						}
						input[type=text] {
							font-size: initial;
						}
					</style>
					<div class="box">
						<div class="box_content">
							<form action="?type=<?php echo $_GET['type'] ?>&action=<?php echo $_GET['action'] ?>&id=<?php echo $_GET['id'] ?>" method="post">
<?php
	switch ($_GET['type']) {
		case "cat":
			$query = "SELECT name FROM ".SCHEMA."categories WHERE category_id = " . $_GET['id'];
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$results = pg_fetch_array($result, null, PGSQL_BOTH);
			echo "\t\t\t\t\t<p><label for=\"name\">Category Name</label> <input type=\"text\" name=\"name\" style=\"width: 200px;\" title=\"HTML and SQL not accepted\" value=\"$results[0]\"></p>\n";
			break;
		case "pos":
			$query = "SELECT title, page_id, body FROM ".SCHEMA."posts WHERE post_id = " . $_GET['id'];
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$results = pg_fetch_array($result, null, PGSQL_BOTH);
			echo "\t\t\t\t\t<p><label for=\"pg_title\" style=\"width: 100px; display:block; float:left;\">Policy Title</label> <input type=\"text\" id=\"pg_title\" name=\"title\" style=\"width: 300px;\" title=\"HTML and SQL not accepted\" value=\"$results[0]\"></p>\n";
			echo "\t\t\t\t\t<p>\n";
			echo "\t\t\t\t\t\t<label for=\"page\" style=\"width: 100px; display:block; float:left;\">Page</label></label>\n";
			echo "\t\t\t\t\t\t<select id=\"page\" name=\"page\">\n";
			
			$pages_query = "SELECT page_id, name FROM ".SCHEMA."pages ORDER BY name ASC";
			$pages_result = pg_query($pages_query) or die('Query failed: ' . pg_last_error());
			
			// print out the results
			while ($pages_line = pg_fetch_array($pages_result, null, PGSQL_BOTH)) {
				echo "\t\t\t\t\t\t\t<option value=\"$pages_line[0]\"";
				if ($pages_line[0] == $results[1]) { echo " selected"; }
				echo ">$pages_line[1]</option>\n";
			}
			
			
			echo "\t\t\t\t\t\t</select>\n";
			echo "\t\t\t\t\t</p>\n";
			echo "\t\t\t\t\t<p>\n";
			echo "\t\t\t\t\t\t<label for=\"text\" style=\"width: 100px; display:block; float:left;\">Post Text</label>\n";
			echo "\t\t\t\t\t\t<textarea id=\"text\" name=\"body\" title=\"Accepts HTML code; no SQL accepted.\" style=\"width: 784px; height: 200px;\">$results[2]</textarea>\n";
			echo "\t\t\t\t\t</p>\n";
			
			//Free resultset
			pg_free_result($pages_result);
			break;
		case "pag":
			$query = "SELECT name FROM ".SCHEMA."pages WHERE page_id = " . $_GET['id'];
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$results = pg_fetch_array($result, null, PGSQL_BOTH);
			echo "\t\t\t\t\t<p><label for=\"page\">Page Name</label> <input type=\"text\" id=\"page\" name=\"page\" style=\"width: 300px;\" title=\"HTML and SQL not accepted\" value=\"$results[0]\"></p>\n";
			break;
	}
	
	//Free resultset
	pg_free_result($result);
?>
			<p>
				<center>
<?php if ($_GET['type'] === "pos") { echo "<button type=\"button\" onclick=\"openWindow();\">Preview '$results[0]'</button>\n"; } ?>
					<input type="submit" name="submit" value="Save the changes of '<?php echo $results[0] ?>'">
				</center>
			</p>	
		</form>
	</div>
</div>
<?php
}
?>