<!--Begin Random Articles-->
<span class="headings"><?php esc_html_e('random articles','Influx'); ?></span>
<div style="clear: both;"></div>
<ul>
	<?php query_posts("ignore_sticky_posts=1&orderby=rand&posts_per_page=".get_option('influx_random_num'));
	while (have_posts()) : the_post(); ?>
		<li>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
				<?php truncate_title(40); ?>
			</a>
		</li>
	<?php endwhile; wp_reset_query(); ?>
</ul>
<!--End Random Articles-->