<?php 

if ( !(defined('URNA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && URNA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED ) {
wc_get_template_part('myaccount/custom-form-login'); 
}

urna_tbay_get_page_templates_parts('offcanvas-main-menu');
?>

<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo (urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- //LOGO -->
                <div class="header-logo col-md-2">

                    <?php 
                    	urna_tbay_get_page_templates_parts('logo'); 
                    ?> 
                </div>
				<div class="header-search col-md-5">
					<div class="search-full">
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>

				</div>
				<div class="col-md-2">
					<div class="account-wrapper">
						<?php urna_tbay_get_page_templates_parts('topbar-account');
						if ( has_nav_menu( 'track-order' ) ): ?>
			    			<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
			    		<?php endif; ?>
					</div>
				</div>

				<?php if( function_exists( 'urna_tbay_wc_the_recently_viewed' ) ) : ?>
				<div class="col-md-1 recent-view">
					<?php 
				    	urna_tbay_wc_the_recently_viewed();
				    ?>
				</div>
				<?php endif; ?>

				<div class="header-right col-md-2">
					
					<div class="tbay-mainmenu">
						<a href="javascript:void(0);" data-toggle="offcanvas-main" class="btn-toggle-canvas">
						   	<i class="linear-icon-menu"></i>
						</a>
					</div>

					<!-- Cart -->
                	<?php if ( !(defined('URNA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && URNA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED ): ?>
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>
					
					<!-- Wishlist -->
					<div class="top-wishlist">
						<?php 
	                    	urna_tbay_get_page_templates_parts('wishlist'); 
	                    ?> 
                	</div>
                    
				</div>
				
            </div>
        </div>
    </div>
    <?php if ( has_nav_menu( 'nav-category-menu' ) ): ?>

        <?php
            $args = array(
                'theme_location' => 'nav-category-menu',
                'menu_class'      => 'tbay-menu-category container nav navbar-nav megamenu',
                'fallback_cb'     => '',
                'menu_id' => 'nav-category-menu',
            );
            if( class_exists("Urna_Tbay_Custom_Nav_Menu") ){

                $args['walker'] = new Urna_Tbay_Custom_Nav_Menu();
            }
            wp_nav_menu($args);
        ?>
	<?php endif;?>
    <div id="nav-cover"></div>
</header>