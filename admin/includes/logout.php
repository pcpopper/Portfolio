<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("Location: ../");

?>
