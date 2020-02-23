<?php if(get_option('influx_postinfo1') || get_option('influx_postinfo2') ) { ?>
	<div class="post-info">

		<?php if (!is_single() && get_option('influx_postinfo1') ) { ?>

			<?php esc_html_e('Posted','Influx'); ?> <?php if (in_array('author', get_option('influx_postinfo1'))) { ?> <?php esc_html_e('by','Influx'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('influx_postinfo1'))) { ?> <?php esc_html_e('on','Influx'); ?> <?php the_time(get_option('influx_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('influx_postinfo1'))) { ?> <?php esc_html_e('in','Influx'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('influx_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Influx'), esc_html__('1 comment','Influx'), '% '.esc_html__('comments','Influx')); ?><?php }; ?>

		<?php } elseif (is_single() && get_option('influx_postinfo2') ) { ?>

			<?php esc_html_e('Posted','Influx'); ?> <?php if (in_array('author', get_option('influx_postinfo2'))) { ?> <?php esc_html_e('by','Influx'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('influx_postinfo2'))) { ?> <?php esc_html_e('on','Influx'); ?> <?php the_time(get_option('influx_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('influx_postinfo2'))) { ?> <?php esc_html_e('in','Influx'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('influx_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Influx'), esc_html__('1 comment','Influx'), '% '.esc_html__('comments','Influx')); ?><?php }; ?>

		<?php }; ?>
	</div><!-- end .post-info -->

	<div style="clear: both;"></div>
<?php }; ?>