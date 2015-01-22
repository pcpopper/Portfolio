<?php
session_start();
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
		<script>
			$(function() {
				// load main at start
				getContent(0, "Home");
				//var id = <?php if (isset($_GET['id'])) { echo $_GET['id']; } else { echo 1; } ?>;
				//getContent(id, id);
			});
		</script>
  	</head>
	<body>
<?php
require 'secure/connection.php';
require 'includes/header.php';
require 'includes/sidebar.php';
require 'includes/content.php';
?>
	</body>
</html>