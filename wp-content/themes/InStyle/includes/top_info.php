<?php
	$et_tagline = '';
	if( is_tag() ) {
		$et_page_title = esc_html__('Posts Tagged &quot;','InStyle') . single_tag_title('',false) . '&quot;';
	} elseif (is_day()) {
		$et_page_title = esc_html__('Posts made in','InStyle') . ' ' . get_the_time('F jS, Y');
	} elseif (is_month()) {
		$et_page_title = esc_html__('Posts made in','InStyle') . ' ' . get_the_time('F, Y');
	} elseif (is_year()) {
		$et_page_title = esc_html__('Posts made in','InStyle') . ' ' . get_the_time('Y');
	} elseif (is_search()) {
		$et_page_title = esc_html__('Search results for','InStyle') . ' ' . get_search_query();
	} elseif (is_404()) {
		$et_page_title = esc_html__('No results found','InStyle');
	} elseif (is_category()) {
		$et_page_title = single_cat_title('',false);
		$et_tagline = category_description();
	} elseif (is_author()) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$et_page_title = esc_html__('Posts by ','InStyle') . $curauth->nickname;
	} elseif ( is_single() || is_page() ) {
		$et_instyle_settings = maybe_unserialize( get_post_meta($post->ID,'et_instyle_settings',true) );
		$et_page_title = get_the_title();
		$et_tagline = isset( $et_instyle_settings['et_fs_description'] ) ? $et_instyle_settings['et_fs_description'] : '';
	}
?>
<h1 class="category-title"><?php echo wp_kses( $et_page_title, array( 'span' => array() ) ); ?></h1>
<?php if ( $et_tagline <> '' ) { ?>
	<p class="category-tagline"><?php echo wp_kses( $et_tagline, array( 'span' => array() ) ); ?></p>
<?php } ?>