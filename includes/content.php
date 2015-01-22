		<div id="content">
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
