<?php if (!(is_single()) && get_option('basic_postinfo1') ) { ?>
	<span class="post-info">
		<?php esc_html_e('Posted','Basic') ?> <?php if (in_array('author', get_option('basic_postinfo1'))) { ?> <?php esc_html_e('by','Basic') ?> <?php the_author_posts_link(); ?><?php }; ?> <?php if (in_array('categories', get_option('basic_postinfo1'))) { ?> <?php esc_html_e('in','Basic') ?> <?php the_category(', ') ?><?php }; ?>
	</span>
	<span class="post-info2">
		<?php if (in_array('date', get_option('basic_postinfo1'))) { ?> <?php esc_html_e('on','Basic') ?> <?php the_time(get_option('basic_date_format')) ?><?php }; ?><?php if (in_array('comments', get_option('basic_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Basic'), esc_html__('1 comment','Basic'), '% '.esc_html__('comments','Basic')); ?><?php }; ?>
	</span>
<?php } elseif (is_single() && get_option('basic_postinfo2') ) { ?>
	<span class="post-info">
		<?php esc_html_e('Posted','Basic') ?> <?php if (in_array('author', get_option('basic_postinfo2'))) { ?> <?php esc_html_e('by','Basic') ?> <?php the_author_posts_link(); ?><?php }; ?> <?php if (in_array('categories', get_option('basic_postinfo2'))) { ?> <?php esc_html_e('in','Basic') ?> <?php the_category(', ') ?><?php }; ?>
	</span>
	<span class="post-info2">
		<?php if (in_array('date', get_option('basic_postinfo2'))) { ?> <?php esc_html_e('on','Basic') ?> <?php the_time(get_option('basic_date_format')) ?><?php }; ?><?php if (in_array('comments', get_option('basic_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Basic'), esc_html__('1 comment','Basic'), '% '.esc_html__('comments','Basic')); ?><?php }; ?>
	</span>
<?php }; ?>