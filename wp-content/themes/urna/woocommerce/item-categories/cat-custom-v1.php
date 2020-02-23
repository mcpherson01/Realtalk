<?php 

$cat        =   get_term_by( 'id', $tab['category'], 'product_cat' );
 

if( isset($cat) && $cat ) {
    $cat_name       =   $cat->name;    
    $cat_slug       =   $cat->slug;   
    $cat_link       =   get_term_link($cat->slug, 'product_cat');
    $cat_count      =   $cat->count;
} else {
    $cat_name = esc_html__('Shop', 'urna');
    $cat_link       =   get_permalink( wc_get_page_id( 'shop' ) );
    $cat_count      =   urna_total_product_count();
}

if( isset($tab['type']) && ($tab['type'] !== 'none') ) {
    vc_icon_element_fonts_enqueue( $tab['type'] );
    $type = $tab['type'];
    $iconClass = isset( $tab{'icon_' . $type } ) ? esc_attr( $tab{'icon_' . $type } ) : 'fa fa-adjust';
}

if( isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes' && isset($tab['custom_link']) && !empty($tab['custom_link']) ) {
    $cat_link = $tab['custom_link'];
}

$have_icon = (isset($iconClass) && $iconClass) ? 'cat-icon' : 'cat-img';

?>
<div class="item-cat tbay-image-loaded <?php echo esc_attr($have_icon); ?>">
<?php if ( isset($tab['images']) && !empty($tab['images']) ): ?>

    <?php
        $cat_id         =   $tab['images'];    
        $image         = wp_get_attachment_url( $cat_id );
    ?>

    <a href="<?php echo esc_url($cat_link); ?>"><?php urna_tbay_src_image_loaded($image, array('alt'=> $cat_name )); ?></a>

<?php elseif ( isset($iconClass) && $iconClass ): ?>

    <a href="<?php echo esc_url($cat_link); ?>"><i class="<?php echo esc_attr($iconClass); ?>"></i></a>

<?php endif; ?>
    <div class="content">
        <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php echo trim($cat_name); ?></a>

        <?php if ( (isset($shop_now) && $shop_now == 'yes') ) { ?>
            <div class="cat-hover">
                <?php if ( $count_item == 'yes' ) { ?>
                    <span class="count-item"><?php echo trim($cat_count).' '. apply_filters( 'urna_tbay_categories_count_item', esc_html__('items','urna') ); ?></span>
                <?php } ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="shop-now"><?php echo trim($shop_now_text); ?></a>
            </div>
            <?php }
            else { ?>
            <?php if ( $count_item == 'yes' ) { ?>
                <span class="count-item"><?php echo trim($cat_count).' '.apply_filters( 'urna_tbay_categories_count_item', esc_html__('items','urna') ); ?></span>
            <?php } ?>      
        <?php } ?>
   </div>
</div>