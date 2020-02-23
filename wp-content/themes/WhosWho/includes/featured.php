<!--Begin Featured Section-->

<div id="featured-div">
    <!--Begin Featured Article-->
    <div id="feautred-article">
        <?php $featured_cat = get_option('whoswho_feat_cat');
			  query_posts("posts_per_page=1&cat=".get_catId($featured_cat));
			  while (have_posts()) : the_post(); ?>
					<?php $thumb = '';
						  $width = 175;
						  $height = 175;
						  $classtext = 'no_border';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb != '') { ?>
						<div class="thumbnail-div-featured">
							<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</a>
						</div>
					<?php }; ?>

					<div class="featured-content">
						<h1 class="titles-featured"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
							<?php the_title(); ?></a></h1>
						<?php truncate_post(310) ?>
						<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>"><?php esc_html_e('Read More','WhosWho')?></a></div>
					</div>
			  <?php endwhile; wp_reset_query(); ?>
    </div>
    <!--End Feautred Article-->


    <div style="float: left; margin-left: 5px; margin-top: 15px;">
        <!--Begin Random Articles-->

        <div id="scrollable">
			<span class="blue-titles"><?php esc_html_e('random posts','WhosWho')?></span>
            <div class="navi"></div>
            <a class="prev"></a>

            <div class="items">
                <?php query_posts("orderby=rand&posts_per_page=".get_option('whoswho_random_num'));
					  while (have_posts()) : the_post(); ?>
							<?php $thumb = '';
								  $width = 60;
								  $height = 60;
								  $classtext = 'no_border';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>
							<?php if($thumb != '') { ?>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								</a>
							<?php }; ?>
					  <?php endwhile; wp_reset_query(); ?>
            </div>

            <a class="next"></a>
            <div style="clear: both;"></div>
        </div> <!-- end #scrollable -->

        <img src="<?php echo get_template_directory_uri(); ?>/images/rounded-bottom.gif" alt="bottom" style="float: left;" />
        <!--End Random Articles-->
        <div style="clear: both;"></div>


        <!--Begin RSS Section-->
        <div id="scrollable2" style="margin-top: 10px;">
			<span class="blue-titles"><?php esc_html_e('subscribe to rss','WhosWho')?></span>

            <div style="width: 240px; float: left;">
                <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr(get_option('whoswho_feed')); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
                    <input name="email" type="text" style="width:140px; float: left;" id="emailer" value="<?php esc_attr_e('Subscribe via Email','WhosWho')?>"/>
                    <input type="hidden" value="<?php echo esc_attr(get_option('whoswho_feed')); ?>" name="uri"/>
                    <input type="hidden" name="loc" value="en_US"/>
                    <input type="submit" class="feedsubmit" value="<?php esc_attr_e('Subscribe','WhosWho')?>" />
                </form>
            </div>

            <a href="http://feeds2.feedburner.com/<?php echo esc_attr(get_option('whoswho_feed')); ?>"><img src="http://feeds2.feedburner.com/~fc/<?php echo esc_attr(get_option('whoswho_feed')); ?>?bg=99CCFF&amp;fg=444444&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a>
            <div style="float: left; margin-top: 5px; width: 100%;"> <a href="<?php bloginfo('rss2_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.gif" alt="rss" style="border: none; margin-right: 8px; margin-bottom: -4px;" />RSS 2.0 </a> <a href="<?php bloginfo('atom_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.gif" alt="rss" style="border: none; margin-right: 8px; margin-bottom: -4px;" />Atom </a> <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.gif" alt="rss" style="border: none; margin-right: 8px; margin-bottom: -4px;" />Comments RSS</a> <a href="<?php bloginfo('rdf_url'); ?>" rel="bookmark" title="RSS"> <img src="<?php echo get_template_directory_uri(); ?>/images/rss.gif" alt="rss" style="border: none; margin-right: 8px; margin-bottom: -4px;" /> RSS/RDF 1.0</a> </div>
            <div style="clear: both;"></div>
        </div> <!-- end #scrollable2 -->
        <img src="<?php echo get_template_directory_uri(); ?>/images/rounded-bottom.gif" alt="bottom" style="float: left;" />
        <!--End RSS Section-->

    </div>
    <div style="clear: both;"></div>

</div>
<!--End Feautred Section-->