<?php
	global $boutique_active_plugin_name;
	$i = 0;
	$et_is_blog_category = false;
	$boutique_active_plugin_name = boutique_active_plugin();

	if ( is_home() && 'wp_ecommerce' == $boutique_active_plugin_name ) {
		$et_home_query = new WP_Query( array(
			'posts_per_page' 	=> (int) et_get_option( 'boutique_homepage_posts', '6' ),
			'post_type'			=> 'wpsc-product',
			'paged'				=> get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'tax_query'			=> array(
				array(
					'taxonomy' => 'wpsc_product_category',
					'field' => 'id',
					'terms' => et_get_option( 'boutique_exlcats_recent' ),
					'operator' => 'NOT IN',
				)
			)
		) );
	}

	if ( is_category() ) {
		$et_blog_categories = get_option('boutique_blog_categories');
		if ( 'wp_ecommerce' == $boutique_active_plugin_name || ( $et_blog_categories !== false && in_array( $cat, $et_blog_categories ) ) ) $et_is_blog_category = true;
	}
?>
<?php
if ( isset( $et_home_query ) ) {
	if ($et_home_query->have_posts()) : while ($et_home_query->have_posts()) : $et_home_query->the_post();
		$i++;
		if ( $et_is_blog_category ) boutique_display_blogpost();
		else boutique_display_product($i,'entry');
	endwhile;
		if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { get_template_part('includes/navigation','entry'); }
	else:
		get_template_part('includes/no-results','entry');
	endif;
} else {
	if (have_posts()) : while (have_posts()) : the_post();
		$i++;
		if ( $et_is_blog_category ) boutique_display_blogpost();
		else boutique_display_product($i,'entry');
	endwhile;
		if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { get_template_part('includes/navigation','entry'); }
	else:
		get_template_part('includes/no-results','entry');
	endif;
}

if ( is_home() && 'wp_ecommerce' == $boutique_active_plugin_name ) {
	wp_reset_postdata();
} ?>