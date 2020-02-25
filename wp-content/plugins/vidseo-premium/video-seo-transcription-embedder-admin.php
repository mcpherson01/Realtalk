<?php

require __DIR__ . '/vendor/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php';
add_action( 'admin_init', array( 'PAnD', 'init' ) );

class vidseo_settings
{
    function __construct()
    {
        // stuff to do when the plugin is loaded
        function vidseo_admin_styles()
        {
            wp_register_style(
                'vidseo_admin-styles',
                plugin_dir_url( __FILE__ ) . 'assets/vidseo-styles-admin.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/vidseo-styles-admin.css' )
            );
            wp_enqueue_style( 'vidseo_admin-styles' );

            wp_register_script(
                'vidseo_admin-script',
                plugin_dir_url( __FILE__ ) . 'assets/vidseo-script-admin.js',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/vidseo-script-admin.js' )
            );
            wp_enqueue_script( 'vidseo_admin-script' );

            wp_register_script(
                'vidseo_color-script',
                plugin_dir_url( __FILE__ ) . 'vendor/jscolor/jscolor.js',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'vendor/jscolor/jscolor.js' )
            );
            wp_enqueue_script( 'vidseo_color-script' );
        }
        
        add_action( 'admin_enqueue_scripts', 'vidseo_admin_styles' );
        
        add_action( 'admin_menu', array( &$this, 'vidseo_admin_menu' ) );
    }

    function vidseo_admin_menu()
    {
        add_options_page(
            'Video SEO Settings',
            'Video SEO',
            'manage_options',
            'vidseo',
            array( &$this, 'vidseo_settings_page' )
        );
    }
    
    // Settings function
    function vidseo_settings_page()
    {
        global  $vidseo ;
        $vidseo_options = $vidseo->vidseo_options();
        //set active class for navigation tabs
        if ( isset( $_GET['tab'] ) ) {
            $active_tab = $_GET['tab'];
        }
        // end if
        $active_tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'vidseo-settings' );
        // end active class
        
        // purchase notification
        $purchase_url = "options-general.php?page=vidseo-pricing";
        $get_pro = sprintf( wp_kses( __( '<a href="%s">Get Pro version</a> to enable', 'vidseo' ), array(
            'a' => array(
            'href'   => array(),
            'target' => array(),
        ),
        ) ), esc_url( $purchase_url ) );
        
        if ( isset( $_POST['update'] ) ) {
            // check if user is authorised
            if ( function_exists( 'current_user_can' ) && !current_user_can( 'manage_options' ) ) {
                die( 'Sorry, not allowed...' );
            }
            check_admin_referer( 'vidseo_settings' );
            $vidseo_safe = array(
                "hide_title",
                "disable_trans",
                "hide_trans",
                "vidseo_controller",
                "remove_settings",
            );

            // player width
            if (isset( $_POST['vidseo_width'] ))
                $vidseo_options['vidseo_width'] = sanitize_text_field( $_POST['vidseo_width'] );

            if ( vidseo_fs()->can_use_premium_code__premium_only())  {

                // title bg color
                if (isset( $_POST['vidseo_title_bg'] ))
                $vidseo_options['vidseo_title_bg'] = sanitize_text_field( $_POST['vidseo_title_bg'] );

                // title txt color
                if (isset( $_POST['vidseo_title_txt'] ))
                $vidseo_options['vidseo_title_txt'] = sanitize_text_field( $_POST['vidseo_title_txt'] );

                // trasncription bg color
                if (isset( $_POST['vidseo_trans_bg'] ))
                $vidseo_options['vidseo_trans_bg'] = sanitize_text_field( $_POST['vidseo_trans_bg'] );

                // trasncription txt color
                if (isset( $_POST['vidseo_trans_txt'] ))
                $vidseo_options['vidseo_trans_txt'] = sanitize_text_field( $_POST['vidseo_trans_txt'] );
       
                // hide transcript
                $vidseo_hide_trans = sanitize_text_field( $_POST['hide_trans'] );
                $vidseo_options['hide_trans'] = ( isset( $_POST['hide_trans'] ) && in_array( $vidseo_hide_trans, $vidseo_safe ) ? true : false );

            }

            // excerpt length
            if (isset( $_POST['vidseo_excerpt'] ))
                $vidseo_options['vidseo_excerpt'] = sanitize_text_field( $_POST['vidseo_excerpt'] );

            // hide title
            $vidseo_hide_title = sanitize_text_field( $_POST['hide_title'] );
            $vidseo_options['hide_title'] = ( isset( $_POST['hide_title'] ) && in_array( $vidseo_hide_title, $vidseo_safe ) ? true : false );

            // disable transcript
            $vidseo_disable_trans = sanitize_text_field( $_POST['disable_trans'] );
            $vidseo_options['disable_trans'] = ( isset( $_POST['disable_trans'] ) && in_array( $vidseo_disable_trans, $vidseo_safe ) ? true : false );

            // autoplay
            $vidseo_autoplay = sanitize_text_field( $_POST['vidseo_autoplay'] );
            $vidseo_options['vidseo_autoplay'] = ( isset( $_POST['vidseo_autoplay'] ) && in_array( $vidseo_autoplay, $vidseo_safe ) ? true : false );

            // captions
            $vidseo_captions = sanitize_text_field( $_POST['vidseo_captions'] );
            $vidseo_options['vidseo_captions'] = ( isset( $_POST['vidseo_captions'] ) && in_array( $vidseo_captions, $vidseo_safe ) ? true : false );

            // annotations
            $vidseo_annotations = sanitize_text_field( $_POST['vidseo_annotations'] );
            $vidseo_options['vidseo_annotations'] = ( isset( $_POST['vidseo_annotations'] ) && in_array( $vidseo_annotations, $vidseo_safe ) ? true : false );

            // controls
            $vidseo_controls = sanitize_text_field( $_POST['vidseo_controls'] );
            $vidseo_options['vidseo_controls'] = ( isset( $_POST['vidseo_controls'] ) && in_array( $vidseo_controls, $vidseo_safe ) ? true : false );

            // loop
            $vidseo_loop = sanitize_text_field( $_POST['vidseo_loop'] );
            $vidseo_options['vidseo_loop'] = ( isset( $_POST['vidseo_loop'] ) && in_array( $vidseo_loop, $vidseo_safe ) ? true : false );

            // modestbranding
            $vidseo_modestbranding = sanitize_text_field( $_POST['vidseo_modestbranding'] );
            $vidseo_options['vidseo_modestbranding'] = ( isset( $_POST['vidseo_modestbranding'] ) && in_array( $vidseo_modestbranding, $vidseo_safe ) ? true : false );

            // rel
            $vidseo_rel = sanitize_text_field( $_POST['vidseo_rel'] );
            $vidseo_options['vidseo_rel'] = ( isset( $_POST['vidseo_rel'] ) && in_array( $vidseo_rel, $vidseo_safe ) ? true : false );

            // fullscreen
            $vidseo_fullscreen = sanitize_text_field( $_POST['vidseo_fullscreen'] );
            $vidseo_options['vidseo_fullscreen'] = ( isset( $_POST['vidseo_fullscreen'] ) && in_array( $vidseo_fullscreen, $vidseo_safe ) ? true : false );

            // muted
            $vidseo_muted = sanitize_text_field( $_POST['vidseo_muted'] );
            $vidseo_options['vidseo_muted'] = ( isset( $_POST['vidseo_muted'] ) && in_array( $vidseo_muted, $vidseo_safe ) ? true : false );

            // vimeo title
            $vidseo_vimeo_title = sanitize_text_field( $_POST['vidseo_vimeo_title'] );
            $vidseo_options['vidseo_vimeo_title'] = ( isset( $_POST['vidseo_vimeo_title'] ) && in_array( $vidseo_vimeo_title, $vidseo_safe ) ? true : false );

            // vimeo author
            $vidseo_author = sanitize_text_field( $_POST['vidseo_author'] );
            $vidseo_options['vidseo_author'] = ( isset( $_POST['vidseo_author'] ) && in_array( $vidseo_author, $vidseo_safe ) ? true : false );

            // remove settings on plugin deactivation
            $vidseo_remove_settings = sanitize_text_field( $_POST['remove_settings'] );
            $vidseo_options['remove_settings'] = ( isset( $_POST['remove_settings'] ) && in_array( $vidseo_remove_settings, $vidseo_safe ) ? $vidseo_remove_settings : false );
            
            update_option( 'vidseo', $vidseo_options );

            // update options
            echo  '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html__( 'Settings saved.', 'vidseo' ) . '</strong></p></div>';
        }
        
        ?>

    <div class="wrap vidseo-containter">

        <h2><span class="dashicons dashicons-media-text" style="margin-top: 6px; font-size: 24px;"></span>VidSEO <?php echo  esc_html__( 'Settings', 'vidseo' ); ?></h2>

    <h2 class="nav-tab-wrapper">

        <a href="<?php echo esc_url( '?page=vidseo&tab=vidseo-settings' ); ?>" 
        class="nav-tab <?php echo  ( $active_tab == 'vidseo-settings' ? 'nav-tab-active' : '' ) ;
        ?>">Settings</a>
        
        <a href="<?php echo  esc_url( '?page=vidseo&tab=vidseo-recs' ); ?>" 
        class="nav-tab <?php echo  ( $active_tab == 'vidseo-recs' ? 'nav-tab-active' : '' ) ;
        ?>">Recommendations</a>

        <a href="<?php echo  esc_url( '?page=vidseo&tab=vidseo-youtube' ); ?>" 
        class="nav-tab <?php echo  ( $active_tab == 'vidseo-youtube' ? 'nav-tab-active' : '' ) ;
        ?>">Get Youtube Video Transcription</a>

    </h2>

    <?php 
    
        if ( $active_tab == 'vidseo-settings' ) {
        
    ?>

    <!-- Start Settings -->
    <div class="vidseo-row">

        <!-- Start Main Settings Column -->
        <div class="vidseo-column col-9">

            <div class="vidseo-main">

                <form method="post">

                    <?php  if ( function_exists( 'wp_nonce_field' ) ) { 
                        wp_nonce_field( 'vidseo_settings' );
                    } 
                    
                    // Include all ui files
                    $file_names = array(
                        'step-1',
                        'step-2',
                        'step-2-youtube',
                        'step-2-vimeo',
                        'step-3-4',
                        'delete',
                    );

                    foreach ( $file_names as $name ) {
                        include_once dirname( __FILE__ ).'/admin-ui-inc/' . $name . '.php';
                    }
 
                    ?>
             
                
                <p class="submit"><input type="submit" name="update" class="button-primary" value="<?php 
                echo  esc_html__( 'Save Changes', 'vidseo' ) ;
                ?>" /></p>

                </form>
            
                        
                <div class="vidseo-note">
                    <p><?php 
                    echo  esc_html__( 'Note: Please check plugin documentation for more details about shortcode parameters and global settings', 'vidseo' ) ;
                    ?></p>
                </div>

    
        </div> <!-- End vidseo-main -->
    
    </div> <!-- End main settings vidseo-column col-8 -->

    <?php 

        // Sidebar
        include dirname( __FILE__ ) . '/inc/sidebar.php'; }


        if ( $active_tab == 'vidseo-recs' ) {
            
            include dirname( __FILE__ ) . '/inc/recommendations.php';

        }

        if ( $active_tab == 'vidseo-youtube' ) {
            
            include dirname( __FILE__ ) . '/inc/youtube-trans.php';

        }
        
    ?>

</div>

    <?php 
    
    }

}
// End Settings class

$vidseo_settings = new vidseo_settings();

// Add the custom column for shortcode
add_filter( 'manage_vidseo_posts_columns', 'vidseo_column' );
function vidseo_column($columns) {
    $columns['vidseo_shortcode'] = __( 'Shortcode', 'vidseo' );
    return $columns;
}

// Add shortcode to the custom column
add_action( 'manage_vidseo_posts_custom_column' , 'custom_book_column', 10, 2 );
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {

        case 'vidseo_shortcode' :
            echo '[vidseo id="' . $post_id . '""]'; 
            break;

    }
}


if ( is_admin() ) {
    include_once dirname( __FILE__ ) . '/admin-ui-inc/metabox.php';
}