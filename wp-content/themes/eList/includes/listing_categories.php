<?php
	$elist_categories_args = array( 'hide_empty' => 0 );

	if ( 'on' == get_option('elist_listings_hide_empty') ) $elist_categories_args['hide_empty'] = 1;

	if ( is_tax() ) {
		$et_term = get_queried_object();
		$elist_categories_args['child_of'] = $et_term->term_id;
	}

	$categories = get_categories( 'taxonomy=listing-category' );

	$elist_listing_categories = get_terms( 'listing_category', apply_filters( 'listing_categories_args', $elist_categories_args ) );
	$elist_category_images = false !== get_option( 'elist_category_images' ) ? (array) get_option( 'elist_category_images' ) : array();
	$et_count = 0;

	if ( $elist_listing_categories ){ ?>
		<section id="listing-categories">
			<div class="container clearfix">
				<h1><?php esc_html_e( 'Listing Categories', 'eList' ); ?></h1>
				<?php foreach( $elist_listing_categories as $elist_listing_category ) { ?>
					<?php
						$et_current_term_query = new WP_Query(
							array(
								'post_status' => 'publish',
								'tax_query' => array(
										array(
											'taxonomy' => 'listing_category',
											'field' => 'id',
											'terms' => $elist_listing_category->term_id
										)
									)
							)
						);
					?>

					<?php $et_count++; ?>
					<div class="l-category<?php if ( $et_count % 3 == 0 ) echo ' last'; ?>">
						<?php $et_listing_category_link = get_term_link( $elist_listing_category ); ?>
						<?php if ( isset( $elist_category_images[$elist_listing_category->term_id] ) && '' != $elist_category_images[$elist_listing_category->term_id] ) { ?>
							<div class="thumb">
								<a href="<?php echo esc_url( $et_listing_category_link ); ?>">
									<img class="item-image" alt="<?php echo esc_attr( $elist_listing_category->name ); ?>" src="<?php echo esc_attr( et_new_thumb_resize( et_multisite_thumbnail( $elist_category_images[$elist_listing_category->term_id] ), 70, 70, '', true ) ); ?>"/>
									<span class="overlay"></span>
								</a>
							</div> 	<!-- end .thumb -->
						<?php } ?>
						<div class="description">
							<h2><a href="<?php echo esc_url( $et_listing_category_link ); ?>"><?php echo esc_html( $elist_listing_category->name ); ?></a></h2>
							<p class="info"><?php if ( 1 == $et_current_term_query->found_posts ) printf( __('%d Listing','eList'), $et_current_term_query->found_posts ); else printf( __('%d Listings'), $et_current_term_query->found_posts ); ?></p>
							<?php if ( '' != $elist_listing_category->description ) { ?>
								<p><?php echo esc_html( $elist_listing_category->description ); ?></p>
							<?php } ?>
						</div> <!-- end .description -->
					</div> <!-- end .l-category -->
				<?php } ?>
			</div> <!-- end .container -->
		</section> <!-- end #listing-categories -->
<?php } ?>