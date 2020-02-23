var A = jQuery.noConflict();
jQuery(function(A){
	A(".slider-link-1, .slider-link-2, .slider-link-3").hover(function(){
		A(this).animate({
			marginTop: "-10px"
		}, 250);
	}, function(){
		A(this).animate({
			marginTop: "0px"
		}, 250);
	});
});