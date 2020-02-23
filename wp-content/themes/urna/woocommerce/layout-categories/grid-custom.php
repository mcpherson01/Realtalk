<?php

$columns = isset($columns) ? $columns : 4;

if( ! (isset($shop_now) && $shop_now == 'yes') ) {
    $shop_now = '';
    $shop_now_text = '';
} 

$count = 0;

$skin = urna_tbay_get_theme();
switch ($skin) {
    case 'beauty':
        $layout = 'v2';
        break;
    case 'book':
        $layout = 'v3';
        break;    
    case 'women':
        $layout = 'v4';
        break;
    default:
        $layout = 'v1';
        break;
}
 
?>
<?php 
    foreach ($categoriestabs as $tab) {

     	$cat = get_term_by( 'id', $tab['category'], 'product_cat' );


        if( isset($tab['images']) && $tab['images'] ) {
        	 $cat_id 		= 	$tab['images'];
        }

        if( isset($tab['type']) && ($tab['type'] !== 'none') ) {
            vc_icon_element_fonts_enqueue( $tab['type'] );
            $type = $tab['type'];
            $iconClass = isset( $tab{'icon_' . $type } ) ? esc_attr( $tab{'icon_' . $type } ) : 'fa fa-adjust';
        }

        if( isset($cat) && $cat ) {
			$cat_name 		= 	$cat->name;    
			$cat_slug 		= 	$cat->slug;   
			$cat_link 		= 	get_term_link($cat->slug, 'product_cat');  
			$cat_count 		= 	$cat->count;	
        } else {
        	$cat_name = esc_html__('Shop', 'urna');
        	$cat_link 		= 	get_permalink( wc_get_page_id( 'shop' ) );
        	$cat_count 		= 	urna_total_product_count();	
        }

       if( isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes' && isset($tab['custom_link']) && !empty($tab['custom_link']) ) {
        	$cat_link = $tab['custom_link'];
        } 

        ?> 

			<div class="item">

               <?php wc_get_template( 'item-categories/cat-custom-'.$layout.'.php', array('tab'=> $tab, 'count_item'=> $count_item, 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text ) ); ?>

			</div>
		<?php 
		$count++;
		?>
        <?php
    }
?>

<?php wp_reset_postdata(); ?>