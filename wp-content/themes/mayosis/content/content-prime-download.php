<?php
/**
 * The default template for download page content
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$productgallerytype= get_theme_mod( 'product_gallery_type','one');
$download_id = get_the_ID();
$primetemplate= get_theme_mod( 'background_prime', 'color');
$disableprimewidget= get_theme_mod( 'prime_bottom_widget','on');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- Begin Page Headings Layout -->
    <div class="prime-product-template product-main-header container-fluid">
        <?php if ($primetemplate=='featured'): ?>
            <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <div class="container-fluid featuredimagebg" style="background:url(<?php echo esc_url($feat_image); ?>) center center;">
            </div>

        <?php endif; ?>
        <div class="container">
            <div class="row productflexfix">
                <?php get_template_part( 'includes/product-header-prime' ); ?>


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
        <div class="mayosis-floating-share">
            <div class="theiaStickySidebar">
            <?php mayosis_floatsocial(); ?>
            </div>
        </div>
        <?php get_template_part( 'includes/single-product-layout-prime' ); ?>

    </section>

    <?php if ($disableprimewidget == 'on'): ?>
    <section class="container-fluid bottom-post-footer-widget">
        <div class="container bottom-product-sidebar">
            <?php get_template_part( 'content/content', 'product-footer-prime' ); ?>
        </div>
    </section>
    <?php endif; ?>
    <!-- End Blog Main Post Layout-->
    
    
</article>