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
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
<div class="modal animated fadeIn" id="variablepricemodal" tabindex="-1" role="dialog">
  <div class="modal-dialog mayosis-madalin" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4><?php esc_html_e('Choose Your Desired Option(s)','mayosis'); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
       	<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'class' => 'btn' ) ); ?>
      </div>
    </div>
  </div>
</div>
    <!-- End Page Headings Layout -->
     <!-- Begin Blog Main Post Layout -->
    <section class="container blog-main-content">
        <div class="row">
            <div class="col-md-12">
                <?php get_template_part( 'includes/single-product-full-layout' ); ?>
            </div>
       </div>
    </section>
    <?php if ($disableproductwidget == 'on'): ?>
  <section class="container-fluid bottom-post-footer-widget">
    <div class="container bottom-product-sidebar">
    <?php get_template_part( 'content/content', 'product-footer' ); ?>
       </div>
    </section>
        <?php endif; ?>
    <!-- End Blog Main Post Layout-->
    </article>