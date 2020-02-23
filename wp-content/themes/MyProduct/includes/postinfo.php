<?php if (is_page() || is_category()) { ?>
	<?php $tagline = get_post_meta($post->ID, 'Tagline', $single = true);
		  if (is_category()) $tagline = category_description();
		  if ($tagline <> '') {	?>
				<p class="tagline">
					<?php echo wp_kses( $tagline, array( 'span' => array() ) ); ?>
				</p>
		  <?php }; ?>
<?php } elseif (is_single() && get_option('myproduct_postinfo2') ) { ?>
<?php
	global $query_string;
	$new_query = new WP_Query($query_string);
	while ( $new_query->have_posts() ) : $new_query->the_post();
?>
		<p class="tagline">
			<span><?php esc_html_e('Posted','MyProduct'); ?> <?php if (in_array('author', get_option('myproduct_postinfo2'))) { ?> <?php esc_html_e('by','MyProduct'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('myproduct_postinfo2'))) { ?> <?php esc_html_e('on','MyProduct'); ?> <?php the_time(get_option('myproduct_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('myproduct_postinfo2'))) { ?> <?php esc_html_e('in','MyProduct'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('myproduct_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','MyProduct'), esc_html__('1 comment','MyProduct'), '% '.esc_html__('comments','MyProduct')); ?><?php }; ?></span>
		</p>
<?php
	endwhile; wp_reset_postdata();
?>
<?php }; ?>