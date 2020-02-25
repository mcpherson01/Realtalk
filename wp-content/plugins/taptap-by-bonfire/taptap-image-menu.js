jQuery(document).ready(function (jQuery) {
'use strict';

	/* add sub-menu arrow */
	jQuery('.taptap-by-bonfire-image ul li ul').before(jQuery('<span class="taptap-image-sub-arrow"><span class="taptap-image-sub-arrow-inner"></span></span>'));

	/* accordion (top-level) */
	jQuery(".taptap-by-bonfire-image .menu > li.menu-item-has-children .taptap-image-grid-item > a").on('click', function(e) {
		e.preventDefault();
			if (false === jQuery(this).next().next().is(':visible')) {
				jQuery(this).closest(".taptap-image-sub-wrapper").parent().siblings().find(".sub-menu").slideUp(0);
				jQuery(this).siblings().find(".sub-menu").slideUp(0);
				jQuery(this).next().next().find("> li").removeClass("taptap-by-bonfire-image-sub-active");
				jQuery(this).closest(".taptap-image-sub-wrapper").parent().siblings().find("span").removeClass("taptap-submenu-active");
				jQuery(this).siblings().find("span").removeClass("taptap-submenu-active");
				jQuery(this).closest(".taptap-image-sub-wrapper").parent().siblings().removeClass("taptap-by-bonfire-image-active");
			}
			jQuery(this).next().next().slideToggle(0);
			jQuery(this).next().next().find("> li").toggleClass("taptap-by-bonfire-image-sub-active");
			jQuery(this).next().toggleClass("taptap-submenu-active");
			jQuery(this).closest(".taptap-image-sub-wrapper").parent().toggleClass("taptap-by-bonfire-image-active");
	});

	/* accordion (sub-level) */
	jQuery(".taptap-by-bonfire-image .sub-menu > li.menu-item-has-children > a").on('click', function(e) {
		e.preventDefault();
			if (false === jQuery(this).next().next().is(':visible')) {
				jQuery(this).parent().siblings().find(".sub-menu").slideUp(300);
				jQuery(this).siblings().find(".sub-menu").slideUp(300);
				jQuery(this).next().next().find("> li").removeClass("taptap-by-bonfire-image-sub-active");
				jQuery(this).parent().siblings().find("span").removeClass("taptap-submenu-active");
				jQuery(this).siblings().find("span").removeClass("taptap-submenu-active");
			}
			jQuery(this).next().next().slideToggle(300);
			jQuery(this).next().next().find("> li").toggleClass("taptap-by-bonfire-image-sub-active");
			jQuery(this).next().toggleClass("taptap-submenu-active");
	});
	
	/* close when ESC button pressed */
	jQuery(document).keyup(function(e) {
        if (e.keyCode === 27) {
            jQuery(".taptap-by-bonfire-image .menu > li").find(".sub-menu").slideUp(300);
            jQuery(".taptap-by-bonfire-image .menu li span").removeClass("taptap-submenu-active");
        }
	});
	
});