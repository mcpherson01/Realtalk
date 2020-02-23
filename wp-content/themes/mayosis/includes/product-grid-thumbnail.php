<?php
$productgridimagesize= get_theme_mod( 'product_grid_image_size','full' );
$productgridimagewidth= get_theme_mod( 'product_grid_image_width','' );
$productgridimageheight= get_theme_mod( 'product_grid_image_height','' );


?>

 <?php if ($productgridimagesize=='custom'){ ?>


 <?php
                        // display featured image?
                        if ( has_post_thumbnail() ) :
                            the_post_thumbnail('mayosis-custom-thumb');
                        endif;

                        ?>

<?php } else { ?>
            <?php
                        // display featured image?
                        if ( has_post_thumbnail() ) :
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                        endif;

                        ?>
                        
<?php }?>