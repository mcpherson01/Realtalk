<?php
/**
 * Footer Product Widget (Widget control)
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$default_bwidget_col= get_theme_mod( 'defultp_bottom_widget_col','three');
?>

       <div class="row">
        <?php if ($default_bwidget_col == 'one'): ?>
        
           <div class="col-md-12 col-sm-12 col-xs-12 bottom--post--block">
                 <?php if ( is_active_sidebar( 'default-product-widget-one' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-one' ); ?>
				<?php endif; ?>
            </div>
            
            <?php elseif ($default_bwidget_col == 'two'): ?>
            
            <div class="col-md-6 col-sm-6 col-xs-12 bottom--post--block">
                <?php if ( is_active_sidebar( 'default-product-widget-one' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-one' ); ?>
				<?php endif; ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 bottom--post--block">
                <?php if ( is_active_sidebar( 'default-product-widget-two' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-two' ); ?>
				<?php endif; ?>
            </div>
            
            <?php else :?>
            
            <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
                <?php if ( is_active_sidebar( 'default-product-widget-one' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-one' ); ?>
				<?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
                <?php if ( is_active_sidebar( 'default-product-widget-two' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-two' ); ?>
				<?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 bottom--post--block">
                <?php if ( is_active_sidebar( 'default-product-widget-three' ) ) : ?>
					<?php dynamic_sidebar( 'default-product-widget-three' ); ?>
				<?php endif; ?>
            </div>
            
            <?php endif; ?>
        </div>
            