<?php if ( !is_single() && get_option('feather_postinfo1') ) { ?>
	<p class="meta-info"><?php et_postinfo_meta( get_option('feather_postinfo1'), get_option('feather_date_format'), esc_html__('0 comments','Feather'), esc_html__('1 comment','Feather'), '% ' . esc_html__('comments','Feather') ); ?></p>
<?php } elseif ( is_single() && get_option('feather_postinfo2') ) { ?>
	<p class="meta-info">
		<?php global $query_string;
		$new_query = new WP_Query($query_string);
		while ($new_query->have_posts()) $new_query->the_post(); ?>
			<?php et_postinfo_meta( get_option('feather_postinfo2'), get_option('feather_date_format'), esc_html__('0 comments','Feather'), esc_html__('1 comment','Feather'), '% ' . esc_html__('comments','Feather') ); ?>
		<?php wp_reset_postdata() ?>
	</p>
<?php }; ?>