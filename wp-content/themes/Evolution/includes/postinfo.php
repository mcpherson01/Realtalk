<?php if (!is_single() && get_option('evolution_postinfo1') ) { ?>
	<div class="postmeta">
		<p>
			<span class="posted_by"><?php esc_html_e('Posted','Evolution'); ?> <?php if (in_array('author', get_option('evolution_postinfo1'))) { ?> <?php esc_html_e('by','Evolution'); ?> <?php the_author_posts_link(); ?><?php }; ?></span>
		</p>
		<p>
			<span class="posted_category"><?php if (in_array('categories', get_option('evolution_postinfo1'))) { ?> <?php the_category(', ') ?><?php }; ?></span>
		</p>
		<p>
			<?php if (in_array('date', get_option('evolution_postinfo1'))) { ?> <?php the_time(get_option('evolution_date_format')) ?><?php }; ?>
		</p>
		<p>
			<?php if (in_array('comments', get_option('evolution_postinfo1'))) { ?> <?php comments_popup_link(esc_html__('0 comments','Evolution'), esc_html__('1 comment','Evolution'), '% '.esc_html__('comments','Evolution')); ?><?php }; ?>
		</p>
	</div> <!-- end .postmeta -->
<?php } elseif (is_single() && get_option('evolution_postinfo2') ) { ?>
	<p class="meta-info"><?php esc_html_e('Posted','Evolution'); ?> <?php if (in_array('author', get_option('evolution_postinfo2'))) { ?> <?php esc_html_e('by','Evolution'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('evolution_postinfo2'))) { ?> <?php esc_html_e('on','Evolution'); ?> <?php the_time(get_option('evolution_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('evolution_postinfo2'))) { ?> <?php esc_html_e('in','Evolution'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('evolution_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Evolution'), esc_html__('1 comment','Evolution'), '% '.esc_html__('comments','Evolution')); ?><?php }; ?></p>
<?php }; ?>