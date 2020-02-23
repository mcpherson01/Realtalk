<?php
/**
 * The default template for Product Content
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$productbottomtags= get_theme_mod( 'product_bottom_tags','hide');
$productbottombuttonhide= get_theme_mod( 'product_bottom_buttons','show');
?>

<div class="row">
     <div class="col-md-12">
         <?php get_template_part( 'includes/product-gallery' ); ?>
         <div class="remove_edd_cart">
             <div class="single-post-block">
           <?php the_content(); ?>
           </div>
            <?php if ($productbottomtags == 'show'): ?>
                  <div class="bottom_meta product--bottom--tag">
                      <?php $download_tags = get_the_term_list( get_the_ID(), 'download_tag',  ' ',''); ?>
    			<span><?php esc_html_e('Tags:','mayosis'); ?></span>	<?php echo '<span class="tags">' . $download_tags . '</span>'; ?>
				</div>
				<?php  endif; ?>
                  <div class="clearfix"></div>
           </div>
           <?php if ($productbottombuttonhide == 'show'): ?>
            <?php get_template_part( 'includes/product-bottom-buttons' ); ?>
         <?php  endif; ?>
     </div>
</div>