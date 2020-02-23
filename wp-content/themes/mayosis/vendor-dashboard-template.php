<?php
/**
 * Template Name: Extended Dashboard(User & Vendor)
 *
 * Vendor Dashboard
 *
 * @package mayosis-digital-marketplace-theme
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} 
get_header('blank');
$user_id  = empty( $user_id ) ? get_current_user_id() : $user_id;
$vendor =new FES_Vendor( $user_id ,true );
$user=wp_get_current_user();
$loginlogo= get_theme_mod( 'login_page_logo', get_template_directory_uri().'/images/logo.png' );

?>

  <?php $mayosis_bg_color = get_post_meta($post->ID, 'page_bg_color',true); ?>
 <div class="vendor-dasboard-template-main" style="background-color:<?php echo esc_html($mayosis_bg_color); ?>; background-image:url(<?php echo esc_url( get_post_meta( get_the_ID(), 'w_page_bg', true ) ); ?>);">


<?php if ( is_user_logged_in() ) { ?>
<?php if ( EDD_FES()->vendors->user_is_status( 'approved' )){ ?>
<?php echo do_shortcode('[fes_vendor_dashboard]');?>
	<?php } else { ?>
<div class="user-extended-dasboard">
     <?php get_template_part( 'templates/user-dashboard' ); ?>
    
</div>
	<?php } ?>
<?php } else {?>
<div class="container extended-dashboard-login">
    <div class="col-md-12">
          <div class="logo-dashboard">
        
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo_box">
                   <img src="<?php echo esc_url($loginlogo);  ?>" class="img-responsive login-logo" alt="<?php esc_html( 'Logo', 'mayosis' ); ?>"/>
                  </a>
    </div>
    </div>
    <div class="col-md-4 col-xs-12">
    <?php echo do_shortcode('[edd_login]');?>
    </div>
</div>
<?php }?>
					
</div>
<?php get_footer('blank'); ?>