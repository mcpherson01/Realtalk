<?php
defined('ABSPATH') or die();
?>
<?php

if (class_exists('Easy_Digital_Downloads'))
	{ ?>
                        <?php
	$cart_quantity = edd_get_cart_quantity();
	$display = $cart_quantity > 0 ? '' : ' style="display:none;"';
?>

	<li class="dropdown cart_widget cart-style-one"><a href="%s" data-toggle="dropdown" class="cart-button"><i class="zil zi-cart"></i> <span class="items edd-cart-quantity"><?php
	echo esc_html($cart_quantity); ?></span></a><ul role="menu" class="dropdown-menu mini_cart"><li class="widget"><?php
	$widget = the_widget('edd_cart_widget', array(
		'title' => ''
	)); ?> 
					</li></ul></li> 
	
    <?php
	} ?>
	
	
<?php get_template_part( 'searchform', 'download-style-two'); ?>
<?php get_template_part( 'includes/sidemenu-collapsed-search' ); ?>