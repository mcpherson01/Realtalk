<?php
/**
 * Get Template Settings
 *
 * @since  2.5
 */
 
 $templateautomationtype= get_theme_mod( 'product_template_autmation_main','single-download');
$wholesitetem= get_theme_mod( 'whole_site_product_template','');

 if ($templateautomationtype == 'allcat'){
     if( $wholesitetem == 'photo' ){
    add_filter( 'template_include', 'mayosis_download_template', 99 );

    function mayosis_download_template( $template ) {
        if ( is_singular( 'download' )  ) {
            // change the default-download-template.php to your template name
            $default_template = locate_template( array( 'download-photo-template.php' ) );
            if ( '' != $default_template ) {
                return $default_template ;
            }
        }

        return $template;
    }
    
     } elseif( $wholesitetem == 'multi' ) {
          add_filter( 'template_include', 'mayosis_download_template', 99 );

    function mayosis_download_template( $template ) {
        if ( is_singular( 'download' )  ) {
            // change the default-download-template.php to your template name
            $default_template = locate_template( array( 'prime-download-template.php' ) );
            if ( '' != $default_template ) {
                return $default_template ;
            }
        }

        return $template;
    }
         
         
     } elseif( $wholesitetem == 'full' ) {
         
          add_filter( 'template_include', 'mayosis_download_template', 99 );

    function mayosis_download_template( $template ) {
        if ( is_singular( 'download' )  ) {
            // change the default-download-template.php to your template name
            $default_template = locate_template( array( 'full-width-download-template.php' ) );
            if ( '' != $default_template ) {
                return $default_template ;
            }
        }

        return $template;
    }
     } elseif( $wholesitetem == 'narrow' ) {
         
          add_filter( 'template_include', 'mayosis_download_template', 99 );

    function mayosis_download_template( $template ) {
        if ( is_singular( 'download' )  ) {
            // change the default-download-template.php to your template name
            $default_template = locate_template( array( 'narrow-download-template.php' ) );
            if ( '' != $default_template ) {
                return $default_template ;
            }
        }

        return $template;
    }
     }
     add_action( 'admin_menu', 'mayosis_restrict_access' );
function mayosis_restrict_access() {
 remove_meta_box( 'pageparentdiv', 'download','normal' );
}
}