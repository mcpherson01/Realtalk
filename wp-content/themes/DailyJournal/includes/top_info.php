<?php
	$et_page_title = '';
	if( is_tag() ) {
		$et_page_title = esc_html__('Posts Tagged &quot;','DailyJournal') . single_tag_title('',false) . '&quot;';
	} elseif (is_day()) {
		$et_page_title = esc_html__('Posts made in','DailyJournal') . ' ' . get_the_time('F jS, Y');
	} elseif (is_month()) {
		$et_page_title = esc_html__('Posts made in','DailyJournal') . ' ' . get_the_time('F, Y');
	} elseif (is_year()) {
		$et_page_title = esc_html__('Posts made in','DailyJournal') . ' ' . get_the_time('Y');
	} elseif (is_search()) {
		$et_page_title = esc_html__('Search results for','DailyJournal') . ' ' . get_search_query();
	} elseif (is_category()) {
		$et_page_title = single_cat_title('',false);
	} elseif (is_author()) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$et_page_title = esc_html__('Posts by ','DailyJournal') . $curauth->nickname;
	}
?>
<h1 id="page-title"><?php echo $et_page_title; ?></h1>