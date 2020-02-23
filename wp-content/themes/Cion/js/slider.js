jQuery(function(){
	jQuery(".featured-item").hover(function() {
		jQuery(this).children(".featured-info").animate({opacity: "show"}, "slow");
	}, function() {
		jQuery(this).children(".featured-info").animate({opacity: "hide"}, "fast");
	});


		jQuery(".search-slide-button").click(function(){
	  jQuery(this).next(".search-slide").animate({opacity: "show"}, "slow");
	});

		jQuery(".search-slide .delete").click(function(){
	  jQuery(this).parent("div").animate({ opacity: "hide" }, "slow");
	});

});
jQuery(document).ready(function(){

	jQuery(".home-post-wrap2 .share").click(function(){
	  jQuery(this).next("div").slideToggle("slow");
		jQuery(this).toggleClass("active"); return false;
	});

});