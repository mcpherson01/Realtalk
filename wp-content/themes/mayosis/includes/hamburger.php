<?php
defined('ABSPATH') or die();
$mainlogo= get_theme_mod( 'main_logo' );
?>
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
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
 
    
    <li><span  onclick="openNav()"><i class="fas fa-bars"></i></span></li>