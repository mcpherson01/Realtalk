<?php
defined('ABSPATH') or die();
$mainlogo= get_theme_mod( 'main_logo' );
?>
<div id="myNav" class="overlay humburger-overlaymenu">
  <span class="closebtn">×</span>
  <div class="overlay-content">
      <div class="container max-content-width">
          <div class="overlay-logo">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($mainlogo);  ?>" class="img-responsive hamburger-logo center-block" alt="Logo"/></a>
          </div>
          <div class="overlay-element">
         <div class="overlay-nav">
       	<?php get_template_part( 'includes/accordion-menu' ); ?>
       	</div>
       	<div class="overlay-widget">
       	     <?php if ( is_active_sidebar( 'hamburger' ) ) : ?>
					<?php dynamic_sidebar( 'hamburger' ); ?>
				<?php endif; ?>
				<ul id="hamburger-menu" class="nav navbar-nav top-cart-menu">
				    <?php get_template_part( 'includes/cart-header-main' ); ?>
				</ul>
       	</div>
       </div>
   	</div>
  </div>
</div>
 <ul>
    
    <li class="humburger-ms"><span><i class="zil-bars"></i></span></li>
    
</ul>