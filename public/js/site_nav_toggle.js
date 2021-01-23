$("#site-nav-toggle").on("click",function(e){
	e.preventDefault();
	$("#site-nav-l").toggleClass('isClick');
	$("#site-nav-toggle").toggleClass('isClick');
});