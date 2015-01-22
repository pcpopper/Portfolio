$(function() {
	// set the click handlers
	clickHandlers();
	
// 	$(window).on("popstate", function(e) {
// 		if (e.originalEvent.state !== null) {
// 			//alert(e);
// 			//getContent();
// 		}
// 	});
});

var clickHandlers = function() {
	// Create the click handlers
	$(".link").click( function() {
		getContent($(this).attr("id"), $(this).attr("val"));
	});
	$("#logo_img").click( function() { getContent(0); });
};

var getContent = function(id, title) {
	// Ajax formula
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			//if (time == 0) { history.pushState('', '', '?id=' + id); }
			$("#content").html(xmlhttp.responseText);
			window.document.title = "Darren Eidson's Portfolio - " + title;
		}
	}
	xmlhttp.open("GET", "includes/getContent.php?id=" + id, true);
	xmlhttp.send();
};
