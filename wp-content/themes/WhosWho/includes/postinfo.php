<?php if(get_option('whoswho_postinfo1') || get_option('whoswho_postinfo2') ) { ?>
	<div class="post-info">

		<?php if (!is_single() && get_option('whoswho_postinfo1') ) { ?>

			<?php esc_html_e('Posted','WhosWho'); ?> <?php if (in_array('author', get_option('whoswho_postinfo1'))) { ?> <?php esc_html_e('by','WhosWho'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('whoswho_postinfo1'))) { ?> <?php esc_html_e('on','WhosWho'); ?> <?php the_time(get_option('whoswho_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('whoswho_postinfo1'))) { ?> <?php esc_html_e('in','WhosWho'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('whoswho_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','WhosWho'), esc_html__('1 comment','WhosWho'), '% '.esc_html__('comments','WhosWho')); ?><?php }; ?>

		<?php } elseif (is_single() && get_option('whoswho_postinfo2') ) { ?>

			<?php esc_html_e('Posted','WhosWho'); ?> <?php if (in_array('author', get_option('whoswho_postinfo2'))) { ?> <?php esc_html_e('by','WhosWho'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('whoswho_postinfo2'))) { ?> <?php esc_html_e('on','WhosWho'); ?> <?php the_time(get_option('whoswho_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('whoswho_postinfo2'))) { ?> <?php esc_html_e('in','WhosWho'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('whoswho_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','WhosWho'), esc_html__('1 comment','WhosWho'), '% '.esc_html__('comments','WhosWho')); ?><?php }; ?>

		<?php }; ?>
	</div><!-- end .post-info -->

<?php }; ?>