 <?php
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$featured_image_visibility= get_theme_mod( 'featured_image_visibility','show' );
$featured_image_position= get_theme_mod( 'featured_image_position','left' );
$download_id = get_the_ID();

?>
<?php if ($featured_image_position == 'left'): ?>
<?php if ($featured_image_visibility == 'show'): ?>
    <?php
			// display featured image?
			if ( has_post_thumbnail() ) : ?>
 <div class="col-md-4 col-xs-12 post-thumb-single ">
                    
                
				<?php the_post_thumbnail( 'full', array( 'class' => 'featured-img img-responsive watermark' ) ); ?>
		
                </div> 
                	<?php endif; ?>
		
		            <?php endif; ?>
		            <?php endif; ?>
                   <?php if ($featured_image_visibility == 'show'): ?>
                <div class="col-md-8 col-xs-12 single_main_header_products">
                    <?php else : ?>
                     <div class="col-md-12 col-xs-12 single_main_header_products">
                    <?php endif; ?>
                    <div class="single--post--content">
                        <?php get_template_part( 'includes/default-product-header-layout' ); ?>
                  </div>
                </div>
                
                <?php if ($featured_image_position == 'right'): ?>
<?php if ($featured_image_visibility == 'show'): ?>
    <?php
			// display featured image?
			if ( has_post_thumbnail() ) : ?>
 <div class="col-md-4 col-xs-12 post-thumb-single ">
                    
                
				<?php the_post_thumbnail( 'full', array( 'class' => 'featured-img img-responsive pull-right' ) ); ?>
		
                </div> 
                	<?php endif; ?>
		
		            <?php endif; ?>
		            <?php endif; ?>
                
                
