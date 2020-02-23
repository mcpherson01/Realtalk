<?php
defined('ABSPATH') or die();
$cartstyle= get_theme_mod( 'cart_style','one' );

?>


<?php

if (class_exists('Easy_Digital_Downloads'))
	{ ?>
                        <?php
	$cart_quantity = edd_get_cart_quantity();
	$display = $cart_quantity > 0 ? '' : ' style="display:none;"';
?>
<?php if($cartstyle == 'one') : ?>
					
					<li class="dropdown cart_widget cart-style-one"><a href="#" data-toggle="dropdown" class="cart-button"><i class="fa fa-shopping-cart"></i> <span class="items edd-cart-quantity"><?php
	echo esc_html($cart_quantity); ?></span></a><ul role="menu" class="dropdown-menu mini_cart"><li class="widget"><?php
	$widget = the_widget('edd_cart_widget', array(
		'title' => ''
	)); ?> 
					</li></ul></li> 
					
		<?php else: ?>
		
			<li class="dropdown cart_widget cart-style-two"><a href="#" data-toggle="dropdown" class="cart-button"><i class="fa fa-shopping-cart"></i> <span class="items edd-cart-quantity"><?php
	echo esc_html($cart_quantity); ?> <?php esc_html_e('Items','mayosis'); ?></span></a><ul role="menu" class="dropdown-menu mini_cart"><li class="widget"><?php
	$widget = the_widget('edd_cart_widget', array(
		'title' => ''
	)); ?> 
					</li></ul></li> 
		<?php endif; ?>
                        <?php
	} ?>
	
			