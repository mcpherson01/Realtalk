<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class mayosis_edd_register_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'mayosis-edd-register';
   }

   public function get_title() {
      return __( 'Mayosis Register', 'mayosis' );
   }
public function get_categories() {
		return [ 'mayosis-ele-cat' ];
	}
   public function get_icon() { 
        return 'eicon-elementor';
   }

   protected function _register_controls() {

      $this->add_control(
         'section_edd_register',
         [
            'label' => __( 'mayosis EDD Resiter', 'mayosis' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
      $this->add_control(
        'image',
        [
           'label' => __( 'Register Logo', 'mayosis' ),
           'type' => Controls_Manager::MEDIA,
           'section' => 'section_edd_register',
        ]
     );
     
     $this->add_control(
         'register-title',
         [
            'label' => __( 'Register Title', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter After Regsiter Title', 'mayosis' ),
            'section' => 'section_edd_register',
         ]
      );
      $this->add_control(
         'url',
         [
            'label' => __( 'After Registration Redirect Url', 'mayosis' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __( 'Enter After Regeistration Redirect Url', 'mayosis' ),
            'section' => 'section_edd_register',
         ]
      );

      $this->add_control(
        'reg_url',
        [
           'label' => __( 'Login Url', 'mayosis' ),
           'type' => Controls_Manager::TEXT,
           'default' => '',
           'title' => __( 'Enter After Login Url', 'mayosis' ),
           'section' => 'section_edd_register',
        ]
     );
       
      

   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

       $settings = $this->get_settings();
       $image = $this->get_settings( 'image' );
       $redirect_url= $this->get_settings( 'url' );
       $registration_url= $this->get_settings( 'reg_url' );
       $registertitle= $this->get_settings( 'register-title' );
      ?>


<div class="mayosis-modern-login">
            <?php if ($image['url']){ ?>
            <div class="login-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $image['url']; ?>" class="img-responsive center-block" alt="login-img"></a></div>
            <?php } ?>
              <?php if (! is_user_logged_in() ) { ?>
            <?php if($registertitle){ ?>
            <h3><?php echo esc_html($registertitle);?></h3>
            <?php } ?>
            <?php } ?>
            <?php if ($redirect_url){ ?>
                <?php echo do_shortcode(' [edd_register redirect="'.$redirect_url.'"]'); ?>
            <?php } else { ?>
                <?php echo do_shortcode(' [edd_register]'); ?>
            <?php } ?>
            <?php if ( is_user_logged_in() ) { ?>
            <?php } else {?>
                <?php if ($registration_url){ ?>
            <a class="sigining-up" href="<?php echo esc_attr($registration_url); ?>"><?php esc_html_e('Already Registered ! Login','mayosis'); ?></a>
           <?php } ?>

            <?php } ?>
          </div>



      <?php

   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new mayosis_edd_register_Elementor_Thing );
?>