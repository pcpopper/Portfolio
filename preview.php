<?php
header("X-XSS-Protection: 0");
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset="utf-8">
		<title>Darren Eidson's Portfolio</title>
		<link rel="stylesheet" href="styles/jquery-ui-1.11.2.custom/jquery-ui.css">
		<script src="scripts/jquery-1.11.1.min.js"></script>
		<script src="scripts/jquery-ui.js"></script>
		<script src="scripts/getContent.js"></script>
		<script src="scripts/scripts.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
  	</head>
	<body>
<?php
require 'secure/connection.php';
require 'includes/header.php';
require 'includes/sidebar.php';

date_default_timezone_set('America/Chicago');
$date = date("j-M-Y H:i:s T");
?>
		<div id="content">
			<div id="holder">
				<div id="title"><h2><?php echo $_POST['title'] ?></h2></div>
				<div id="body"><?php echo $_POST['body'] ?></div>
				<div id="date">Last updated: <?php echo $date ?></div>
			</div>
			<script>clickHandlers();</script>
		</div>
		<div id="footer">
			©2014 Darren Eidson | <a href="admin/">Admin</a>
		</div>
<?php
if ($dbconn) {
	//Closing connection
	pg_close($dbconn);
}
?>
	</body>
</html>