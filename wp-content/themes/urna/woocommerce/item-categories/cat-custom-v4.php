<?php 

$cat                =   get_term_by( 'id', $tab['category'], 'product_cat' );
$description        =   ( isset($tab['description']) ) ? $tab['description'] : '';
 

if( isset($cat) && $cat ) {
    $cat_name       =   $cat->name;    
    $cat_slug       =   $cat->slug;   
    $cat_link       =   get_term_link($cat->slug, 'product_cat');
} else {
    $cat_name       = esc_html__('Shop', 'urna');
    $cat_link       =   get_permalink( wc_get_page_id( 'shop' ) );
}

if( isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes' && isset($tab['custom_link']) && !empty($tab['custom_link']) ) {
    $cat_link = $tab['custom_link'];
}

?>
<div class="item-cat item-cat-v4 tbay-image-loaded">

    <div class="content-img">

        <?php if ( isset($tab['images']) && !empty($tab['images']) ): ?>
            <?php
                $cat_id         =   $tab['images'];    
                $image         = wp_get_attachment_url( $cat_id );
            ?>
            <div class="cat-img">
                <a href="<?php echo esc_url($cat_link); ?>">
                    <?php urna_tbay_src_image_loaded($image, array('alt'=> $cat_name )); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="content">

            <?php if( isset($cat) && $cat ) : ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php echo trim($cat_name); ?></a>
            <?php else: ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php esc_html_e( 'All', 'urna' ) ?></a>
            <?php endif; ?>

            <?php if( !empty($description) ) : ?>
                <div class="cat-description">
                    <?php echo trim($description); ?>
                </div>
            <?php endif; ?>

            <?php if ( (isset($shop_now) && $shop_now == 'yes') ) : ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="shop-now"><?php echo trim($shop_now_text); ?></a>
            <?php endif; ?>
        </div>



    </div>

</div>