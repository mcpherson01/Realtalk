<?php
function mayosis_header_elements($options, $type = ''){
    $get_options = get_theme_mod($options);
    if(is_array($get_options)) {

      foreach ($get_options as $key => $value) {

       if($value == 'code' || $value == 'code-2'){
              echo mayosis_header_code_element($value);
          } else if($value == 'nav-top'){
            get_template_part('includes/top-navigation');
          } else if($value == 'nav'){
             get_template_part('includes/main-navigation');
          }else if($value == 'nav-bottom'){
             get_template_part('includes/bottom-navigation');
          }else if($value == 'mobile'){
             get_template_part('includes/header/mobile-nav');
          }else if($value == 'accordion'){
             get_template_part('includes/accordion-menu');
             }else{
            get_template_part('includes/header/header-elements/header-'.$value, $type);
          }
          // Hooked Elements
          do_action('mayosis_header_elements', $value);
      } // foreach option
  }
}

function mayosis_option($option) {
	// Get options
	return get_theme_mod( $option );
}


function mayosis_header_code_element($value){
  if($value == 'code') $html = 'topbar_left';
  if($value == 'code-2') $html = 'topbar_right';
  if(mayosis_option($html)) echo '<ul class="code-blocks"><li class="html custom html_'.$html.'">'.do_shortcode(mayosis_option($html)).'</li></ul>';
}