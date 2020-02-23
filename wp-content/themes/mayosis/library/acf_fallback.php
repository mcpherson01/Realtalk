<?php
  function acf_fallback(){
    //https://www.advancedcustomfields.com/resources/#functions
    $acf_functions = array(
      'get_field',
      'the_field',
    );
    
    // ACF Plugin fallback
    //!is_plugin_active( 'advanced-custom-fields/acf.php' )
    if( !is_admin() && !function_exists('get_field') ){//!function_exists('get_field')
        function get_field($field = '', $id = false) {
          return false;
        }
        function the_field($field = '', $id = false) {
          return false;
        }
        function have_rows($field = '', $id = false) {
          return false;
        }
        function has_sub_field($field = '', $id = false) {
          return false;
        }
        function get_sub_field($field = '', $id = false) {
          return false;
        }
        function the_sub_field($field = '', $id = false) {
          return false;
        }
    }
  }
  add_action( 'init', 'acf_fallback' );