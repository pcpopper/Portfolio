$(function() {
	// set the click handlers
	clickHandlers();
});

var clickHandlers = function() {
	// Create the click handlers
	$(".link").click( function() { getContent($(this).attr("id")); });
	$("#logo_img").click( function() { window.location = "../"; });
	$("#logout").click( function() { 
		getLogin("logout", "none", "none");
	});
	$("#login").click( function() { 
		getLogin("login", $("#username").val(), $("#password").val());
	});
};

var getLogin = function() {
	// Ajax formula
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			$("#content").html(xmlhttp.responseText);
		}
	}
	xmlhttp.open("POST", "required/processForm.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("func=" + arguments[0] + "&username=" + arguments[1] + "&pass=" + arguments[2]);
};

var getContent = function(content) {
	// Ajax formula
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			$("#content").html(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET", "includes/getContent.php?content=" + content, true);
	xmlhttp.send();
};
