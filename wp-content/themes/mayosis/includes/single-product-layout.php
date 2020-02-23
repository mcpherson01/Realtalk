<?php
/**
 * The default template for Product Content
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$productgallerytype= get_theme_mod( 'product_gallery_width','two');
$productbottomtags= get_theme_mod( 'product_bottom_tags','hide');
$productbottombuttonhide= get_theme_mod( 'product_bottom_buttons','show');

?>

<div class="row">
            <?php if ($productgallerytype == 'one'): ?>
                <div class="col-md-12">
                    <?php get_template_part( 'includes/product-gallery' ); ?>
                    </div>
                    <?php endif; ?>
            <div class="col-md-8 col-sm-7 col-xs-12">
                <div class="single-post-block">
                    <?php get_template_part( 'includes/edd_media');?>
                     <?php if ($productgallerytype == 'two'): ?>
                    <?php get_template_part( 'includes/product-gallery' ); ?>
                    <?php endif; ?>
                     <?php the_content(); ?>

                 </div>
                 <?php if ($productbottombuttonhide == 'show'): ?>
                  <?php get_template_part( 'includes/product-bottom-buttons' ); ?>
                  <?php  endif; ?>
                  <?php if ($productbottomtags == 'show'): ?>
                  <div class="bottom_meta product--bottom--tag"> 
                      <?php $download_tags = get_the_term_list( get_the_ID(), 'download_tag',  ' ', ' '); ?>
    			<span><?php esc_html_e('Tags:','mayosis'); ?></span>	<?php echo '<span class="tags">' . $download_tags . '</span>'; ?>
				</div>
				<?php  endif; ?>
                  <div class="clearfix"></div>
            </div>
            
            <div class="col-md-4 col-sm-5 col-xs-12 product-sidebar">
              
                 <?php if ( is_active_sidebar( 'single-product' ) ) : ?>
					<?php dynamic_sidebar( 'single-product' ); ?>
				<?php endif; ?>
                    
      
               
                <!--sidebar widget-->
            </div>
        </div>