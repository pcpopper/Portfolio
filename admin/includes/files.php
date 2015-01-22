<?php
if (isset($_GET['super_debug'])) {
	print_r($_GET);
	echo "<p>";
	print_r($_SERVER);
	echo "<p>";
}

$target_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, -24) . "uploads/";
switch (substr($_GET['file_type'], 0, 5)) {
	case "audio":
		$target_dir = $target_dir . "audio/";
		break;
	case "image":
		$target_dir = $target_dir . "image/";
		break;
	case "video":
		$target_dir = $target_dir . "video/";
		break;
}

if ($_GET['action'] === "rename") {
	// $exists = file_exists($target_dir . $new);
	$old = $_GET['file'];
	$new = $_GET['file_new'] . "." . pathinfo($_GET['file'], PATHINFO_EXTENSION);

	if (isset($_GET['debug']) || isset($_GET['super_debug'])) {
		echo "Old file: '$old'<br>" . 
			 "New file: '$new'<br>" . 
			 "Target dir: '$target_dir'<br>" . 
			 "New path: '" . $target_dir . $new . "'<br>" . 
			 "File exists: '$exists'<p>";
	}
	 
	if ($old == $new || file_exists($target_dir . $new)) {
		echo "The new file name already exists. Please try again.";
	} else {
		if (rename($target_dir . $old, $target_dir . $new)) {
			echo "Congratulations,<br>$old<br>was sucessfully renamed to<br>$new";
		} else {
			echo "Sorry, there was an error, try again later.";
		}
	}
} else {
	if (unlink($target_dir . $_GET['file'])) {
		echo "Congratulations, " . $_GET['file'] . " was sucessfully removed";
	} else {
		echo "Sorry, there was an error, try again later.";
	}
}
?>