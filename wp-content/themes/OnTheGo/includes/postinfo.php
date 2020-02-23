<div class="cat-meta-top"></div>
<?php if (!(is_single())) { ?>

	<p class="post-meta"><span><?php esc_html_e('Posted','OnTheGo'); ?> <?php if (in_array('author', get_option('onthego_postinfo1'))) { ?> <?php esc_html_e('by','OnTheGo'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('onthego_postinfo1'))) { ?> <?php esc_html_e('on','OnTheGo'); ?> <?php the_time(get_option('onthego_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('onthego_postinfo1'))) { ?> <?php esc_html_e('in','OnTheGo'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('onthego_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','OnTheGo'), esc_html__('1 comment','OnTheGo'), '% '.esc_html__('comments','OnTheGo')); ?><?php }; ?></span></p>

<?php } elseif (is_single()) { ?>

	<p class="post-meta"><span><?php esc_html_e('Posted','OnTheGo'); ?> <?php if (in_array('author', get_option('onthego_postinfo2'))) { ?> <?php esc_html_e('by','OnTheGo'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('onthego_postinfo2'))) { ?> <?php esc_html_e('on','OnTheGo'); ?> <?php the_time(get_option('onthego_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('onthego_postinfo2'))) { ?> <?php esc_html_e('in','OnTheGo'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('onthego_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','OnTheGo'), esc_html__('1 comment','OnTheGo'), '% '.esc_html__('comments','OnTheGo')); ?><?php }; ?></span></p>

<?php }; ?>
<div class="cat-meta-bottom"></div>