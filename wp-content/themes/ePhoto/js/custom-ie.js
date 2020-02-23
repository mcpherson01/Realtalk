jQuery(function(){
	jQuery(".thumbnail-div div")
	.hover(function() {
		jQuery(this).children(".sections-overlay").animate({backgroundPosition:"(-40px 0px)"}, {duration:1000});
	}, function() {
		jQuery(this).children(".sections-overlay").animate({opacity: "show", backgroundPosition:"(0px -230px)"}, {duration:1000});
	});
});