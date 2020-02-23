<?php if (!is_single() && get_option('inreview_postinfo1') ) { ?>
	<p class="featured-meta"><?php esc_html_e('Reviewed','InReview'); ?> <?php if (in_array('author', get_option('inreview_postinfo1'))) { ?> <?php esc_html_e('by','InReview'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('inreview_postinfo1'))) { ?> <?php esc_html_e('on','InReview'); ?> <?php the_time(get_option('inreview_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('inreview_postinfo1'))) { ?> <?php esc_html_e('in','InReview'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('inreview_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','InReview'), esc_html__('1 comment','InReview'), '% '.esc_html__('comments','InReview')); ?><?php }; ?></p>
<?php } elseif (is_single() && get_option('inreview_postinfo2') ) { ?>
	<p class="featured-meta">
		<?php esc_html_e('Reviewed','InReview'); ?> <?php if (in_array('author', get_option('inreview_postinfo2'))) { ?> <?php esc_html_e('by','InReview'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('inreview_postinfo2'))) { ?> <?php esc_html_e('on','InReview'); ?> <?php the_time(get_option('inreview_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('inreview_postinfo2'))) { ?> <?php esc_html_e('in','InReview'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('inreview_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','InReview'), esc_html__('1 comment','InReview'), '% '.esc_html__('comments','InReview')); ?><?php }; ?>
	</p>
<?php }; ?>