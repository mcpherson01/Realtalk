<!--Begin Scroller Articles-->
<div id="slide">

    <div id="scrollable">
		<a class="prev"></a>
        <div class="items">
            <?php query_posts("ignore_sticky_posts=1&posts_per_page=".get_option('grungemag_scroller_num'));
					while (have_posts()) : the_post();  ?>
						<div class="slide-items">
							<?php $thumb = '';
								  $width = 155;
								  $height = 123;
								  $classtext = 'no_border';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb != '') { ?>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								</a>
							<?php }; ?>
							<span class="slide-items-a">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
									<?php truncate_title(12) ?>
								</a>
							</span>
						</div>
					<?php endwhile; wp_reset_query(); ?>
            <div style="clear: both;"></div>
        </div>
        <a class="next"></a>
        <div style="clear: both;"></div>
    </div> <!-- end #scrollable -->

</div> <!-- end #slide -->
<!--End Scroller-->