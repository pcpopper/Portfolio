<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

$query = "SELECT category_id, name FROM ".SCHEMA."categories ORDER BY name ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$cats = pg_num_rows($result);
$categories = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$categories[$result_line[0]] = $result_line[1];
}

$query = "SELECT page_id, name FROM ".SCHEMA."pages ORDER BY name ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$page = pg_num_rows($result);
$pages = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$pages[$result_line[0]] = $result_line[1];
}

$query = "SELECT post_id, title FROM ".SCHEMA."posts ORDER BY title ASC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$post = pg_num_rows($result);
$posts_array = array();
while ($result_line = pg_fetch_array($result, null, PGSQL_BOTH)) {
	$posts_array[$result_line[0]] = $result_line[1];
}

//Free resultset
pg_free_result($result);
?>
			<div id="holder">
				<div id="title"><h2>Admin Portal</h2></div>
				<div id="body">
					<div id="accordion-resizer" class="ui-widget-content">
						<div id="accordion2">
							<h3 style="font: 80% 'Trebuchet MS', sans-serif;">Categories - <small><?php echo $cats ?> total</small><button class="form_button add_button" id="cat" style="float: right;">Add</button></h3>
							<div>
								<table>
									<tr>
										<th colspan="2">Actions</th>
										<th>Category Name</th>
									</tr>
<?php
foreach ($categories as $key => $value) {
	echo "\t\t\t\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t\t\t\t<td><button class=\"form_button edit_button\" type=\"cat\" id=\"$key\">Edit</button></td><td><button class=\"form_button del_button\" type=\"cat\" id=\"$key\" value=\"$value\">Delete</button></td><td width=\"100%\">$value</td>\n";
	echo "\t\t\t\t\t\t\t</tr>\n";
}
?>
								</table>
							</div>
							<h3 style="font: 80% 'Trebuchet MS', sans-serif;">Pages - <small><?php echo $page ?> total</small><button class="form_button add_button" id="pag" style="float: right;">Add</button></h3>
							<div>
								<table>
									<tr>
										<th colspan="2">Actions</th>
										<th>Policy Title</th>
									</tr>
<?php
foreach ($pages as $key => $value) {
	echo "\t\t\t\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t\t\t\t<td><button class=\"form_button edit_button\" type=\"pag\" id=\"$key\">Edit</button></td><td><button class=\"form_button del_button\" type=\"pag\" id=\"$key\" value=\"$value\">Delete</button></td><td width=\"100%\">" . htmlspecialchars_decode($value) . "</td>\n";
	echo "\t\t\t\t\t\t\t</tr>\n";
}
?>
								</table>
							</div>
							<h3 style="font: 80% 'Trebuchet MS', sans-serif;">Posts - <small><?php echo $post ?> total</small><button class="form_button add_button" id="pos" style="float: right;">Add</button></h3>
							<div>
								<table>
									<tr>
										<th colspan="2">Actions</th>
										<th>Tag Name</th>
									</tr>
<?php
foreach ($posts_array as $key => $value) {
	echo "\t\t\t\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t\t\t<td><button class=\"form_button edit_button\" type=\"pos\" id=\"$key\">Edit</button></td><td><button class=\"form_button del_button\" type=\"pos\" id=\"$key\" value=\"$value\">Delete</button></td><td width=\"100%\">$value</td>\n";
	echo "\t\t\t\t\t\t\t</tr>\n";
}
?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="date">Last updated: 30-Nov-2014 16:45:00 CST</div>
			</div>
			<script>
				$(function() {
					var heightDiff = $("#content").height() - 90;
					$("#accordion-resizer").css("height", heightDiff + "px");
					$( ".form_button" ).button();
					$( "#accordion2" ).accordion({
						collapsible: true,
						heightStyle: "fill"
					});
		
					//alert($("#body").position().top);
					$(".add_button").click(function() {
						window.location.href = '?type=' + $(this).attr('id') + '&action=add';
					});
		
					$(".edit_button").click(function() {
						window.location.href = '?type=' + $(this).attr('type') + '&action=edit&id=' + $(this).attr('id');
					});
		
					$(".del_button").click(function() {
						window.location.href = '?type=' + $(this).attr('type') + '&action=del&id=' + $(this).attr('id') + '&value=' + $(this).attr('value');
					});
				});
			</script>
			<style>
				table, tr, td, th {
					border: 1px solid #555555;
					border-collapse: collapse;
				}
				#accordion-resizer {
					border-radius: 10px;
					border: 0px;
				}
				.ui-button-text { font-size: 6pt; }
			</style>
