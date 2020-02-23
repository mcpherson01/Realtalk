<?php
defined('ABSPATH') or die();
$mainlogo= get_theme_mod( 'main_logo' );
$topleftelement= get_theme_mod( 'top_left_element','social' );
$toprightelement= get_theme_mod( 'top_right_element','menu' );
?>
<!-- Start Secondary Menu Layout -->
<div class="row">
    	<div class="top-header container-fluid hidden-xs">
    		<div class="container">
    			<div class="row">
    			    <div class="top-header-left pull-left">
    			    <?php if ($topleftelement == 'logo'):?>
    				    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="top-logo-url"><img src="<?php echo esc_url($mainlogo);  ?>" class="img-responsive top-main-logo" alt="Logo"/></a>
    				<?php endif; ?>
    				
    				<?php if ($topleftelement == 'menu'):?>
    					<?php get_template_part( 'includes/top-navigation' ); ?>
    				<?php endif; ?>
    					<?php if ($topleftelement == 'social'):?>
    					<?php get_template_part( 'includes/social-icon' ); ?>
    				<?php endif; ?>
    				<?php if ($topleftelement == 'menuicon'):?>
    				    <?php get_template_part( 'includes/top-navigation' ); ?>
    				    <?php get_template_part( 'includes/top-header-cart' ); ?>
    				<?php endif; ?>
    				</div>
    				
    			 <div class="top-header-right pull-right">
    				 <?php if ($toprightelement == 'logo'):?>
    				    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="top-logo-url"><img src="<?php echo esc_url($mainlogo);  ?>" class="img-responsive top-main-logo pull-right" alt="Logo"/></a>
    				<?php endif; ?>
    				
    				<?php if ($toprightelement == 'menu'):?>
    					<?php get_template_part( 'includes/top-navigation' ); ?>
    				<?php endif; ?>
    					<?php if ($toprightelement == 'social'):?>
    					<?php get_template_part( 'includes/social-icon' ); ?>
    				<?php endif; ?>
    				<?php if ($toprightelement == 'menuicon'):?>
    				    
    				    <?php get_template_part( 'includes/top-header-cart' ); ?>
    				    <?php get_template_part( 'includes/top-navigation' ); ?>
    				<?php endif; ?>
    		      </div>
    				<div class="clearfix"></div>
    			</div>
    		</div>
    	</div>
    	</div>
	<!-- End Secondary Menu Layout -->  
		<div class="clearfix"></div>