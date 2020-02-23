<?php
/**
 * The default template for Product Content
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$download_id = get_the_ID();
$productgallerywidth= get_theme_mod( 'prime_gallery_width','two');
$productbottomtags= get_theme_mod( 'product_bottom_tags','hide');
$primemediaposition= get_theme_mod( 'prime_media_position','top');
$productbottombuttonhide= get_theme_mod( 'product_bottom_buttons','show');
$productgallerytype= get_theme_mod( 'product_gallery_type','one' );
$disablethumb= get_theme_mod( 'disable_thumbnail','yes' );
$ids = get_post_meta($post->ID, 'vdw_gallery_id', true);
$livepreviewtext= get_theme_mod( 'live_preview_text','Live Preview' );
$font_url = get_post_meta( $post->ID, 'sample_font_url', true );
?>

<div class="row">
    <?php if ($productgallerywidth == 'one'): ?>
        <div class="col-md-12">
            <div class="prime-layout-gallery prime-full-width-gallery">
                <?php if ($ids): ?>
                    <?php get_template_part( 'includes/product-gallery-prime' ); ?>
                <?php else : ?>
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-8 col-sm-7 col-xs-12">
        <div class="single-post-block single-prime-layout">
            <?php if ($primemediaposition == 'top'){ ?>
             <?php get_template_part( 'includes/edd_media');?>
             <?php } ?>
             <?php if ( has_post_format( 'video' )) { ?>
             <?php } elseif ( has_post_format( 'audio' )) { ?>
             <?php } else { ?>
            <?php if ($productgallerywidth == 'two'): ?>
            <div class="prime-layout-gallery">
                <?php if ($ids): ?>
                    <?php get_template_part( 'includes/product-gallery-prime' ); ?>
                <?php else : ?>
                <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail();
                }
                ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php } ?>
            <div class="prime--button-set">
                <div class="prime--button--left">
                    <?php
                    global $edd_logs;
                    $single_count = $edd_logs->get_log_count(66, 'file_download');
                    $total_count  = $edd_logs->get_log_count('*', 'file_download');
                    $price = edd_get_download_price(get_the_ID());
                    ?>
                    <?php if( $price == "0.00"  ){ ?>
                    <?php } else { ?>

                        <div class="prime-cart-button">
                            <?php if(edd_has_variable_prices($download_id)):?>
                                <a class="prime-multiple-button btn btn-primary multiple_button_v" href="#variablepricemodal">
                                    <?php esc_html_e('Purchase','mayosis'); ?>
                                </a>

                            <?php else: ?>
                                <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>

                            <?php endif; ?>



                        </div>

                    <?php } ?>
                    <?php $demo_link =  get_post_meta($post->ID, 'demo_link', true); ?>
                    <?php if ( $demo_link ) { ?>
                        <div class="prime--box--demo-button">

                            <a href="<?php echo esc_html($demo_link); ?>" class="btn btn-default prime-demo-button" target="_blank"><?php echo esc_html($livepreviewtext); ?></a>


                        </div>
                    <?php } ?>

                </div>

                <div class="prime--button--right prime-wishlist-fav">
                    <?php if ( function_exists( 'edd_favorites_load_link' ) ) {
                        edd_favorites_load_link( $download_id );
                    } ?>

 <?php if ( function_exists( 'edd_wl_load_wish_list_link' ) ) { ?>
<?php if(edd_has_variable_prices($download_id)):?>
                                <a class="edd-wl-button" href="#variablepricemodal">
                                    <i class="glyphicon glyphicon-add"></i> <?php esc_html_e('Add to Wishlist','mayosis'); ?>
                                </a>

                            <?php else: ?>
                            <?php edd_wl_load_wish_list_link( $download_id ); ?>
                            <?php endif; ?>
                   
                        
                    <?php } ?>
                </div>
            </div>
            
            <?php if ($primemediaposition == 'bottom'){ ?>
             <?php get_template_part( 'includes/edd_media');?>
             <?php } ?>
             <?php if ($font_url){?>
             <?php get_template_part( 'library/mayosis-font-system');?>
             <?php } ?>
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