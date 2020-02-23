<?php
	$arr = array();
	$i=1;

	$width = 36;
	$height = 37;

	$featured_cat = get_option('myapptheme_feat_cat');
	$featured_num = (int) get_option('myapptheme_featured_num');

	if (get_option('myapptheme_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('myapptheme_feat_pages') <> '') $featured_num = count(get_option('myapptheme_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'myapptheme_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'myapptheme_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(350,false);
		$arr[$i]["fulltitle"] = truncate_title(350,false);

		global $more;
		$more = 0;
		$arr[$i]["content"] = get_the_content('');
		$arr[$i]["content"] = apply_filters('the_content', $arr[$i]["content"]);

		$arr[$i]["tabtitle"] = get_post_meta(get_the_ID(), 'Tab', $single = true);
		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumb"] = '';
		$arr[$i]["thumb"] = get_post_meta(get_the_ID(), 'Icon', $single = true);

		$i++;
	endwhile; wp_reset_query();	?>


<div id="side-tabs">
	<ul>
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<?php if ($arr[$i]["tabtitle"] == '') $arr[$i]["tabtitle"] = 'Tab Custom field'; ?>
			<li class="clearfix"><a href="#" <?php if ($i == 1) echo(' class="activeTab"'); ?>><?php if($arr[$i]["thumb"] <> '') echo('<img src="'.esc_attr( $arr[$i]["thumb"] ).'" alt="" width="36" height="37" />'); ?><span><?php echo( esc_html( $arr[$i]["tabtitle"] ) ); ?></span></a></li>
		<?php }; ?>
	</ul>
</div> <!-- end #side-tabs -->


<div id="main-area">
	<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
		<div class="tab-content<?php if ($i == 1) echo(' active'); ?>">
			<h2 class="title"><?php echo(esc_html($arr[$i]["title"])); ?></h2>
			<?php echo($arr[$i]["content"]); ?>
			<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php esc_html_e('Read More','MyAppTheme'); ?></span></a>
		</div> <!-- end .tab-content -->
	<?php }; ?>
</div> <!-- end #main-area -->