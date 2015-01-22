<?php
if (basename($_SERVER['PHP_SELF']) !== "index.php") {
	header("Location: ../");
}

function throwError($text) {
	echo "<script>\n" . 
		 "	$(function() {\n" . 
		 "		$(\"#diag_text\").html('$text');\n" . 
		 "		$( \"#dialog\" ).dialog( \"open\" );\n" . 
		 "		event.preventDefault();\n" . 
		 "	});\n" . 
		 "</script>\n";
}

// list of file types
$file_types = array("audio/mpeg",
					"audio/ogg",
					"audio/vnd.wave",
					"image/png",
					"image/gif",
					"image/jpeg",
					"video/mp4",
					"video/ogg",
					"video/webm"
					);
// get the max allowed upload size
$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);

if (isset($_FILES['fileToUpload'])) {
	if (in_array($_FILES['fileToUpload']['type'], $file_types)) {
		if ($_FILES['fileToUpload']['size'] < ($upload_mb * 1048576)) {
			switch (substr($_FILES['fileToUpload']['type'], 0, 5)) {
				case "audio":
					$target_dir = "../uploads/audio/";
					break;
				case "image":
					$target_dir = "../uploads/image/";
					break;
				case "video":
					$target_dir = "../uploads/video/";
					break;
			}
			
			$target_file = $target_dir . str_replace(" ", "_", basename($_FILES["fileToUpload"]["name"]));
			if (file_exists($target_file)) {
				throwError("Sorry, A file with the same name already exists.");
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "<script>" . 
						 "	alert('The file ". str_replace(" ", "_", basename($_FILES["fileToUpload"]["name"])). " has been uploaded.');" . 
						 "	window.location.replace('./');" . 
						 "</script>";
				} else {
					throwError("Sorry, there was an error uploading your file.");
				}
			}
		} else {
			throwError("Sorry, This file is bigger than the maximum allowed size.");
		}
	} else {
		throwError("Sorry, This file type is not accepted.");
	}
}

//echo $max_upload . "<br>" . $max_post . "<br>" . $memory_limit . "<br>" . $upload_mb;
?>
			<div id="holder">
				<div id="title"><h2>Upload file(s)</h2></div>
				<div id="body">
					<form action="?upload" method="post" enctype="multipart/form-data">
						<ul>
							<h3 style="margin-bottom: 0px;">Accepted file types are:</h3>
							<li>Audio: MP3, Ogg, and Wav</li>
							<li>Image: GIF, JPEG, and PNG</li>
							<li>Video: MP4, Ogg, and WebM</li>
							<h3 style="margin-bottom: 0px;">Max file size:</h3>
							<li><?php echo $upload_mb ?> mb</li>
							<h3 style="margin-bottom: 0px;">Select file to upload: <input type="file" name="fileToUpload" id="fileToUpload"></h3>
							<input type="submit" value="Upload File" name="submit">
						</ul>
					</form>
				</div>
				<div id="date">Last updated: 3-Dec-2014 09:35:09 CST</div>
			</div>
			<div id="dialog" title="Error!">
				<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						<strong>Alert:</strong> <span id="diag_text"></span></p>
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
