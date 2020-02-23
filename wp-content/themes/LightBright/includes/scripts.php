<?php global $shortname; ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript">
//<![CDATA[
	jQuery.noConflict();

	jQuery('ul.superfish').superfish({
		delay:       300,                            // one second delay on mouseout
		animation:   {'marginLeft':'0px',opacity:'show'},  // fade-in and slide-down animation
		speed:       'fast',                          // faster animation speed
		onBeforeShow: function(){ this.css('marginLeft','20px'); },
		autoArrows:  true,                           // disable generation of arrow mark-up
		dropShadows: false                            // disable drop shadows
	}).find('> li > ul').prepend('<span class="top-arrow"></span>');

	var pagemenuwidth = jQuery("ul.nav").width();
	var pagemleft = Math.round((804 - pagemenuwidth) / 2) + 55;
	if (pagemenuwidth < 804) jQuery("ul.nav").css('padding-left',pagemleft);

	jQuery('ul.superfish ul a').hover(function(){
		jQuery(this).parent('li').stop().animate({paddingLeft:'27px'},300);
	},function(){
		jQuery(this).parent('li').stop().animate({paddingLeft:'17px'},300);
	});

	et_search_bar();

	jQuery('#sidebar ul li a').hover(function(){
		jQuery(this).stop().animate({paddingLeft:'38px',backgroundPosition:'21px 14px'},300);
	},function(){
		jQuery(this).stop().animate({paddingLeft:'26px',backgroundPosition:'11px 14px'},300);
	});

	jQuery('.share a.arrow').click(function(){
		if (jQuery.browser.msie)
			jQuery(this).siblings('.buttons').animate({	opacity: 'toggle' }, 0, function() {
				var sharebox = jQuery(this).parent('.share-box');
				if (sharebox.hasClass('open')) sharebox.removeClass('open')
				else sharebox.addClass('open');
			});
		else
			jQuery(this).siblings('.buttons').animate({	height: 'toggle' }, 700, function() {
				var sharebox = jQuery(this).parent('.share-box');
				if (sharebox.hasClass('open')) sharebox.removeClass('open')
				else sharebox.addClass('open');
			});

		return false;
	});

	jQuery('.share .buttons a').hover(function(){
		jQuery(this).find('.tooltip').animate({	opacity: 'show', left: '39px' }, 300);
	},function(){
		jQuery(this).find('.tooltip').animate({	opacity: 'hide', left: '49px' }, 300);
	});


	<!---- Search Bar Improvements ---->
	function et_search_bar(){
		var $searchform = jQuery('#searchform1'),
			$searchinput = $searchform.find("input#searchinput"),
			searchvalue = $searchinput.val();

		$searchinput.focus(function(){
			if (jQuery(this).val() === searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
		});
	};

	<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

	<?php if ( get_option('lightbright_cufon') == 'on' ) { ?>
		Cufon.now();
	<?php }; ?>

//]]>
</script>