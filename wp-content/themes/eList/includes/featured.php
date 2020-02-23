<?php
	$et_slider_settings_class = '';
	$et_slider_auto = 'on' == get_option('elist_slider_auto') ? 'et_slider_auto' : '';

	$et_slider_auto_speed = false !== get_option('elist_slider_autospeed') ? get_option('elist_slider_autospeed') : '7000';
	$et_slider_auto_speed = ' et_slider_autospeed_' . $et_slider_auto_speed;

	$et_slider_pause = 'on' == get_option('elist_slider_pause') ? ' et_slider_pause' : '';

	$et_slider_settings_class = $et_slider_auto . $et_slider_auto_speed . $et_slider_pause;

	global $featured_listings_ids;
	$featured_listings_ids = array();
	$i=0;

	$featured_num = (int) get_option('elist_featured_num');
	if ( ! is_home() ) $featured_num = (int) get_option('elist_listings_featured_num');

	$featured_image_size = apply_filters( 'elist_featured_image_size', array( 'width' => 180, 'height' => 180 ) );

	$featured_args = apply_filters( 'elist_featured_args', array(
		'post_type' => 'listing',
		'posts_per_page' => (int) $featured_num,
		'orderby' => 'random',
		'meta_key' => '_elist_featured',
		'meta_value' => 'on',
	) );

	$featured_query = new WP_Query( $featured_args );
?>

<?php if ( 0 < $featured_query->found_posts ) { ?>
	<section id="featured">
		<div class="container">
			<h1><?php esc_html_e( 'Featured Listings', 'eList' ); ?></h1>
			<?php if ( 1 < $featured_query->found_posts ) { ?>
				<a id="left-arrow" href="#"><?php esc_html_e( 'Previous', 'eList' ); ?></a>
				<a id="right-arrow" href="#"><?php esc_html_e( 'Next', 'eList' ); ?></a>
			<?php } ?>
			<div id="slides" class="<?php echo $et_slider_settings_class; ?>">
				<?php
					while ( $featured_query->have_posts() ) : $featured_query->the_post();
				?>
						<article class="slide clearfix">
							<?php
								$post_title = get_the_title();

								$thumbnail = get_thumbnail( (int) $featured_image_size['width'], (int) $featured_image_size['height'], '', $post_title, $post_title, false, 'Featured' );
								$thumb = $thumbnail["thumb"];

								if ( '' != $thumb ){
							?>
									<div class="featured-img">
										<a href="<?php the_permalink(); ?>">
											<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $post_title, (int) $featured_image_size['width'], (int) $featured_image_size['height'], '' ); ?>
											<span class="overlay"></span>
										</a>
									</div> <!-- end .featured-img -->
							<?php
								}
							?>
							<div class="featured-description">
								<h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="meta-info"><?php esc_html_e('Posted','eList'); ?> <?php esc_html_e('by','eList'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('in','eList'); ?> <?php echo get_the_term_list( $post->ID, 'listing_category', '', ', ' ); ?> <?php esc_html_e('on','eList'); ?> <?php the_time( get_option( 'elist_date_format' ) ); ?></p>

								<p><?php truncate_post( 600 ); ?></p>
							</div> <!-- end .featured-description -->
						</article> <!-- end .slide -->
				<?php
						$featured_listings_ids[] = $post->ID;
						$i++;
					endwhile;
					wp_reset_postdata();
				?>
			</div> <!-- end #slides -->
			<?php if ( $i > 1 ) { ?>
				<div id="controllers">
					<?php for ( $j = 1; $j <= $i; $j++ ) { ?>
						<a href="#"<?php if ( 1 == $j ) echo ' class="activeSlide"'; ?>><?php echo esc_html( $j ); ?></a>
					<?php } ?>
				</div> <!-- end #controllers -->
			<?php } ?>
		</div> <!-- end .container -->
	</section> <!-- end #featured -->
<?php } ?>