<?php 
$productgridimagesize= get_theme_mod( 'product_grid_image_size','full' );
$productgridimagewidth= get_theme_mod( 'product_grid_image_width','' );
$productgridimageheight= get_theme_mod( 'product_grid_image_height','' );

 if ($productgridimagesize=='custom'){
     add_image_size( 'mayosis-custom-thumb', $productgridimagewidth, $productgridimageheight, true );
 }
?>