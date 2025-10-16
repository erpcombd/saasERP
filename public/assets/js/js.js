ddaccordion.init({
	headerclass: "silverheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

function collapse_sidebar(){
// var x  = document.getElementsByClassName("sidebar");
// x[0].style.width = "5%";
//  var y= document.getElementsByClassName("main_content"); 
//  y[0].style.width = "95%";
//  document.getElementById("title_text").style.display = "none";
$("#extract_sidebar").css("display", "block");
$("#collapse_sidebar").css("display", "none");
$(".sidebar").css("width", "0%");
$(".main_content").css("width", "100%");
$("#title_text").css("display", "none");
$(".submenu").css("display", "none");
$(".selected").css("border-right", "0px");
$("span").css("font-size", "10px");
$(".oe_logo_img").css("display", "none");
$("h1").css("font-size", "10px");
}
function extract_sidebar(){
// var x  = document.getElementsByClassName("sidebar");
// x[0].style.width = "5%";
//  var y= document.getElementsByClassName("main_content"); 
//  y[0].style.width = "95%";
//  document.getElementById("title_text").style.display = "none";
$("#collapse_sidebar").css("display", "block");
$("#extract_sidebar").css("display", "none");
$(".sidebar").css("width", "14%");
$(".main_content").css("width", "86%");
$("#title_text").css("display", "block");
$("span").css("font-size", "14px");
$(".oe_logo_img").css("display", "block");
$("h1").css("font-size", "18px")
}
