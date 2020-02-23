<?php
	global $woocommerce;
	$cart_url = wc_get_cart_url();
	$cart_count = $woocommerce->cart->get_cart_contents_count();
?>

<a class="cart-link" href="<?php echo esc_url($cart_url); ?>">
	<i class="stack-basket"></i>
	<?php if( $cart_count > 0 ) { ?>
		<div class="ebor-cart-count"><?php echo esc_html( $cart_count ); ?></div>
	<?php } ?>
</a>