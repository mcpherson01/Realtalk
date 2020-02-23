<?php   
	global $woocommerce; 
	$_id = urna_tbay_random_key();
?>
<div class="tbay-topcart">
 <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
        <a class="dropdown-toggle mini-cart v2" data-offcanvas="offcanvas-right" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'urna'); ?>">
			<?php  urna_tbay_minicart_button(); ?>
        </a>            
    </div>
</div>    

<?php urna_tbay_get_page_templates_parts('offcanvas-cart','right'); ?>