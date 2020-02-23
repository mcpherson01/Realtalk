<?php
/**
 * generic content display
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$category = get_the_category();
$title = get_the_title();
$short_title = wp_trim_words( $title, 5, '...' );
?>

		<div class="col-md-4 col-xs-12 col-sm-4">
					<div class="product-box">
						<div class="product-thumb"> 
							<a href="<?php the_permalink(); ?>">  
								   	<?php
								// display featured image?
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
								endif; 

							?>                                                
								<div class="hover_effect"></div>
							</a>
						</div>
						<div class="product-meta">
								<div class="product-tag">
								<h4 class="product-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html($short_title); ?></a></h4>
									<p><?php the_terms( $post->ID, 'download_category','' ); ?></p>
								</div>
					
								<div class="count-download">
									 <?php if( $price == "0.00"  ){ ?>
									 <div class="product-price promo_price"><?php esc_html_e('Free','mayosis');?></div>
								
									 <?php } else { ?>
                       <div class="product-price promo_price"><?php edd_price(get_the_ID()); ?></div>
                    <?php } ?>
								</div>
								<div class="clearfix"></div>
							
						</div>
					</div><!-- .product box -->
				</div><!-- .product box Column -->