<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

if (!isset($_GET['type']) || !isset($_GET['action']) || !isset($_GET['id'])) {
	header("location: ./");
}

switch ($_GET['type']) {
	case "cat":
		$result = pg_prepare($dbconn, "delete", 'DELETE FROM '.SCHEMA.'categories WHERE category_id = $1');
		break;
	case "pos":
		$result = pg_prepare($dbconn, "delete", 'DELETE FROM '.SCHEMA.'posts WHERE post_id = $1');
		break;
	case "pag":
		$result = pg_prepare($dbconn, "delete", 'DELETE FROM '.SCHEMA.'pages WHERE page_id = $1');
		break;
}
$result = pg_execute($dbconn, "delete", array($_GET['id'])) or die('Query failed: ' . pg_last_error());

echo '"' . htmlspecialchars($_GET['value']) . '" was successfully removed.';

//Free resultset
pg_free_result($result);
?>
