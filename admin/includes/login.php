<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

function throwError() {
	echo "<script>\n" . 
		 "\t$(function() {\n" . 
		 "\t$( \"#dialog\" ).dialog( \"open\" );\n" . 
		 "\tevent.preventDefault();\n" . 
		 "});\n" . 
		 "</script>\n";
}

if (isset($_GET['doLogin']) && isset($_POST['login_u'])) {
	$query = "SELECT password FROM ".SCHEMA."users WHERE username = '" . $_POST['login_u'] . "'";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	$results = pg_fetch_array($result, null, PGSQL_BOTH);
	
	if (pg_num_rows($result) == 0) {
		throwError();
	} else {
		if (sha1(SALT . $_POST['login_p']) === $results[0]) {
			$_SESSION['username'] = htmlspecialchars($_POST['username']);
			header("Location: ./");
		} else {
			throwError();
		}
	}
	
	//Free resultset
	pg_free_result($result);
}
?>
<div id="holder">
	<div id="title"><h2>Login</h2></div>
	<div id="body">
		<center>
			<form action="?doLogin" method="post" autocomplete="false">
				<input type="text" name="login_u" style="display:none;">
				<input type="text" id="username" name="login_u" placeholder="Username" autocomplete="false" required><br>
				<input type="password" name="login_p" id="password" placeholder="Password" autocomplete="false" required><br>
				<button id="login">Login</button>
			</form>
		</center>
		<script>$( "#login" ).button();</script>
	</div>
	<div id="date">Last updated: <?php echo $date ?></div>
</div>
<div id="dialog" title="Error!">
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> The username and password combination does not exist.</p>
	</div>
</div>
</div>
<script>
$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
	]
});
</script>
