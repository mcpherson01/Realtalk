<?php
global $post;
$download_id = get_the_ID();
$variablepricingoptions= get_theme_mod( 'variable_pricing_options','default' );
$productbottomsocialbuttons= get_theme_mod( 'product_bottom_social_share','show' );
$productbottomextratext= get_theme_mod( 'product_bottom_extratext','show' );
?>
<?php
global $edd_logs;
$single_count = $edd_logs->get_log_count(66, 'file_download');
$total_count  = $edd_logs->get_log_count('*', 'file_download');
 $sales = edd_get_download_sales_stats( get_the_ID() );
                                                            $sales = $sales > 1 ? $sales .  __( ' Sales', 'mayosis' )  : $sales . __( ' Sale', 'mayosis' );
                                        $price = edd_get_download_price(get_the_ID());
?>
<div class="free_download_block">
    <div class="product_bottom_flex single-product-buttons">
        <?php if ($variablepricingoptions == 'default'): ?>
            <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID()) ); ?>
        <?php else : ?>
            <?php if(edd_has_variable_prices($download_id)):?>
                <a type="button" class="btn btn-primary multiple_button_v" href="#variablepricemodal">
                    <?php esc_html_e('Purchase','mayosis'); ?>
                </a>

            <?php else: ?>
                <?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>

            <?php endif; ?>
        <?php endif; ?>

        <?php if ($productbottomextratext=='show'): ?>
            <p class="text-center extra__text">
                <?php if( $price == "0.00"  ){ ?>
                    <?php $download = $edd_logs->get_log_count(get_the_ID(), 'file_download'); echo ( is_null( $download ) ? '0' : $download ); ?> <?php esc_html_e('Downloads','mayosis'); ?>
                <?php } else { ?>
                    <?php echo esc_html($sales); ?>
                <?php } ?>
            </p>
        <?php endif; ?>
    </div>

    <?php
    $custom_button =  get_post_meta($post->ID, 'custom-button-url', true);
    $custom_text= get_post_meta($post->ID, 'custom-button-title', true);
    $custom_desc= get_post_meta($post->ID, 'custom-button-description', true);
    ?>

    <?php if ( $custom_button  ) { ?>
        <div class="product_bottom_flex">

            <a href="<?php echo esc_html($custom_button); ?>" class="ghost_button" target="_blank"><?php echo esc_html($custom_text); ?></a>
            <?php if ($productbottomextratext=='show'): ?>
                <p class="text-center extra__text"><?php echo esc_html($custom_desc); ?></p>

            <?php endif; ?>
        </div>
    <?php } ?>

    <?php if ($productbottomsocialbuttons=='show'): ?>
        <div class="product_bottom_flex">
            <?php if(function_exists('mayosis_productbottombutton')){
                mayosis_productbottombutton();
            } ?>
            <?php if ($productbottomextratext=='show'): ?>
            <p class="text-center extra__text"><?php esc_html_e('Share Now! ','mayosis'); ?>
                <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
 