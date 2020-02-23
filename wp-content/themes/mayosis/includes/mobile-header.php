  <?php 
  $mainlogo= get_theme_mod( 'main_logo' );
  $loginlink= get_theme_mod( 'login_url' );
  $headertransparentmain= get_theme_mod( 'header_transparency','transparent' );
  $stickylogomain= get_theme_mod( 'sticky_logo');
  ?>
  <nav  class="mobile--nav-menu">
       
            	<?php get_template_part( 'includes/accordion-menu' ); ?>
       
    </nav>
    <div class="overlaymobile"></div>
   <?php if($headertransparentmain == 'transparent') :?>
   <header id="mobileheader" class="headroom mobile-header container-fluid animated hidden-md hidden-lg header-transparent">
	<?php else :?>
<header id="mobileheader" class="mobile-header headroom container-fluid animated hidden-md hidden-lg">
    <?php endif; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-xs-7 logo">
			    <?php if($mainlogo) :?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($mainlogo);  ?>" class="img-responsive main-logo mobile-logo" alt="Logo"/></a>
				
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-white.png" class="img-responsive main-logo" alt="Logo"/></a>
				<?php endif; ?>
				<?php if ($stickylogomain): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($stickylogomain); ?>" class="img-responsive sticky-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
						 <?php endif; ?>
			</div>
			<div class="col-sm-8  col-xs-5 mobile_user">
				 <ul  class="nav navbar-nav">
					 
                     <?php
if(class_exists('Easy_Digital_Downloads')) { ?>
				<li><a href="<?php echo edd_get_checkout_uri(); ?>" class="btn btn-danger btn-lg mobile-cart-button"><i class="fas fa-shopping-cart"></i></a></li>
                     <?php } ?>
                     
                     <li class="burger"><span></span></li>
					 
				

				</ul>
			</div>
		</div>
	</div>
	</header>