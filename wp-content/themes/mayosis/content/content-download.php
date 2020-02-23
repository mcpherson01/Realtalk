 <?php
/**
 * The default template for download page content
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$productgallerytype= get_theme_mod( 'product_gallery_type','one');
$download_id = get_the_ID();
$producttemplate= get_theme_mod( 'background_product', 'color');
$disableproductwidget= get_theme_mod( 'defultp_bottom_widget','on');
$default_bwidget_control= get_theme_mod( 'defultp_bottom_widget_control','default');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!-- Begin Page Headings Layout -->
<div class="default-product-template product-main-header container-fluid">
<?php if ($producttemplate=='featured'): ?>
<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
    <div class="container-fluid featuredimagebg" style="background:url(<?php echo esc_url($feat_image); ?>) center center;">
        </div>

<?php endif; ?>
        <div class="container">
            <div class="row productflexfix">
               <?php get_template_part( 'includes/product-header' ); ?>
               
			
            </div>
                
        </div>
    </div>
  

<!-- Modal -->
 <div id="variablepricemodal" class="mayosis-overlay">
	<div class="mayosis-popup">
      <div class="modal-header">
          <h4><?php esc_html_e('Choose Your Desired Option(s)','mayosis'); ?></h4>
        <a class="close" href="#">&times;</a>
      </div>
      <div class="modal-body">
       <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID()) ); ?>
      </div>
    </div>
</div>
    <!-- End Page Headings Layout -->
     <!-- Begin Blog Main Post Layout -->
    <section class="container blog-main-content">
       
         <?php get_template_part( 'includes/single-product-layout' ); ?>
         	
    </section>

    <?php if ($disableproductwidget == 'on'): ?>
  <section class="container-fluid bottom-post-footer-widget">
    <div class="container bottom-product-sidebar">
        <?php if ($default_bwidget_control == 'widget'): ?>
         <?php get_template_part( 'content/content', 'product-footer-widget' ); ?>
         <?php else : ?>
    <?php get_template_part( 'content/content', 'product-footer' ); ?>
    <?php endif; ?>
       </div>
    </section>
    <?php endif; ?>
    
    </article>