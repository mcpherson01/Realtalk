<div id="featured">
	<div id="featured-overlay"></div>
	<div id="slides">

	<?php
	$arr = array();
	$i=1;

	$width = 461;
	$height = 271;

	$featured_cat = get_option('magnificent_feat_cat');
	$featured_num = (int) get_option('magnificent_featured_num');

	if (get_option('magnificent_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('magnificent_feat_pages') <> '') $featured_num = count(get_option('magnificent_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'magnificent_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'magnificent_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post(); ?>
		<div class="slide">
			<a href="<?php the_permalink();?>">
				<?php
				$post_title = get_the_title();

				$thumbnail = get_thumbnail($width,$height,'thumb',$post_title,$post_title);
				$thumb = $thumbnail["thumb"];

				print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'thumb'); ?>
			</a>
			<div class="description">
				<h2 class="title"><a href="<?php the_permalink();?>"><?php truncate_title(37); ?></a></h2>
				<p class="meta-info"><?php esc_html_e('Posted','Magnificent'); ?> <?php esc_html_e('by','Magnificent'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','Magnificent'); ?> <?php the_time(get_option('magnificent_date_format')) ?></p>
			</div> <!-- end .description -->
		</div> <!-- end .slide -->
		<?php endwhile; wp_reset_query();	?>

	</div> <!-- end #slides -->

	<a href="#" id="left-arrow"><?php esc_html_e('Previous','Magnificent'); ?></a>
	<a href="#" id="right-arrow"><?php esc_html_e('Next','Magnificent'); ?></a>

</div>	<!-- end #featured -->