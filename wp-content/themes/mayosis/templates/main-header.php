<?php
defined('ABSPATH') or die();

/**
 * The Main Header Style
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage mayosis
 * @since mayosis 1.0
 */
$mainlogomain= get_theme_mod( 'main_logo' );
$showtopheadermain= get_theme_mod( 'top_header_show','off' );
$headertransparentmain= get_theme_mod( 'header_transparency','transparent' );
$mainlogohide= get_theme_mod( 'logo_hide','on' );
$headermenuposition= get_theme_mod( 'menu_position','right' );
$stickylogomain= get_theme_mod( 'sticky_logo','https://teconce.com/preview/mayosis/maindemo/wp-content/uploads/2018/04/Mayosis-Logo-Color.png');
?> 

<!-- Begin Header Layout --> 
<?php if($headertransparentmain == 'transparent') :?>
	 <header id="header" class="main-header headroom container-fluid animated hidden-xs hidden-sm header-transparent">
	<?php else :?>
		<header id="header" class="main-header headroom container-fluid animated hidden-xs hidden-sm ">
	<?php endif; ?>
		<?php if($showtopheadermain =='on') :{
 get_template_part( 'includes/top-header' ); 
	}
	endif; ?>
    <div class="header-content-wrap row">
	 		<div class="container">
	 			<div class="row mayosis-flex">
	 			     <?php if($mainlogomain) :?>
	 			    <?php if($mainlogohide == 'on') :?>
	 			<div class="site-logo no-padding-right mayosis-flex-grid">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($mainlogomain);  ?>" class="img-responsive main-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
						<?php if ($stickylogomain): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($stickylogomain); ?>" class="img-responsive sticky-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
						 <?php endif; ?>
	 				</div>
	 			<?php endif; ?>
	 			<?php else: ?>
	 			    <div class="site-logo no-padding-right mayosis-flex-grid">
    	 			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-white.png" class="img-responsive main-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
    	 				</div>
	 			<?php endif; ?>
	 			<?php if($headermenuposition == 'right') :?>
	 			<div class="main-menu main-menu-postion-right no-padding-right mayosis-flex-grid middle-flex-grid">
	 			<?php else:?>
	 			<div class="main-menu  no-padding-right mayosis-flex-grid middle-flex-grid">
	 			<?php endif; ?>
	 			
	 					<?php get_template_part( 'includes/main-navigation' ); ?>
	 					
	 				</div><!-- .End Main Menu -->
	 				<div class="search-main_none main-cart-bar no-padding-left mayosis-flex-grid">
	 				    
   				<ul id="cart-menu" class="mayosis-option-menu pull-right">
					<?php get_template_part( 'includes/header-cart-meta' ); ?>
    			</ul>
    				</div>
	 			
	 			</div>
	 		</div>
            </div>
            </div>
	 	</header>
	 <!-- End Header Layout --> 
	  <div id="mayosis-main-content">
	 	<?php get_template_part( 'includes/mobile-header' ); ?>