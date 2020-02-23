jQuery(function() {

	jQuery.noConflict();

	jQuery('.bar a').cluetip({splitTitle: '|'});

	jQuery('ul.lamp').lavaLamp({
		fx: 'easeInOutExpo',
		speed: 800,
	});

	jQuery(".thumbnail-div .info-button").click(function(){
	  jQuery(this).prev(".info").slideToggle("slow");
		jQuery(this).toggleClass("active"); return false;
	});

	jQuery(".bar .rating").click(function(){
	  jQuery(this).prev(".ratingbox").slideToggle("slow");
		jQuery(this).toggleClass("active"); return false;
	});

	jQuery(".post-wrapper .lightboxclick").click(function(){
	  jQuery(this).prev(".lightbox").slideToggle("slow");
		jQuery(this).toggleClass("active"); return false;
	});

	jQuery(".ratingbox .delete").click(function(){
	  jQuery(this).parents(".ratingbox").animate({ opacity: "hide" }, "slow");
	});

	jQuery(".lightbox .lightboxdelete").click(function(){
	  jQuery(this).parents(".lightbox").animate({ opacity: "hide" }, "slow");
	});

	jQuery(".menu img.featured").fadeTo("fast",0.5).hover(function(){
		jQuery(this).fadeTo("fast",1);
	},function(){
		jQuery(this).fadeTo("fast",0.5);
	});

	jQuery(".menu a").hover(function() {
		jQuery(this).next("em").animate({opacity: "show", top: "-170"}, "slow");
	}, function() {
		jQuery(this).next("em").animate({opacity: "hide", top: "-180"}, "fast");
	});

});