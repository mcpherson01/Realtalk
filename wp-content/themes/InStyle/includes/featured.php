<div id="featured-text">
	<?php
		$arr = array();
		$i=1;

		$featured_cat = get_option('instyle_feat_cat');
		$featured_num = (int) get_option('instyle_featured_num');

		if (get_option('instyle_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
		else {
			global $pages_number;

			if (get_option('instyle_feat_pages') <> '') $featured_num = count(get_option('instyle_feat_pages'));
			else $featured_num = $pages_number;

			$et_featured_pages_args = array(
				'post_type' => 'page',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => (int) $featured_num,
			);

			if ( is_array( et_get_option( 'instyle_feat_pages', '', 'page' ) ) )
				$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'instyle_feat_pages', '', 'page' ) );

			query_posts( $et_featured_pages_args );
		}

		while (have_posts()) : the_post();
			$et_instyle_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_instyle_settings',true) );

			$title = isset( $et_instyle_settings['et_fs_title'] ) && !empty($et_instyle_settings['et_fs_title']) ? $et_instyle_settings['et_fs_title'] : get_the_title();
			$link = isset( $et_instyle_settings['et_fs_link'] ) && !empty($et_instyle_settings['et_fs_link']) ? $et_instyle_settings['et_fs_link'] : get_permalink();
			$description = isset( $et_instyle_settings['et_fs_description'] ) && !empty($et_instyle_settings['et_fs_description']) ? $et_instyle_settings['et_fs_description'] : truncate_post(20,false);
	?>
			<div class="slide<?php if ( $i==1 ) echo ' active'; ?>">
				<h2 class="title"><a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses( $title, array( 'span' => array() ) ); ?></a></h2>
				<p><?php echo wp_kses_post( $description ); ?></p>
			</div> 	<!-- end .slide -->
	<?php
		$i++;
		endwhile; wp_reset_query();
	?>
</div> <!-- end #featured-text -->