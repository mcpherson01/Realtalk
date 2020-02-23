<?php global $shortname; ?>

   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scrollTo.js"></script>
   <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/serialScroll.js"></script>

   <script type="text/javascript">
   //<![CDATA[
      jQuery.noConflict();

      jQuery('ul.nav').superfish({
         delay:       300,                            // one second delay on mouseout
         animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
         speed:       'fast',                          // faster animation speed
         autoArrows:  true,                           // disable generation of arrow mark-up
         dropShadows: false                            // disable drop shadows
      });

      jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

      et_search_bar();

      if (jQuery('#blog').length) {
         jQuery('#blog').serialScroll({
            target:'.recentscroll',
            items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
            prev:'#controllers2 a#cright-arrow',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
            next:'#controllers2 a#cleft-arrow',// Selector to the 'next' button (absolute too)
            axis:'y',// The default is 'y' scroll on both ways
            duration:200,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
            force:true // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
         });
      }

      var $portfolioItem = jQuery('.item');
      $portfolioItem.find('.item-image').css('background-color','#000000');
      jQuery('.zoom-icon, .more-icon').css('opacity','0');

      $portfolioItem.hover(function(){
         jQuery(this).find('.item-image').stop(true, true).animate({top: -10}, 500).find('img.portfolio').stop(true, true).animate({opacity: 0.7},500);
         jQuery(this).find('.zoom-icon').stop(true, true).animate({opacity: 1, left: 43},400);
         jQuery(this).find('.more-icon').stop(true, true).animate({opacity: 1, left: 110},400);
      }, function(){
         jQuery(this).find('.zoom-icon').stop(true, true).animate({opacity: 0, left: 31},400);
         jQuery(this).find('.more-icon').stop(true, true).animate({opacity: 0, left: 128},400);
         jQuery(this).find('.item-image').stop(true, true).animate({top: 0}, 500).find('img.portfolio').stop(true, true).animate({opacity: 1},500);
      });

      <?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

      function et_cycle_integration(){
         var $featured = jQuery('#featured'),
            $featured_content = jQuery('#slides'),
            $controller = jQuery('#controllers'),
            $slider_control_tab = $controller.find('a.switch');

         if ($featured_content.length) {
            jQuery('div.slide .description').css({'visibility':'hidden','opacity':'0'});

         $featured_content.css( 'backgroundImage', 'none' );
         if ( $featured_content.find('.slide').length == 1 ){
            $featured_content.find('.slide').css({'position':'absolute','top':'0','left':'0'}).show();
            jQuery('#controllers-wrapper').hide();
         }

            $featured_content.cycle({
               fx: '<?php echo(get_option('deepfocus_slider_effect')); ?>',
               timeout: 0,
               speed: 700,
               cleartypeNoBg: true
            });

         var et_leftMargin = parseFloat( $featured.width()- $featured.find('#controllers-wrapper').outerWidth(true)) / 2;
         $featured.find('#controllers-wrapper').css({'left' : et_leftMargin});

            var pause_scroll = false;

         jQuery('#featured .slide').hover(function(){
            jQuery('div.slide:visible .description').css('visibility','visible').stop().animate({opacity: 1, top:43},500);
            pause_scroll = true;
         },function(){
            jQuery('div.slide:visible .description').stop().animate({opacity: 0, top:33},500,function(){
              jQuery(this).css('visibility','hidden');
            });
            pause_scroll = false;
         });
         };

         $slider_control_tab.hover(function(){
            jQuery(this).find('img').stop().animate({opacity: 1},300);
         }).mouseleave(function(){
            if (!jQuery(this).hasClass("active")) jQuery(this).find('img').stop().animate({opacity: 0.7},300);
         });


         var ordernum;

         function gonext(this_element){
            $controller.find("a.active").removeClass('active');

            this_element.addClass('active');

            ordernum = this_element.attr("rel");
            $featured_content.cycle(ordernum-1);

            //SjQuery('div.slide:visible .description').stop().animate({opacity: 0, top:33},500);

            if (typeof interval != 'undefined') {
               clearInterval(interval);
               auto_rotate();
            };
         }

         $slider_control_tab.click(function(){
            gonext(jQuery(this));
            return false;
         });


         var $nextArrow = $featured.find('a#right-arrow'),
            $prevArrow = $featured.find('a#left-arrow');

         $nextArrow.click(function(){
            var activeSlide = $controller.find('a.active').attr("rel"),
               $nextSlide = $controller.find('a.switch:eq('+ activeSlide +')');

            if ($nextSlide.length) gonext($nextSlide)
            else gonext($controller.find('a.switch:eq(0)'));

            return false;
         });

         $prevArrow.click(function(){
            var activeSlide = $controller.find('a.active').attr("rel")-2,
               $nextSlide = $controller.find('a.switch:eq('+ activeSlide +')');

            if ($nextSlide.length) gonext($nextSlide);
            else {
               var slidesNum = $slider_control_tab.length - 1;
               gonext($controller.find('a.switch:eq('+ slidesNum +')'));
            };

            return false;
         });


         <?php if (get_option('deepfocus_slider_auto') == 'on') { ?>

            auto_rotate();

            function auto_rotate(){

               interval = setInterval(function() {
                  if (!pause_scroll) $nextArrow.click();
               }, <?php echo(get_option('deepfocus_slider_autospeed')); ?>);
            }

         <?php } ?>

      };


      <!---- Search Bar Improvements ---->
      function et_search_bar(){
         var $searchform = jQuery('#menu div#search-form'),
            $searchinput = $searchform.find("input#searchinput"),
            searchvalue = $searchinput.val();

         $searchinput.focus(function(){
            if (jQuery(this).val() === searchvalue) jQuery(this).val("");
         }).blur(function(){
            if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
         });
      };

      var $footer_widget = jQuery("#footer .widget");

      if ($footer_widget.length) {
         $footer_widget.each(function (index, domEle) {
            // domEle == this
            if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
         });
      };

      jQuery(window).load(function(){
         var $single_gallery_thumb = jQuery('.gallery-thumb');
         <?php if ( 'on' != get_option('deepfocus_responsive_layout') ) { ?>
         et_cycle_integration();
       <?php } ?>

         if ($single_gallery_thumb.length) {
           var single_gallery_thumb = $single_gallery_thumb.width(),
             offset = single_gallery_thumb-434;

           if ( offset < 0 ) {
             jQuery('.gallery-thumb-bottom').css({'width':'auto','padding':'0 '+(single_gallery_thumb / 2)+'px'});

           }
           else jQuery('.gallery-thumb-bottom').css('width',offset);
         }
      });
   //]]>
   </script>
