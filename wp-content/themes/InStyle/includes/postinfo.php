<?php if (!is_single() && get_option('instyle_postinfo1') ) { ?>
	<p class="meta-info"><span class="raquo">&raquo;</span><?php esc_html_e('Posted','InStyle'); ?> <?php if (in_array('author', get_option('instyle_postinfo1'))) { ?> <?php esc_html_e('by','InStyle'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('instyle_postinfo1'))) { ?> <?php esc_html_e('on','InStyle'); ?> <?php the_time(get_option('instyle_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('instyle_postinfo1'))) { ?> <?php esc_html_e('in','InStyle'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('instyle_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','InStyle'), esc_html__('1 comment','InStyle'), '% '.esc_html__('comments','InStyle')); ?><?php }; ?></p>
<?php } elseif (is_single() && get_option('instyle_postinfo2') ) { ?>
	<p class="meta-info"><span class="raquo">&raquo;</span>
		<?php esc_html_e('Posted','InStyle'); ?> <?php if (in_array('author', get_option('instyle_postinfo2'))) { ?> <?php esc_html_e('by','InStyle'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('instyle_postinfo2'))) { ?> <?php esc_html_e('on','InStyle'); ?> <?php the_time(get_option('instyle_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('instyle_postinfo2'))) { ?> <?php esc_html_e('in','InStyle'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('instyle_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','InStyle'), esc_html__('1 comment','InStyle'), '% '.esc_html__('comments','InStyle')); ?><?php }; ?>
	</p>
<?php }; ?>