<div id="featured">
	<a id="left-arrow" href="#"><?php esc_html_e('Previous','Boutique'); ?></a>
	<a id="right-arrow" href="#"><?php esc_html_e('Next','Boutique'); ?></a>

	<div id="slides">
		<?php global $boutique_active_plugin_name;
		$arr = array();

		$featured_cat = get_option('boutique_feat_cat');
		$featured_num = (int) get_option('boutique_featured_num');
		$featured_use_pages = get_option('boutique_use_pages','false');

		if ( 'false' == $featured_use_pages ) {
			$featured_args = array(
				'posts_per_page' => (int) $featured_num,
				'cat' => (int) get_catId($featured_cat)
			);
		}
		else {
			global $pages_number;

			if (get_option('boutique_feat_pages') <> '') $featured_num = count(get_option('boutique_feat_pages'));
			else $featured_num = $pages_number;

			$featured_args = array(
				'post_type' => 'page',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => (int) $featured_num,
			);

			if ( is_array( get_option('boutique_feat_pages') ) )
				$featured_args['post__in'] = (array) array_map( 'intval', et_get_option( 'boutique_feat_pages', '', 'page' ) );
		}

		if ( $boutique_active_plugin_name == 'wp_ecommerce' && 'false' == $featured_use_pages ){
			$et_term_by = is_numeric( $featured_cat ) ? 'id' : 'name';

			$et_featured_term = get_term_by( $et_term_by, $featured_cat, 'wpsc_product_category' );

			$featured_args = array(
				'post_type' => 'wpsc-product',
				'posts_per_page' => $featured_num,
				'tax_query' => array(
					array(
						'taxonomy' => 'wpsc_product_category',
						'field' => 'id',
						'terms' => (int) $et_featured_term->term_id
					)
				)
			);
		}

		$featured_query = new WP_Query($featured_args);
		?>
		<?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
			<div class="slide">
				<?php
					$width = 380;
					$height = 230;
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext,false,'Featured');
					$thumb = $thumbnail["thumb"];
					$featured_link = get_post_meta(get_the_ID(),'Link',true) ? get_post_meta(get_the_ID(),'Link',true) : get_permalink();
				?>

				<div class="featured-image">
					<a href="<?php echo esc_url( $featured_link ); ?>"><?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, ''); ?></a>
					<?php if ( 'false' == $featured_use_pages ) { ?>
						<div class="featured-price">
							<a href="#<?php echo boutique_product_name('featured'); ?>" class="add_cart et-shop-item"><?php esc_html_e('Add To Cart','Boutique'); ?></a>
							<a href="<?php echo esc_url($featured_link); ?>" class="more_info"><?php esc_html_e('More Info','Boutique'); ?></a>

							<span class="price"><?php echo boutique_price(); ?></span>
							<span class="currency_sign"><?php echo boutique_currency_sign(); ?></span>
						</div> <!-- end .featured-price -->
					<?php } ?>
				</div> <!-- end .featured-image -->
				<div class="featured-description">
					<h2 class="featured-title"><a href="<?php echo esc_url($featured_link); ?>"><?php the_title(); ?></a></h2>
					<p><?php truncate_post(190); ?></p>
					<a href="<?php echo esc_url($featured_link); ?>" class="readmore"><span><?php esc_html_e('More Info', 'Boutique'); ?></span></a>

					<?php if ( 'false' == $featured_use_pages ) do_action('boutique_featured_product'); ?>
				</div> <!-- end .description -->
			</div> <!-- end .slide -->
		<?php endwhile; endif; wp_reset_postdata(); ?>
	</div> <!-- end #slides -->

	<div id="controllers"></div>
</div> <!-- end #featured -->