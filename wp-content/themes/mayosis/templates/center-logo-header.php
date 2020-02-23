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
$mainlogo= get_theme_mod( 'main_logo' );
$showtopheader= get_theme_mod( 'top_header_show','off' );
$headertransparent= get_theme_mod( 'header_transparency' ,'normal');
$leftmenupos= get_theme_mod( 'left_menu_position','left' );
$rightmenupos= get_theme_mod( 'right_menu_position','right' );
$leftoptiontype= get_theme_mod( 'left_option','menu' );
$rightoptiontype= get_theme_mod( 'right_option','menu' );
$rightsideoptionmenu= get_theme_mod( 'right_side_option_menu','on' );
$stickylogomain= get_theme_mod( 'sticky_logo');
?> 

<?php if($headertransparent == 'transparent') :?>
<header id="header" class="main-header headroom center-logo-header container-fluid animated hidden-xs hidden-sm header-transparent">
    <?php else :?>
    <header id="header" class="main-header headroom center-logo-header container-fluid animated hidden-xs hidden-sm">
    <?php endif; ?>
    <?php if($showtopheader =='on') :{
 get_template_part( 'includes/top-header' ); 
	}
	endif; ?>
    <div class="header-content-wrap row">
    <div class="container">
<div class="center-logo-nav">
    <?php if($leftmenupos == 'right') :?>
    <div class="center-left-menu nav-position-right">
        <?php else: ?>
         <div class="center-left-menu">
        <?php endif; ?>
         <?php if($leftoptiontype == 'menu') :?>
            <?php get_template_part( 'includes/center-left-nav' ); ?>
            <?php elseif($leftoptiontype == 'hamburger') : ?>
                <ul class="desktop-hamburger">
                      <?php get_template_part( 'includes/hamburger' ); ?>
                </ul>
            <?php endif; ?>
    </div>
    <div class="center-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($mainlogo);  ?>" class="img-responsive main-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
        <?php if ($stickylogomain): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($stickylogomain); ?>" class="img-responsive sticky-logo" alt="<?php esc_html__( 'Logo', 'mayosis' ); ?>"/></a>
						 <?php endif; ?>
    </div>
    <?php if($rightmenupos == 'right') :?>
    <div class="center-right-menu nav-position-right">
        <?php else: ?>
          <div class="center-right-menu nav-position-left">
        <?php endif; ?>
        <?php if($rightoptiontype == 'menu') :?>
            <?php get_template_part( 'includes/center-right-nav' ); ?>
        <?php elseif($rightoptiontype == 'hamburger') : ?>
            <ul class="desktop-hamburger">
          <?php get_template_part( 'includes/hamburger' ); ?>
          </ul>
        <?php endif; ?>
        <?php if($rightsideoptionmenu == 'on') :?>
            <ul id="cart-menu" class="mayosis-option-menu">
    					<?php get_template_part( 'includes/header-cart-meta' ); ?>
    					 
        			</ul>
        <?php endif; ?>
    </div>
    </div>
</div>
</div>
</div>
</div>
    
    </header>
     <div id="mayosis-main-content">
    <?php get_template_part( 'includes/mobile-header' ); ?>