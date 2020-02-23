<!--Begin Random Articles-->
<span class="headings"><?php esc_html_e('random articles','GrungeMag'); ?></span>
<div style="clear: both;"></div>
<ul>
	<?php query_posts("orderby=rand&posts_per_page=".get_option('grungemag_random_num'));
	while (have_posts()) : the_post(); ?>
		<li>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
				<?php truncate_title(40); ?>
			</a>
		</li>
	<?php endwhile; wp_reset_query(); ?>
</ul>
<!--End Random Articles-->