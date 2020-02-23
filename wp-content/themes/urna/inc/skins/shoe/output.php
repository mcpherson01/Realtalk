<?php if ( ! defined('URNA_THEME_DIR')) exit('No direct script access allowed');

$theme_primary = require_once( get_parent_theme_file_path( URNA_INC . '/class-primary-color.php') );

/*For example $main_color_skin 	= '.top-info > .widget'; */
$main_color_skin 	= '.has-after:hover,button.btn-close:hover,.new-input + span:before,.new-input + label:before,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:focus > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li.active > a,#tbay-header .header-main .header-right .tbay-login:hover > a,#tbay-header .header-main .header-right .top-cart .cart-icon:hover > i,#tbay-header .header-main .header-right .top-cart .cart-icon:focus > i,.tbay-footer .contact-info ul li a:hover,.tparrows.revo-tbay:hover::before,.tbay-addon .owl-carousel > .slick-arrow:hover,.tbay-addon .owl-carousel > .slick-arrow:focus,.tbay-addon-features .ourservice-heading:hover ';  
$main_bg_skin 		= '.has-after:after,.tbay-homepage-demo .tbay-addon-products:not(.tbay-addon-vertical) .show-all:hover , .btn-theme-2,.tbay-to-top a:hover ';
$main_border_skin 	= '.btn-theme-2,.tbay-to-top a:hover,.tbay-homepage-demo .tbay-addon-products:not(.tbay-addon-vertical) .show-all:hover ';


$main_color 			= $theme_primary['color']; 
$main_bg 				= $theme_primary['background'];
$main_border 			= $theme_primary['border'];
$main_top_border 		= $theme_primary['border-top-color'];
$main_right_border 		= $theme_primary['border-right-color'];
$main_bottom_border 	= $theme_primary['border-bottom-color'];
$main_left_border 		= $theme_primary['border-left-color'];

if( !empty($main_color_skin) ) {
	$main_color 	= $main_color . ',' . $main_color_skin; 
}
if( !empty($main_bg_skin) ) {
	$main_bg 	= $main_bg. ',' .$main_bg_skin; 
}
if( !empty($main_border_skin) ) {
	$main_border 	= $main_border. ',' .$main_border_skin; 
}


/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();


/*CustomMain color*/
$output['main_color'] = array( 
	'color' => urna_texttrim($main_color),
	'background-color' => urna_texttrim($main_bg),
	'border-color' => urna_texttrim($main_border),
);
if( !empty($main_top_border) ) {

	$bordertop = array(
		'border-top-color' => urna_texttrim($main_top_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$bordertop);
}
if( !empty($main_right_border) ) {
	
	$borderright = array(
		'border-right-color' => urna_texttrim($main_right_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderright);
}
if( !empty($main_bottom_border) ) {
	
	$borderbottom = array(
		'border-bottom-color' => urna_texttrim($main_bottom_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderbottom);
}
if( !empty($main_left_border) ) {
	
	$borderleft = array(
		'border-left-color' => urna_texttrim($main_left_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderleft);
}

/*Custom Fonts*/
$output['primary-font'] = array('body, p, .btn, .button, .rev-btn, .rev-btn:visited');
$output['secondary-font'] = array('h1, h2, h3, h4, h5, h6, .widget-title');

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
	'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.topbar, .content');
$output['topbar_link_color'] 			= array('.content a, .tbay-login a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after');

$output['topbar_link_color_hover'] = array( 
	'color' => urna_texttrim('.top-contact .content a:hover, .tbay-login a:hover, .tbay-login .dropdown .account-menu ul li a:hover'),
	'background-color' => urna_texttrim('.top-contact .content a:after'),
);

/*Custom Header*/
$output['header_bg'] 					= array(
	'background'=> urna_texttrim('#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a,#tbay-header .header-main .header-right .tbay-login > a,#tbay-header .header-main .header-right .top-cart .cart-icon,
.tbay-search-form .button-search.icon');

$output['header_link_color_active'] = array( 
	'color' => urna_texttrim('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li.active > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a:hover,
	#tbay-header .header-main .header-right .tbay-login > a:hover,#tbay-header .header-main .header-right .top-cart .cart-icon:hover i'),
	'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
	'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a:hover,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
	'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newletter) .tbay-addon-title,.tbay-footer .tbay-addon-newletter.tbay-addon > h3');
$output['footer_text_color'] 			= array('.tbay-footer .content-ft p, .tbay-footer .contact-info li');
$output['footer_link_color'] 			= array('.tbay-footer .social.style3 li a,.tbay-footer a, .tbay-footer .menu li > a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .social.style3 li a:hover, .tbay-footer a:hover, .tbay-footer .menu li > a:hover, .tbay-footer .contact-info ul li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
	'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a, .tbay-addon-newletter.tbay-addon .input-group .input-group-btn:after');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover');

/*Background hover*/
$output['background_hover']  	= $theme_primary['background_hover'];
/*Tablet*/
$output['tablet_color'] 	 	= $theme_primary['tablet_color'];
$output['tablet_background'] 	= $theme_primary['tablet_background'];
$output['tablet_border'] 		= $theme_primary['tablet_border'];
/*Mobile*/
$output['mobile_color'] 		= $theme_primary['mobile_color'];
$output['mobile_background'] 	= $theme_primary['mobile_background'];
$output['mobile_border'] 		= $theme_primary['mobile_border'];

return apply_filters( 'urna_get_output', $output);
