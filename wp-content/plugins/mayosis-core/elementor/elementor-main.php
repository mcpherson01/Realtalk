<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'MAYOSIS_ELEMENTOR_URL', plugins_url( '/', __FILE__ ) );
define( 'MAYOSIS_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );


require_once MAYOSIS_ELEMENTOR_PATH.'inc/elementor-cat.php';

function MAYOSIS_elementor_elements(){

   // load elements
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/recent-post.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/icon-box.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/single-button.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/dual-button.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/client-logo.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/theme-hero.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/theme-testimonial.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/pricing-table.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/search.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/counter.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/team-member.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/contact-infobox.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/license.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/subscribe.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/object.php';
    require_once MAYOSIS_ELEMENTOR_PATH.'widgets/search-terms.php';
    if (class_exists('Easy_Digital_Downloads')):
        require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-featured.php';
        require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-recent.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-grid.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-hero.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-login.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-register.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-masonary.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-justified.php';
         require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-category.php';
          require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-popular.php';
          require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-hero-block.php';
    endif;
    
    if ( class_exists( 'EDD_Front_End_Submissions' ) ){
        require_once MAYOSIS_ELEMENTOR_PATH.'widgets/edd-author.php';
    }
}
add_action('elementor/widgets/widgets_registered','MAYOSIS_elementor_elements');
