<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

if (isset($_GET['logout'])) {
	require "logout.php";
}

date_default_timezone_set('America/Chicago');
$date = date("j-M-Y H:i:s T");

require '../secure/connection.php';
$dbconn = pg_connect(CONNSTRING) or die ('Cannot connect: ' . pg_last_error());

?>
		<div id="content">
<?php
if (!isset($_SESSION['username'])) {
	require "login.php";
} else {
	if (isset($_GET['upload'])) {
		require "upload.php";
	} else if (isset($_GET['manage_uploads'])) {
		require "manage_uploads.php";
	} else if (isset($_GET['type']) && isset($_GET['action'])) {
		require "admin_forms.php";
	} else {
		require "admin_main.php";
	}
}
?>
		</div>
		<div id="footer">
			©2014 Darren Eidson | <a href="./">Home</a>
		</div>
