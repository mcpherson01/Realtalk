<?php
/* Button shortcode function */
function button_shortcode( $atts, $content = null ) {

    $classes[] = '';

    $target = '';

    $atts = shortcode_atts(array(
      'link'  => null,
      'new_tab' => false,
      'color' => 'default',
      'size'  => 'medium',
      'style' => 'default',
      'width' => 'normal',
      'hover' => 'bright',
      'color' => 'purple',
      'shape' => 'smooth',
        
        'custom_class' => null,
    ), $atts, 'button' );

    foreach ( $atts as $key => $att ) {

        if( $key !== 'link' && $key !== 'new_tab' && $key !== 'custom_class' &&  $att !== null && $att !== '' && $att !== 'default' ) {
            $classes[] = 'button_' . strtolower( esc_attr( $att ) );
        }

        if( $key == 'custom_class' ) {
            $classes[] = esc_attr( $att );
        }

        if( $key == 'new_tab' && false !== $att && "false" !== $att ) {
            $target = 'target="_blank"';
        }

    }

   return '<a class="margin-bottom-30 button ' . implode( $classes, " " ) . '" href="' . esc_url( $atts['link'] ) . '" ' . $target . '>' . do_shortcode( $content ) . '</a>';

}
add_shortcode( 'button', 'button_shortcode' );


function mayosis_tinymce_buttons() {

    if ( is_admin() && current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
      add_filter( 'mce_external_plugins', 'mayosis_add_buttons' ); // hooks plugin to TinyMCE
      add_filter( 'mce_buttons', 'mayosis_register_buttons' ); // used to show which buttons to show on TinyMCE
    }

}
add_action( 'init', 'mayosis_tinymce_buttons' );

/* add custom button to wp editor */
function mayosis_add_buttons( $plugin_array ) {

    $plugin_array['mayosis'] = plugins_url( '/js/mayosis-button-shortcode.js', __FILE__ ); // mayosisButtonShortcode is the plugin ID
    return $plugin_array;

}

function mayosis_register_buttons( $buttons ) {

    array_push( $buttons, '|', 'buttonshortcode' ); // buttonshortcode is the button ID
    return $buttons;

}

/**
 * Localize Script
 */
function  mayosis_admin_head() {
  $plugin_url = plugins_url( '/', __FILE__ );
  ?>
  <!-- TinyMCE Shortcode Plugin -->
  <script type='text/javascript'>
  var lbdbs_plugin = {
      'url': '<?php echo $plugin_url; ?>',
  };
  </script>
  <!-- TinyMCE Shortcode Plugin -->
  <?php
}
add_action( "admin_head", 'mayosis_admin_head' );
