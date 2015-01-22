<?php
function get_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

function makeTable($name) {
?>
							<table width="100%">
								<tr>
									<th colspan="2">Actions</th>
									<th>Filename</th>
									<th>File Type</th>
									<th><nobr>File Size</nobr></th>
								</tr>
<?php
	// print_r($_SERVER);
	$dir = opendir("../uploads/" . $name);
	while (false !== ($filename = readdir($dir))) {
		$files[] = $filename;
	}

	$root = "../uploads/$name/";
	sort($files);
	
	if (count($files) > 2) {
		foreach ($files as $file) {
			if (strpos($file, '.') !== (int) 0) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				echo "\t\t\t\t\t\t\t\t<tr>\n" . 
					 "\t\t\t\t\t\t\t\t\t<td width=\"50\"><button onclick=\"toggleFileCommands('rename', '$file', '" . finfo_file($finfo, $root . $file) . "');\" class=\"form_button rename_button\" id=\"$file\">Rename</button></td>\n" . 
					 "\t\t\t\t\t\t\t\t\t<td width=\"50\"><button onclick=\"toggleFileCommands('remove', '$file', '" . finfo_file($finfo, $root . $file) . "');\" class=\"form_button del_button\" id=\"$file\">Delete</button></td>\n" . 
					 "\t\t\t\t\t\t\t\t\t<td>$file</td>\n" . 
					 "\t\t\t\t\t\t\t\t\t<td width=\"50\">" . finfo_file($finfo, $root . $file) . "</td>\n" . 
					 "\t\t\t\t\t\t\t\t\t<td width=\"50\">" . get_filesize(filesize($root . $file)) . "</td>\n" . 
					 "\t\t\t\t\t\t\t\t</tr>\n";
				finfo_close($finfo);
			}
		}
	} else {
			echo "\t\t\t\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t\t\t\t<td colspan=\"3\" align=\"center\">There are currently no $name files uploaded</td>\n";
	}		echo "\t\t\t\t\t\t\t\t</tr>\n";
	
	echo "\t\t\t\t\t\t\t</table>\n";
}
?>
			<div id="holder">
				<div id="title"><h2>Manage Uploads</h2></div>
				<div id="body">
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1">Audio</a></li>
							<li><a href="#tabs-2">Images</a></li>
							<li><a href="#tabs-3">Videos</a></li>
						</ul>
						<div id="tabs-1">
<?php makeTable("video"); ?>
						</div>
						<div id="tabs-2">
<?php makeTable("image"); ?>
						</div>
						<div id="tabs-3">
<?php makeTable("video"); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="popup_rn" style="background: #000000 url('../styles/jquery-ui-1.11.2.custom/images/ui-bg_loop_25_000000_21x21.png') 50% 50% repeat; color: white;">
				<div id="title" style="border: 2px solid #555555;"><big><big><b>Rename File</b></big></big></div>
				<div id="rename">
					<center>
						<input type="text" id="new_name" style="width: 300px; border: 2px solid #555555;"><span style="font-size: 15pt">.mp4</span><br>
						<button type="button" id="rename_button">Rename file</button>
					</center>
				</div>
				<div id="rename_response" style="align: center;"></div>
			</div>
			<div id="popup_rm" style="background: #000000 url('../styles/jquery-ui-1.11.2.custom/images/ui-bg_loop_25_000000_21x21.png') 50% 50% repeat; color: white;">
				<div id="title" style="border: 2px solid #555555;"><big><big><b>Remove File</b></big></big></div>
				<div id="remove">
					<center>
						<span style="font-size: 15pt" id="remove_text"></span><br>
						<button type="button" id="remove_button">Remove file</button>
					</center>
				</div>
				<div id="remove_response" style="align: center;"></div>
			</div>
			<script>
				$(function () {
					$( "#tabs" ).tabs();
					$( ".form_button" ).button();
				});
				
				$(document).mouseup(function (e) {
					var container = $("#popup_rn");
					
					if (!container.is(e.target) // if the target of the click isn't the container...
						&& container.has(e.target).length === 0) // ... nor a descendant of the container
					{
						container.hide();
					}
					
					var container = $("#popup_rm");
					
					if (!container.is(e.target) // if the target of the click isn't the container...
						&& container.has(e.target).length === 0) // ... nor a descendant of the container
					{
						container.hide();
					}
				});
				
				function toggleFileCommands (action, file, file_type) {
					if (action == "rename") {
						var popup = $('#popup_rn');
						var container = $('#rename');
						var response = $('#rename_response')
						var button = $('#rename_button')
						
						$('#new_name').val(file.replace(/\.[^/.]+$/, ""));
					} else {
						var popup = $('#popup_rm');
						var container = $('#remove');
						var response = $('#remove_response')
						var button = $('#remove_button')
						
						$('#remove_text').html("Are you sure that you want to remove " + file + "?");
					}
					
					popup.fadeToggle();
					response.hide();
					container.show();
					button.button();
					button.click( function () {
						// Ajax formula
						var xmlhttp;
						if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						} else {// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function() {
							if (xmlhttp.readyState==4 && xmlhttp.status==200) {
									response.html(xmlhttp.responseText);
									popup.delay(1500).fadeOut();
								if (xmlhttp.responseText.substring(0,7) == "Congrat") {
									location.reload();
								}
								container.hide();
								response.show();
							}
						}
						if (action == "rename") {
							xmlhttp.open("GET", "includes/files.php?action=" + action + "&file=" + file + "&file_new=" + $('#new_name').val() + "&file_type=" + file_type, true);
						} else {
							xmlhttp.open("GET", "includes/files.php?action=" + action + "&file=" + file + "&file_type=" + file_type, true);
						}
						xmlhttp.send();
					});
				}
			</script>
			<style>
				.ui-button-text { font-size: 6pt; }
				table, tr, td, th {
					border: 2px solid #555555;
					border-collapse: collapse;
					padding: 5px;
				}
			</style>
