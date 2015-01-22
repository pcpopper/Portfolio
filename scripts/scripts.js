$(function() {
	// accordion maker
	var icons = {
		header: "ui-icon-circle-arrow-e",
		activeHeader: "ui-icon-circle-arrow-s"
	};
	$( "#accordion" ).accordion({
		icons: icons
	});
	$( "#toggle" ).button().click(function() {
		if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
			$( "#accordion" ).accordion( "option", "icons", null );
		} else {
			$( "#accordion" ).accordion( "option", "icons", icons );
		}
	});
});

function openWindow() {
    var prevForm = document.createElement("form");
    prevForm.target = "Preview";
    prevForm.method = "POST"; // or "post" if appropriate
    prevForm.action = "../preview.php";
	
    var prevInput = document.createElement("input");
    prevInput.type = "text";
    prevInput.name = "title";
    prevInput.value = $("#pg_title").val();
    prevForm.appendChild(prevInput);
    
    var prevTextarea = document.createElement("textarea");
    prevTextarea.name = "body";
    prevTextarea.value = $("#text").val();
    prevForm.appendChild(prevTextarea);
	
    prev = window.open("", "Preview", "menubar=no, status=no, toolbar=no");
	
	if (prev) {
		prevForm.submit();
	} else {
		alert('You must allow popups in order to preview this post.');
	}
}