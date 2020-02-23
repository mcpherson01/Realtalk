
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>

<script type="text/javascript">
//<![CDATA[
	jQuery.noConflict();

	jQuery('div.container-top, div.container-bottom, div.container, div.page').css({'visibility':'visible','display':'none'});

	var $logo = jQuery("img#logo"),
		$container = jQuery("div#main-content > div"),
		$side_menu = jQuery("ul#nav");

	$container.hide().children("div.page").hide();

	$side_menu.find("> li > a").click(function(){
		var $this = jQuery(this),
			current_number = $this.parent('li').prevAll().length,
			finished = 0,
			stopAnimation = 0,
			reset = 0;

		jQuery("> li.active",$side_menu).removeClass("active").find('a img').animate({'opacity':'hide'},500);

		if ($logo.is(':visible')) {
			$logo.hide();
			jQuery('div.page:eq(' + current_number + ')').children().hide().end().show();

			$container.filter(':hidden')
			.animate({'opacity':'show'},500,function(){
				$this.parent('li').addClass("active").end().find("img").animate({'opacity':'show'},500).parent("a").removeClass("hover");
			});
		} else {
			$this.parent('li').addClass("active").end().find("img").animate({'opacity':'show'},500).parent("a").removeClass("hover");
		};

		$container
			.find('div.page:visible div.entry')
			.animate({opacity:'hide','height':'hide'},'slow',function(){
				jQuery(this).prevAll().animate({opacity:'hide','height':'hide'},'slow'); //ie6
				finished = 1;
			})
		.end()
			.find('div.page:eq(' + current_number + ')')
			.children().hide();


		var check = setInterval(function() {
			if (jQuery('div.entry:animated').size() != 0) { stopAnimation = 1; reset = 1; }
			else { stopAnimation = 0; }
		}, 50);

		var wait = setInterval(function() {
			if( finished === 1 && stopAnimation == 0 ) {
				//clearInterval(wait);
				if (reset == 1)	{
					reset = 0;
					jQuery('div.page:visible').hide();
				}

				$container
					.find('div.page:eq(' + current_number + ')')
					.show()
					.children("div.heading")
					.animate({opacity:'show','height':'show'},'slow', function(){
						jQuery(this)
							.siblings("div.entry")
							.animate({opacity:'show','height':'show'},'slow', function(){
								et_animation_finished();
							});  //animate
					});
				finished = 0;
			}
		}, 1300);


		return false;
	}).hover(function(){
   jQuery(this).stop()
      .animate({ marginRight: '-20',paddingLeft: '20'},500);

      if ( !(jQuery(this).parent('li').hasClass("active")) )
         jQuery(this).addClass('hover');
      },function(){
         jQuery(this).stop().animate({ marginRight: '0',paddingLeft: '0' },500)
         .removeClass('hover');
      }
   );

	$gallery = jQuery("div.gallery");
	$gallery.find('.gallery-caption').fadeTo(100,0.65);

	jQuery('.gallery').find('a').magnificPopup({
			type: 'image',
			removalDelay: 500,
			mainClass: 'mfp-fade',
			gallery: {
				enabled: true,
				navigateByImgClick: true
			},
			zoom: {
				enabled: true,
				duration: 500
			},
			callbacks: {
				elementParse: function( item ) {
					var image_srcs = item.el.find( 'img' ).attr( 'srcset' ),
						images_array = '' !== image_srcs && typeof image_srcs !== 'undefined' ? image_srcs.split( ',' ) : '',
						biggest_image = '' !== images_array ? images_array[images_array.length - 1] : '',
						final_image_src = '' !== biggest_image ? biggest_image.trim().split( ' ' ) : '';

					if ( '' === final_image_src ) {
						item.src = item.el.find( 'img' ).attr( 'src' );
						return;
					}
					item.src = final_image_src[0];
				}
			}
		}).find("img").fadeTo(500,0.5).hover(function(){
		jQuery(this).stop().addClass("active").fadeTo(500,1);
	},function(){
		jQuery(this).stop().removeClass("active").fadeTo(500,0.5);
	});


	function et_animation_finished(){
		jQuery('.et-tabs-content,.et-simple-slides').each( function(){
			var et_slideHeight,
				et_slidesContainer = jQuery(this).parent();

			et_slideHeight = jQuery(this).find('> div').filter(':first').innerHeight();

			if ( et_slidesContainer.hasClass('tabs-left') ) {
				var et_leftTabsHeight = et_slidesContainer.find('ul.et-tabs-control').innerHeight();
				if ( et_leftTabsHeight > et_slideHeight ) et_slideHeight = et_leftTabsHeight;
			}

			jQuery(this).animate( { 'height' : et_slideHeight }, 400 );
		} );

		jQuery('.controllers-wrapper').each( function(){
			var controllers_width = jQuery(this).innerWidth();

			jQuery(this).css({ 'margin-left' : '-' + (controllers_width / 2) + 'px' });
		} );
	}

//]]>
</script>