<?php 
global $product;

$rating	= wc_get_rating_html( $product->get_average_rating());

?>
<div class="product-block vertical <?php urna_is_product_variable_sale(); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-content clearfix">
		<div class="block-inner">
			<figure class="image ">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo trim($product->get_image()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</figure>
		</div>
		<div class="caption">

		<?php urna_the_product_name(); ?>

		<?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php echo trim($product->get_price_html()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
    </div>
</div>
