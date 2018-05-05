var jsonDB;

$(document).ready(function() {
	set_style_from_cookie()
});


var style_cookie_name = "styleSS" 
var style_cookie_duration = 30 ;
var actual_style = "blue";

function switch_style(){
	if(actual_style == "blue"){
		actual_style = "red";
	}else{
		actual_style="blue";
	}
	set_style(actual_style);
}

function set_style (css_title){
	var i, link_tag ;
	for (i = 0, link_tag = document.getElementsByTagName("link") ;
		i < link_tag.length ; i++ ) {
		if ((link_tag[i].rel.indexOf( "stylesheet" ) != -1) && link_tag[i].title) {
			link_tag[i].disabled = true ;
			if (link_tag[i].title == css_title) {
				link_tag[i].disabled = false ;
			}
		}
	}
	setCookie( style_cookie_name, css_title,style_cookie_duration);
}
function set_style_from_cookie(){
	var css_title = getCookie( style_cookie_name );
	if (css_title.length) {
		actual_style = css_title;
		set_style( css_title );
	}
}


function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}