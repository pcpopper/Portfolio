<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}
?>
		<div id="sidebar"></div>
		<div id="accordion">
			<h3>Navigation</h3>
			<div>
				<a href="./">Home</a><br>
<?php if (isset($_SESSION['username'])) { ?>
				<a href="?upload">Upload</a>
				<hr style="border-color: #555555;">
				<a href="?logout">Logout</a>
			</div>
			<h3>Popups</h3>
			<div>
				<span class="link" onmouseover="$('#popup_cat').fadeToggle();" onmouseout="$('#popup_cat').fadeToggle();">Categories</span><br>
				<span class="link" onmouseover="$('#popup_pag').fadeToggle();" onmouseout="$('#popup_pag').fadeToggle();">Pages</span><br>
				<span class="link" onmouseover="$('#popup_pos').fadeToggle();" onmouseout="$('#popup_pos').fadeToggle();">Posts</span>
			</div>
			<h3>Uploads</h3>
			<div>
				<span class="link" onmouseover="$('#popup_aud').fadeToggle();" onmouseout="$('#popup_aud').fadeToggle();">Audio</span><br>
				<span class="link" onmouseover="$('#popup_img').fadeToggle();" onmouseout="$('#popup_img').fadeToggle();">Image</span><br>
				<span class="link" onmouseover="$('#popup_vid').fadeToggle();" onmouseout="$('#popup_vid').fadeToggle();">Video</span>
				<hr style="border-color: #555555;">
				<a href="?manage_uploads">Manage</a>
<?php } ?>
			</div>
		</div>
