<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}
?>
			<div id="holder">
				<div id="title"><h2>Admin Portal</h2></div>
				<div id="body">
<?php
switch ($_GET['action']) {
	case "add":
		require "form_add.php";
		$date = "2-Dec-2014 14:19:58 CST";
		break;
	case "del":
		require "form_delete.php";
		$date = "2-Dec-2014 14:49:20 CST";
		break;
	case "edit":
		require "form_edit.php";
		$date = "2-Dec-2014 11:31:12 CST";
		break;
}
?>
				</div>
				<div id="date">Last updated: <?php echo $date ?></div>
			</div>
