<?php
/**
 Based on EDD USER Profile
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'EDD_User_Profiles' ) ) {

    /**
     * Main EDD_User_Profiles class
     *
     * @since       1.0.0
     */
    class EDD_User_Profiles {

        /**
         * @var         EDD_User_Profiles $instance The one true EDD_User_Profiles
         * @since       1.0.0
         */
        private static $instance;

        /**
         * @var         EDD_User_Profiles_Page $page
         * @since       1.0.0
         */
        public $page;

        /**
         * @var         EDD_User_Profiles_Editor $editor
         * @since       1.0.0
         */
        public $editor;

        /**
         * @var         array $plugins
         * @since       1.0.0
         */
        public $plugins;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true EDD_User_Profiles
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new EDD_User_Profiles();
                self::$instance->setup_constants();
                self::$instance->includes();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'EDD_USER_PROFILES_VER', '1.0.0' );

            // Plugin path
            define( 'EDD_USER_PROFILES_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'EDD_USER_PROFILES_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            require_once EDD_USER_PROFILES_DIR . 'includes/ajax.php';
            require_once EDD_USER_PROFILES_DIR . 'includes/hooks.php';
            require_once EDD_USER_PROFILES_DIR . 'includes/scripts.php';
            require_once EDD_USER_PROFILES_DIR . 'includes/shortcodes.php';

            require_once EDD_USER_PROFILES_DIR . 'includes/classes/class-page.php';
            require_once EDD_USER_PROFILES_DIR . 'includes/classes/class-editor.php';

            $this->page = new EDD_User_Profiles_Page();
            $this->editor = new EDD_User_Profiles_Editor();

            // Load files based on active plugins
            $this->plugins = array();

           
        }


        public function get_avatar_size() {
            return apply_filters( 'edd_user_profiles_avatar_size' , array( 100, 100 ) );
        }

        /**
         * Get an attachment ID given a URL.
         *
         * @param string $url
         *
         * @return int Attachment ID on success, 0 on failure
         */
        public function get_attachment_id( $url ) {
            $attachment_id = 0;
            $dir = wp_upload_dir();

            if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
                $file = basename( $url );

                $query_args = array(
                    'post_type'   => 'attachment',
                    'post_status' => 'inherit',
                    'fields'      => 'ids',
                    'meta_query'  => array(
                        array(
                            'value'   => $file,
                            'compare' => 'LIKE',
                            'key'     => '_wp_attachment_metadata',
                        ),
                    )
                );

                $query = new WP_Query( $query_args );

                if ( $query->have_posts() ) {
                    foreach ( $query->posts as $post_id ) {
                        $meta = wp_get_attachment_metadata( $post_id );
                        $original_file       = basename( $meta['file'] );
                        $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

                        if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                            $attachment_id = $post_id;
                            break;
                        }
                    }
                }
            }
            return $attachment_id;
        }
    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true EDD_User_Profiles
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_User_Profiles The one true EDD_User_Profiles
 */
function edd_user_profiles() {
    return EDD_User_Profiles::instance();
}
add_action( 'plugins_loaded', 'edd_user_profiles' );
