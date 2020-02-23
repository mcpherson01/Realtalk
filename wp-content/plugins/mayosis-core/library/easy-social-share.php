<?php
/*
 * Easy Social Share Buttons for WordPress - Custom files for Mayosis
 */

add_action('init', 'mayosis_custom_methods_register', 99);

add_filter('essb4_button_positions', 'mayosis_display_mycustom_position');
add_filter('essb4_button_positions_mobile', 'mayosis_display_mycustom_position');
add_filter('essb4_custom_positions', 'mayosis_display_register_mycustom_position');
add_filter('essb4_custom_method_list', 'mayosis_register_mycustom_position');

function mayosis_register_mycustom_position($methods) {
	$methods['mayosis_sidebar'] = __('Mayosis Vertical Float', 'mayosis');
	$methods['mayosis_products'] = __('Mayosis Product Bredcrumb', 'mayosis');
	$methods['mayosis_pbottom'] = __('Mayosis Product Bottom', 'mayosis');
	$methods['mayosis_photo'] = __('Mayosis Photo Template', 'mayosis');
	$methods['mayosis_productoverlay'] = __('Mayosis Grid Overlay', 'mayosis');
	return $methods;
}

function mayosis_custom_methods_register() {
	
	if (is_admin()) {
		if (class_exists('ESSBOptionsStructureHelper')) {
			essb_prepare_location_advanced_customization('where', 'mayosis_sidebar', 'mayosisfloatingposition');
			essb_prepare_location_advanced_customization('where', 'mayosis_products', 'mayosisproductbreadcrumb');
			
				essb_prepare_location_advanced_customization('where', 'mayosis_pbottom', 'mayosisproductbottom');
				
				essb_prepare_location_advanced_customization('where', 'mayosis_photo', 'mayosisphoto');
				
					essb_prepare_location_advanced_customization('where', 'mayosis_productoverlay', 'mayosisoverlay');
		
		}

	}
}

function mayosis_display_mycustom_position($positions) {
	
	$positions['mayosisfloatingposition'] = array ("image" => "assets/images/display-positions-09.png", "label" => __("Mayosis FLoating Position", "essb") );
	$positions['mayosisproductbreadcrumb'] = array ("image" => "assets/images/display-positions-09.png", "label" => __("Mayosis Product Breadcrumb", "essb") );
	
		$positions['mayosisproductbottom'] = array ("image" => "assets/images/display-positions-09.png", "label" => __("Mayosis Product Bottom", "essb") );
	$positions['mayosisphoto'] = array ("image" => "assets/images/display-positions-09.png", "label" => __("Mayosis Photo Template", "essb") );
	
	$positions['mayosisoverlay'] = array ("image" => "assets/images/display-positions-09.png", "label" => __("Mayosis Grid Overlay", "essb") );
	
	return $positions;
}

function mayosis_display_register_mycustom_position($positions) {
	$positions['mayosisfloatingposition'] = __('Mayosis Floating', 'mayosis');
	$positions['mayosisproductbreadcrumb'] = __('Mayosis Breadcrumb', 'mayosis');
	$positions['mayosisproductbottom'] = __('Mayosis Product Bottom', 'mayosis');
	$positions['mayosisphoto'] = __('Mayosis Photo Template', 'mayosis');
	
	$positions['mayosisoverlay'] = __('Mayosis Grid Overlay', 'mayosis');
}

if (!function_exists('mayosis_draw_custom_position')) {
	function mayosis_draw_custom_position($position) {
		if (function_exists('essb_core')) {
			$general_options = essb_core()->get_general_options();
			
			if (is_array($general_options)) {
				if (in_array($position, $general_options['button_position'])) {
					echo essb_core()->generate_share_buttons($position);
				}
			}
		}
	}
}

add_filter('essb4_templates', 'mayosis_social_template_initialze');

function mayosis_social_template_initialze($templates) {
	$templates['1002'] = 'Mayosis Sidebar Template';	
	return $templates;
}

add_filter('essb4_templates_class', 'mayosis_mytemplate_class', 10, 2);

function mayosis_mytemplate_class($class, $template_id) {
	if ($template_id == '1002') {
		$class = 'mayosis-essvb-template';
	}
	
	return $class;
}

 