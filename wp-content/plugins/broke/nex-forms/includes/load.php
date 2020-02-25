<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include_once( 'classes/class.install.php');
include_once( 'classes/class.db.php');
include_once( 'classes/class.functions.php');
include_once( 'classes/class.export.php');
include_once( 'classes/class.icons.php');
include_once( 'classes/class.googlefonts.php');
include_once( 'classes/class.dashboard.php');
include_once( 'classes/class.builder.php');
include_once( 'classes/class.preferences.php');

function enqueue_nf_admin_scripts($hook) {
   
	wp_enqueue_script('jquery');
	wp_enqueue_style('jquery-ui');
	wp_enqueue_style('nf-jquery-ui','https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
	
	wp_enqueue_script('nf-jquery-ui','https://code.jquery.com/ui/1.12.1/jquery-ui.js');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_script('jquery-form');

	/* Custom Includes */
	if($hook=='toplevel_page_nex-forms-dashboard')
		{
		wp_enqueue_script('nex-forms-charts',plugins_url( '/nf-admin/js/chart.min.js',dirname(__FILE__)));
		wp_enqueue_script('nex_forms-materialize.min',plugins_url('/nf-admin/js/materialize.js',dirname(__FILE__)));
		wp_enqueue_script('formilise-js-init',plugins_url('/nf-admin/js/dashboard.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-global-settings',plugins_url('/nf-admin/js/global-settings.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-pref',plugins_url('/nf-admin/js/preferences.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-admin-functions',plugins_url('/nf-admin/js/admin-functions.js',dirname(__FILE__)));
		//EXTERNAL
		wp_enqueue_script('nex-forms-gcharts','https://www.gstatic.com/charts/loader.js');
		}
		
	if($hook=='nex-forms_page_nex-forms-builder')
		{
		wp_enqueue_script('nex-forms-builder',plugins_url('/nf-admin/js/builder.js',dirname(__FILE__)));		
		wp_enqueue_script('nex_forms-materialize.min',plugins_url('/nf-admin/js/materialize.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-bootstrap.min',plugins_url('/nf-admin/js/bootstrap-admin.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-bootstrap-tour.min',plugins_url('/nf-admin/js/bootstrap-tour.min.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-drag-and-drop',plugins_url('/nf-admin/js/drag-and-drop.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-field-settings',plugins_url('/nf-admin/js/field-settings.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-admin-functions',plugins_url('/nf-admin/js/admin-functions.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-bootstrap.colorpickersliders',plugins_url('/nf-admin/js/bootstrap.colorpickersliders.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-tinycolor-min',plugins_url('/nf-admin/js/tinycolor-min.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-conditional-logic',plugins_url('/nf-admin/js/conditional_logic.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-wow',plugins_url('/nf-admin/js/wow.min.js',dirname(__FILE__)));
		//FRONT+BACK
		
		/* BS DATETIME */
		wp_enqueue_script('nex-forms-moment.min', plugins_url('/js/moment.min.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-locales.min',plugins_url('/js/locales.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-date-time',plugins_url('/js/bootstrap-datetimepicker.js',dirname(__FILE__)));
		
		
		wp_enqueue_script('nex-forms-raty',plugins_url('/js/jquery.raty-fa.js',dirname(__FILE__)));
		wp_enqueue_script('nex-forms-fields',plugins_url('/js/fields.js',dirname(__FILE__)));
		//wp_enqueue_script('nf-nouislider',plugins_url('/js/nouislider.js',dirname(__FILE__)));
		wp_enqueue_script('bootstrap-material-datetimepicker', plugins_url( '/js/bootstrap-material-datetimepicker.js',dirname(__FILE__)));
		
		wp_enqueue_script('jqui-timepicker', plugins_url( '/js/jqui-timepicker.js',dirname(__FILE__)));
		
		wp_enqueue_script('nex-forms-bootstrap.touchspin', plugins_url( '/js/jquery.bootstrap-touchspin.js',dirname(__FILE__)));
		
		
		//wp_enqueue_script('bootstrap-timepicker', plugins_url( '/js/wickedpicker.js',dirname(__FILE__)));
		
		}
}

function enqueue_nf_admin_styles($hook) {
	/* CSS */
	if($hook=='toplevel_page_nex-forms-dashboard')
		{
		wp_enqueue_style('nex_forms-materialize.min',plugins_url('/nf-admin/css/materialize-dashboard.css',dirname(__FILE__)));
		wp_enqueue_style('nex_forms-bootstrap.min',plugins_url('/nf-admin/css/bootstrap.min.css',dirname(__FILE__)));
		wp_enqueue_style('nex_forms-dashboard',plugins_url('/nf-admin/css/dashboard.css',dirname(__FILE__)));
		//FRONT+BACK
		wp_enqueue_style('nex_forms-font-awesome.min',plugins_url('/css/font-awesome.min.css',dirname(__FILE__)));
		//EXTERNAL
		wp_enqueue_style('google-roboto', 'https://fonts.googleapis.com/css?family=Roboto');
		wp_enqueue_style('nex_forms-material-icons','https://fonts.googleapis.com/icon?family=Material+Icons');
		}
	if($hook=='nex-forms_page_nex-forms-builder')
		{
		wp_enqueue_style('nex_forms-builder',plugins_url('/nf-admin/css/builder.css',dirname(__FILE__)));
		wp_enqueue_style('nex_forms-bootstrap.min',plugins_url('/nf-admin/css/bootstrap.min.css',dirname(__FILE__)));
		wp_enqueue_style('nex-forms-bootstrap-tour.min',plugins_url('/nf-admin/css/bootstrap-tour.min.css',dirname(__FILE__)));
		
		wp_enqueue_style('nex-forms-admin-bootstrap.colorpickersliders',plugins_url('/nf-admin/css/bootstrap.colorpickersliders.css',dirname(__FILE__)));
		//FRONT+BACK
		wp_enqueue_style('nex-forms-animate',plugins_url('/css/animate.css',dirname(__FILE__)));
		wp_enqueue_style('nex-forms-fields',plugins_url('/css/fields.css',dirname(__FILE__)));
		wp_enqueue_style('nex-forms-ui',plugins_url('/css/ui.css',dirname(__FILE__)));
		wp_enqueue_style('nex_forms-font-awesome.min',plugins_url('/css/font-awesome.min.css',dirname(__FILE__)));
		wp_enqueue_style('nex_forms-materialize.min',plugins_url('/css/materialize-ui.css',dirname(__FILE__)));
		wp_enqueue_style('nf-md-checkbox-radio',plugins_url('/css/material-checkboxradio.css',dirname(__FILE__)));
		
		wp_enqueue_style('nf-nouislider',plugins_url('/css/nouislider.css',dirname(__FILE__)));
		wp_enqueue_style('bootstrap-material-datetimepicker', plugins_url( '/css/bootstrap-material-datetimepicker.css',dirname(__FILE__)));
		
		wp_enqueue_style('jqui-timepicker', plugins_url( '/css/jqui-timepicker.css',dirname(__FILE__)));
		//wp_enqueue_style('bootstrap-timepicker', plugins_url( '/css/wickedpicker.css',dirname(__FILE__)));
		//wp_enqueue_style('nex-forms-jQuery-UI',plugins_url( '/css/jquery-ui.min.css',dirname(__FILE__)));
		//EXTERNAL
		wp_enqueue_style('google-roboto', 'https://fonts.googleapis.com/css?family=Roboto');
		wp_enqueue_style('nex_forms-material-icons','https://fonts.googleapis.com/icon?family=Material+Icons');
		
		}
}
add_action( 'admin_enqueue_scripts', 'enqueue_nf_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'enqueue_nf_admin_styles' );

?>