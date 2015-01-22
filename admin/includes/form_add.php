<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

if (isset($_POST['submit'])) {
	switch ($_GET['type']) {
		case "cat":
			if (preg_match("/</", $_POST['name']) > 0 || preg_match("/\;/", $_POST['name']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['name']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "insert", 'INSERT INTO '.SCHEMA.'categories(name) VALUES ($1)');
			$result = pg_execute($dbconn, "insert", array(htmlspecialchars($_POST['name']))) or die('Query failed: ' . pg_last_error());
			
			echo 'Category "' . htmlspecialchars($_POST['name']) . '" was successfully added.';
			break;
		case "pos":
			if (preg_match("/</", $_POST['title']) > 0 || preg_match("/\;/", $_POST['title']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['title']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "insert", 'INSERT INTO '.SCHEMA.'posts(title, body, page_id) VALUES ($1, $2, $3)');
			$result = pg_execute($dbconn, "insert", array(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['text']), $_POST['page'])) or die('Query failed: ' . pg_last_error());
			
			echo 'Post "' . htmlspecialchars($_POST['title']) . '" was successfully added.';
			break;
		case "pag":
			if (preg_match("/</", $_POST['page']) > 0 || preg_match("/\;/", $_POST['page']) > 0) {
				die("There was an error adding \"" . htmlspecialchars($_POST['page']) . "\": HTML and SQL injection is not allowed.");
			}
			
			$result = pg_prepare($dbconn, "insert", 'INSERT INTO '.SCHEMA.'pages(name, category_id) VALUES ($1, $2)');
			$result = pg_execute($dbconn, "insert", array(htmlspecialchars($_POST['page']), $_POST['category'])) or die('Query failed: ' . pg_last_error());
			
			echo 'Page "' . htmlspecialchars($_POST['page']) . '" was successfully added.';
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
							<form action="?type=<?php echo $_GET['type'] ?>&action=<?php echo $_GET['action'] ?>" method="post">
<?php
	switch ($_GET['type']) {
		case "cat":
			echo "\t\t\t\t\t\t\t\t<p><label for=\"name\">Category Name</label> <input type=\"text\" name=\"name\" style=\"width: 300px;\" placeholder=\"HTML and SQL not accepted\" required></p>\n";
			break;
		case "pos":
			echo "\t\t\t\t\t\t\t\t<p><label for=\"pg_title\" style=\"width: 100px; display:block; float:left;\">Post Title</label> <input type=\"text\" id=\"pg_title\" name=\"title\" style=\"width: 300px;\" placeholder=\"HTML and SQL not accepted\" required></p>\n";
			echo "\t\t\t\t\t\t\t\t<p>\n";
			echo "\t\t\t\t\t\t\t\t\t<label for=\"page\" style=\"width: 100px; display:block; float:left;\">Page</label></label>\n";
			echo "\t\t\t\t\t\t\t\t\t<select id=\"page\" name=\"page\" required>\n";
			
			$query = "SELECT page_id, name FROM ".SCHEMA."pages ORDER BY name ASC";
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			
			// print out the results
			while ($line = pg_fetch_array($result, null, PGSQL_BOTH)) {
				echo "\t\t\t\t\t\t\t\t\t\t<option value=\"" . $line[0] . "\">" . $line[1] . "</option>\n";
			}
			
			echo "\t\t\t\t\t\t\t\t\t</select>\n";
			echo "\t\t\t\t\t\t\t\t</p>\n";
			echo "\t\t\t\t\t\t\t\t<p>\n";
			echo "\t\t\t\t\t\t\t\t\t<label for=\"text\" style=\"width: 100px; display:block; float:left;\">Post Text</label>\n";
			echo "\t\t\t\t\t\t\t\t\t<textarea id=\"text\" name=\"text\" placeholder=\"Accepts HTML code; no SQL accepted.\" style=\"width: 784px; height: 200px;\" required></textarea>\n";
			echo "\t\t\t\t\t\t\t\t</p>\n";
			
			//Free resultset
			pg_free_result($result);
			break;
		case "pag":
			echo "\t\t\t\t\t\t\t\t\t\t<p><label for=\"page\">Page Name</label> <input type=\"text\" id=\"page\" name=\"page\" style=\"width: 300px;\" placeholder=\"HTML and SQL not accepted\"></p>\n";
			echo "\t\t\t\t\t\t\t\t<p>\n";
			echo "\t\t\t\t\t\t\t\t\t<label for=\"category\" style=\"width: 100px; display:block; float:left;\">Category</label></label>\n";
			echo "\t\t\t\t\t\t\t\t\t<select id=\"category\" name=\"category\" required>\n";
			
			$categories_query = "SELECT category_id, name FROM ".SCHEMA."categories ORDER BY name ASC";
			$categories_result = pg_query($categories_query) or die('Query failed: ' . pg_last_error());
			
			// print out the results
			while ($categories_line = pg_fetch_array($categories_result, null, PGSQL_BOTH)) {
				echo "\t\t\t\t\t\t\t\t\t\t<option value=\"" . $categories_line[0] . "\">" . $categories_line[1] . "</option>\n";
			}
			
			//Free resultset
			pg_free_result($categories_result);
			
			echo "\t\t\t\t\t\t\t\t\t</select>\n";
			echo "\t\t\t\t\t\t\t\t</p>\n";
			break;
	}
?>
								<p>
									<center>
<?php if ($_GET['type'] === "pos") { echo "\t\t\t\t\t\t\t\t\t\t<button type=\"button\" onclick=\"openWindow();\">Preview Post</button>\n"; } ?>
										<input type="submit" name="submit" value="Add Item">
									</center>
								</p>	
							</form>
						</div>
					</div>
<?php
}
?>