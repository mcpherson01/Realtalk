<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
<?php $productthumbvideo= get_theme_mod( 'thumbnail_video_play','show' );
$productthumbposter= get_theme_mod( 'thumbnail_video_poster','show' );
$productvcontrol= get_theme_mod( 'thumb_video_control','minimal' );
$productcartshow= get_theme_mod( 'thumb_cart_button','hide' );

?>
	 <figure class="mayosis-fade-in">


    <?php if ($productthumbvideo=='show'){ ?>
    <?php if ( has_post_format( 'video' )) { ?>

    <div class="mayosis--video--box">
        <div class="video-inner-box-promo">

            <a href="<?php the_permalink();?>" class="mayosis-video-url"></a>
            <div class="video-inner-main">
                <?php get_template_part( 'library/mayosis-video-box-thumb' ); ?>
            </div>
            <div class="clearfix"></div>
            <?php if ($productcartshow=='show'){ ?>
                <div class="product-cart-on-hover">
                    <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
                </div>
            <?php }?>
            <?php if ($productvcontrol=='minimal'){ ?>
                <div class="minimal-video-control">
                    <div class="minimal-control-left">

                        <?php if ( function_exists( 'edd_favorites_load_link' ) ) {
                            edd_favorites_load_link( $download_id );
                        } ?>
                    </div>



                    <div class="minimal-control-right">
                        <ul>
                            <li>	<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>  </li>
                            <?php $mayosis_video = get_post_meta($post->ID, 'video_url',true);?>
                            <li><a href="<?php echo esc_attr($mayosis_video); ?>" data-lity>
                                    <i class="fa fa-arrows-alt" aria-hidden="true"></i></a></li>

                        </ul>
                    </div>

                </div>
            <?php } ?>
        </div>






        <?php } else { ?>
        <div class="mayosis--thumb">
            <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
            <?php } ?>

            <?php } else { ?>

            <div class="mayosis--thumb">
                 <?php get_template_part( 'includes/product-grid-thumbnail' ); ?>
                <?php } ?>
                <figcaption>
                    <div class="overlay_content_center">
                        <?php get_template_part( 'includes/product-hover-content-top' ); ?>

                        <div class="product_hover_details_button">
                            <a href="<?php the_permalink(); ?>" class="button-fill-color"><?php esc_html_e('View Details', 'mayosis'); ?></a>
                        </div>
                        <?php
                        $demo_link = get_post_meta(get_the_ID(), 'demo_link', true);
                        $livepreviewtext= get_theme_mod( 'live_preview_text','Live Preview' );
                        ?>
                        <?php if ( $demo_link ) { ?>
                            <div class="product_hover_demo_button">
                                <a href="<?php echo esc_url($demo_link); ?>" class="live_demo_onh" target="_blank"><?php echo esc_html($livepreviewtext); ?></a>
                            </div>
                        <?php } ?>

                        <?php get_template_part( 'includes/product-hover-content-bottom' ); ?>
                    </div>
                </figcaption>
            </div>
</figure>
<?php endif; ?>
