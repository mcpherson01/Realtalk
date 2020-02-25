<?php

/*
* Plugin Name: VidSEO - Video SEO Embedder with Transcription Pro
* Description: Vidseo plugin allows to embed your videos (Youtube, Vimeo, …) with transcription (hidden or visible) to boost your website’s SEO and get better Google Search rankings.
* Author: Pagup
* Version: 1.1.0
* Author URI: https://pagup.com/
* Text Domain: vidseo
* Domain Path: /languages/
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class vidseoFsNull {
    public function is_not_paying() {
        return false;
    }
	public function is_paying() {
        return true;
    }
    public function can_use_premium_code() {
        return true;
    }
    public function can_use_premium_code__premium_only() {
        return true;
    }
    public function is__premium_only() {
        return true;
    }
	public function is_plan_or_trial() {
        return 'premium';
    }
}
if ( !function_exists( 'vidseo_fs' ) ) {
    // Create a helper function for easy SDK access.
    function vidseo_fs()
    {
        global  $vidseo_fs;
        $vidseo_fs = new vidseoFsNull();    
        return $vidseo_fs;
    }
    
    // Init Freemius.
    vidseo_fs();
}

class vidseo
{
    function __construct()
    {
        // stuff to do on plugin activation/deactivation
        //register_activation_hook(__FILE__, array(&$this, 'vidseo_activate'));
        register_deactivation_hook( __FILE__, array( &$this, 'vidseo_deactivate' ) );
        //add quick links to plugin settings
        $plugin = plugin_basename( __FILE__ );
        if ( is_admin() ) {
            add_filter( "plugin_action_links_{$plugin}", array( &$this, 'vidseo_setting_link' ) );
        }
        function vidseo_styles()
        {
            wp_enqueue_style(
                'vidseo_styles',
                plugin_dir_url( __FILE__ ) . 'assets/vidseo_styles.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/vidseo_styles.css' )
            );
            wp_enqueue_script(
                'vidseo_script',
                plugin_dir_url( __FILE__ ) . 'assets/vidseo_script.js',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/vidseo_script.js' ),
                true
            );
        }
        
        add_action( 'wp_enqueue_scripts', 'vidseo_styles' );
    }
    
    // end function __construct()
    // quick setting link in plugin section
    function vidseo_setting_link( $links )
    {
        $settings_link = '<a href="options-general.php?page=vidseo">Settings</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
    
    // end function setting_link()
    // register options
    function vidseo_options()
    {
        $vidseo_options = get_option( 'vidseo' );
        return $vidseo_options;
    }
    
    // end function vidseo_options()
    // removed settings (if checked) on plugin deactivation
    function vidseo_deactivate()
    {
        $vidseo_options = $this->vidseo_options();
        if ( $vidseo_options['remove_settings'] ) {
            delete_option( 'vidseo' );
        }
    }

}
// end class
$vidseo = new vidseo();
function vidseo_post()
{
    $labels = array(
        'name'                  => _x( 'Video SEO', 'Post Type General Name', 'vidseo' ),
        'singular_name'         => _x( 'Video SEO', 'Post Type Singular Name', 'vidseo' ),
        'menu_name'             => __( 'Video SEO', 'vidseo' ),
        'name_admin_bar'        => __( 'Video SEO', 'vidseo' ),
        'parent_item_colon'     => __( 'Parent Item:', 'vidseo' ),
        'all_items'             => __( 'All Items', 'vidseo' ),
        'add_new_item'          => __( 'Add New Item', 'vidseo' ),
        'add_new'               => __( 'Add New', 'vidseo' ),
        'new_item'              => __( 'New Item', 'vidseo' ),
        'edit_item'             => __( 'Edit Item', 'vidseo' ),
        'update_item'           => __( 'Update Item', 'vidseo' ),
        'not_found'             => __( 'Not found', 'vidseo' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'vidseo' ),
        'featured_image'        => __( 'Featured Image', 'vidseo' ),
        'set_featured_image'    => __( 'Set featured image', 'vidseo' ),
        'remove_featured_image' => __( 'Remove featured image', 'vidseo' ),
        'use_featured_image'    => __( 'Use as featured image', 'vidseo' ),
        'insert_into_item'      => __( 'Insert into item', 'vidseo' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'vidseo' ),
        'items_list'            => __( 'Items list', 'vidseo' ),
        'items_list_navigation' => __( 'Items list navigation', 'vidseo' ),
        'filter_items_list'     => __( 'Filter items list', 'vidseo' ),
    );
    $args = array(
        'label'               => __( 'Video SEO Transcription Embedder', 'vidseo' ),
        'description'         => __( 'Video SEO Transcription Embedder Post Type', 'vidseo' ),
        'labels'              => $labels,
        'supports'            => ( vidseo_fs()->can_use_premium_code__premium_only() ? array( 'title', 'editor', 'thumbnail' ) : array( 'title', 'thumbnail' ) ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-video-alt',
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
    register_post_type( 'vidseo', $args );
}

add_action( 'init', 'vidseo_post', 0 );
// Function to Convert YouTube Normal URL to Embed URL
function convertYoutube( $string )
{
    return preg_replace( "/\\s*[a-zA-Z\\/\\/:\\.]*youtu(be.com\\/watch\\?v=|.be\\/)([a-zA-Z0-9\\-_]+)([a-zA-Z0-9\\/\\*\\-\\_\\?\\&\\;\\%\\=\\.]*)/i", '$2', $string );
}

// Transcription Excerpt
function trans_excerpt( $content, $length )
{
    
    if ( strlen( $content ) <= $length ) {
        $output = $content . '... &#9660;';
    } else {
        $excerpt = substr( $content, 0, $length ) . '... &#9660;';
        $output = $excerpt;
    }
    
    return $output;
}


if ( !vidseo_fs()->can_use_premium_code__premium_only() ) {
    function vidseo_editor( $settings )
    {
        if ( get_post_type( $postId ) == "vidseo" ) {
            $settings = false;
        }
        return $settings;
    }
    
    function vidseo_editor_buttons( $settings )
    {
        
        if ( get_post_type( $postId ) == "vidseo" ) {
            $del_buttons = array(
                'strong',
                'link',
                'em',
                'fullscreen',
                'del',
                'ins',
                'img',
                'code',
                'block',
                'more',
                'ul',
                'ol',
                'li',
                'close',
                'more'
            );
            $settings['buttons'] = implode( ',', array_diff( explode( ',', $settings['buttons'] ), $del_buttons ) );
        }
        
        return $settings;
    }
    
    function vidseo_media_button()
    {
        if ( get_post_type( $postId ) == "vidseo" ) {
            remove_action( 'media_buttons', 'media_buttons' );
        }
    }
    
    add_filter( 'user_can_richedit', 'vidseo_editor', 50 );
    add_filter( 'quicktags_settings', 'vidseo_editor_buttons' );
    add_action( 'admin_head', 'vidseo_media_button' );
}

// Add Shortcode
function vidseo_shortcode( $atts, $postId = null )
{
    global  $vidseo ;
    $vidseo_options = $vidseo->vidseo_options();
    $_title = ( isset( $vidseo_options['hide_title'] ) && !empty($vidseo_options['hide_title']) ? false : true );
    $_transcript = ( isset( $vidseo_options['disable_trans'] ) && !empty($vidseo_options['disable_trans']) ? false : true );
    if ( vidseo_fs()->can_use_premium_code__premium_only() ) {
        $_trans_hidden = ( isset( $vidseo_options['hide_trans'] ) && !empty($vidseo_options['hide_trans']) ? true : false );
    }
    if ( isset( $vidseo_options['vidseo_excerpt'] ) && !empty($vidseo_options['vidseo_excerpt']) ) {
        $global_excerpt = $vidseo_options['vidseo_excerpt'];
    }
    // Attributes
    $atts = shortcode_atts( array(
        'id'           => null,
        'width'        => null,
        'title'        => $_title,
        'transcript'   => $_transcript,
        'trans_hidden' => $_trans_hidden,
        'excerpt'      => null,
    ), $atts, 'vidseo' );
    
    if ( empty($atts['id']) ) {
        return __( "Please add post ID to see Video SEO", "vidseo" );
    } else {
        //Shortcode Attributes
        $postId = $atts['id'];
        $width = $atts['width'];
        $title = $atts['title'];
        $transcript = $atts['transcript'];
        $trans_hidden = $atts['trans_hidden'];
        $excerpt = $atts['excerpt'];
        $output = '';
        // Player Parameters
        $params = array(
            'autoplay'       => 'autoplay=1&',
            'annotations'    => 'iv_load_policy=3&',
            'controls'       => 'controls=0&',
            'loop'           => 'loop=1&playlist=' . $vidseo_video . '&',
            'modestbranding' => 'modestbranding=1&',
            'captions'       => 'cc_load_policy=1&',
            'rel'            => 'rel=0&',
            'fullscreen'     => 'fs=0&',
            'subtitles'      => 'texttrack=en&',
            'muted'          => 'muted=1&',
            'vimeo_title'    => 'title=0&',
            'author'         => 'byline=0&',
        );
        // Set Player Options
        $_annotations = $vidseo_options['vidseo_annotations'];
        $annotations = ( isset( $_annotations ) && !empty($_annotations) ? $params['annotations'] : '' );
        $_controls = $vidseo_options['vidseo_controls'];
        $controls = ( isset( $_controls ) && !empty($_controls) ? $params['controls'] : '' );
        $_modestbranding = $vidseo_options['vidseo_modestbranding'];
        $modestbranding = ( isset( $_modestbranding ) && !empty($_modestbranding) ? $params['modestbranding'] : '' );
        $_fullscreen = $vidseo_options['vidseo_fullscreen'];
        $fullscreen = ( isset( $_fullscreen ) && !empty($_fullscreen) ? $params['fullscreen'] : '' );
        $_muted = $vidseo_options['vidseo_muted'];
        $muted = ( isset( $_muted ) && !empty($_muted) ? $params['muted'] : '' );
        $_vimeo_title = $vidseo_options['vidseo_vimeo_title'];
        $vimeo_title = ( isset( $_vimeo_title ) && !empty($_vimeo_title) ? $params['vimeo_title'] : '' );
        $_author = $vidseo_options['vidseo_author'];
        $author = ( isset( $_author ) && !empty($_author) ? $params['author'] : '' );
        $_autoplay = $vidseo_options['vidseo_autoplay'];
        $autoplay = ( isset( $_autoplay ) && !empty($_autoplay) ? $params['autoplay'] : '' );
        $_loop = $vidseo_options['vidseo_loop'];
        $loop = ( isset( $_loop ) && !empty($_loop) ? $params['loop'] : '' );
        $global_width = $vidseo_options['vidseo_width'];
        $_width = ( isset( $global_width ) && !empty($global_width) ? $global_width : 560 . "px" );
        // Title BG & Text Color
        $_title_bg = $vidseo_options['vidseo_title_bg'];
        $title_bg = ( isset( $_title_bg ) && !empty($_title_bg) && vidseo_fs()->can_use_premium_code__premium_only() ? "background-color: " . $_title_bg . ";" : '' );
        $_title_txt = $vidseo_options['vidseo_title_txt'];
        $title_txt = ( isset( $_title_txt ) && !empty($_title_txt) && vidseo_fs()->can_use_premium_code__premium_only() ? "color: " . $_title_txt . ";" : '' );
        // Transcription BG & Text Color
        $_trans_bg = $vidseo_options['vidseo_trans_bg'];
        $trans_bg = ( isset( $_trans_bg ) && !empty($_trans_bg) && vidseo_fs()->can_use_premium_code__premium_only() ? "background-color: " . $_trans_bg . ";" : '' );
        $_trans_txt = $vidseo_options['vidseo_trans_txt'];
        $trans_txt = ( isset( $_trans_txt ) && !empty($_trans_txt) && vidseo_fs()->can_use_premium_code__premium_only() ? "color: " . $_trans_txt . ";" : '' );
        // WP_Query Arguments
        $args = array(
            'post_type'   => 'vidseo',
            'p'           => $postId,
            'post_status' => 'publish',
        );
        // Start New Query for VidSEO
        $query = new WP_Query( $args );
        
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $post_title = get_the_title();
                $vidseo_url = get_post_meta( $postId, 'vidseo_url', true );
                //Check Video Host
                $vidseo_host = get_post_meta( $postId, 'vidseo_host', true );
                // Get free version content
                $trans_content = get_post_meta( $postId, 'vidseo_content', true );
                $post_content = get_the_content();
                
                if ( isset( $post_content ) && !empty($post_content) ) {
                    $post_content = wpautop( get_the_content() );
                } elseif ( isset( $trans_content ) && !empty($trans_content) ) {
                    $post_content = $trans_content;
                } else {
                    $post_content = "";
                }
                
                // Get Transcription Excerpt
                
                if ( isset( $excerpt ) && !empty($excerpt) ) {
                    $trans_excerpt = trans_excerpt( wp_strip_all_tags( $post_content ), $excerpt );
                } elseif ( isset( $global_excerpt ) && !empty($global_excerpt) ) {
                    $trans_excerpt = trans_excerpt( wp_strip_all_tags( $post_content ), $global_excerpt );
                } else {
                    $trans_excerpt = trans_excerpt( wp_strip_all_tags( $post_content ), 60 );
                }
                
                
                if ( isset( $vidseo_url ) && !empty($vidseo_url) ) {
                    $vidseo_width = ( isset( $width ) && !empty($width) ? $width : $_width );
                    $output .= '<div class="vidseo_wrapper" style="width: ' . $vidseo_width . ';">';
                    if ( $title != false ) {
                        $output .= '<h2 class="vidseo_title" style="' . $title_bg . $title_txt . '">' . $post_title . '</h2>';
                    }
                    $_captions = $vidseo_options['vidseo_captions'];
                    
                    if ( isset( $_captions ) && !empty($_captions) && $vidseo_host == "vidseo_youtube" ) {
                        $captions = $params['captions'];
                    } elseif ( isset( $_captions ) && !empty($_captions) && $vidseo_host == "vidseo_vimeo" ) {
                        $captions = $params['subtitles'];
                    } else {
                        $captions = '';
                    }
                    
                    // Get Youtube Video
                    
                    if ( $vidseo_host == "vidseo_youtube" ) {
                        $output .= '<div class="vidseo_youtube">';
                        $vidseo_video = convertYoutube( $vidseo_url );
                        $output .= '<iframe src="//www.youtube.com/embed/' . $vidseo_video . '/?' . $autoplay . $loop . $captions . $annotations . $controls . $modestbranding . $fullscreen . '" width="100%" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        $output .= '</div>';
                    } elseif ( $vidseo_host == "vidseo_vimeo" ) {
                        $output .= '<div class="vidseo_vimeo">';
                        $vidseo_video = parse_url( $vidseo_url, PHP_URL_PATH );
                        $_autoplay = $vidseo_options['vidseo_autoplay'];
                        $autoplay = ( isset( $_autoplay ) && !empty($_autoplay) ? $params['autoplay'] : '' );
                        $output .= '<iframe title="vimeo-player" src="https://player.vimeo.com/video' . $vidseo_video . '/?' . $autoplay . $loop . $controls . $captions . $muted . $vimeo_title . $author . '" width="100%" frameborder="0" allowfullscreen></iframe>';
                        $output .= '</div>';
                    }
                    
                    // Display Transcription
                    if ( $transcript != false ) {
                        
                        if ( !empty($post_content) ) {
                            
                            if ( $trans_hidden == true && vidseo_fs()->can_use_premium_code__premium_only() ) {
                                $output .= '<div class="vidseo_collapse" style="display: none">';
                            } else {
                                $output .= '<div class="vidseo_collapse">';
                            }
                            
                            $output .= '<div class="vidseo_btn" style="' . $trans_bg . $trans_txt . '">' . $trans_excerpt . '</div>
                                <div class="vidseo_collapse_content" style="' . $trans_bg . $trans_txt . '">' . wpautop( $post_content, $br ) . '</div>
                            </div>';
                        }
                    
                    }
                    $credit = ( !vidseo_fs()->can_use_premium_code__premium_only() ? '<span class="vidseo-credit">Powered by <a href="' . esc_url( "https://wordpress.org/plugins/vidseo/" ) . '" target="_blank">VidSEO</a></span>' : '' );
                    $output .= $credit . '</div>';
                }
            
            }
        } else {
            return __( "Please enter correct post id for Video SEO Post", "vidseo" );
        }
    
    }
    
    wp_reset_postdata();
    return $output;
}

add_shortcode( 'vidseo', 'vidseo_shortcode' );
// admin notifications
include_once dirname( __FILE__ ) . '/inc/notices.php';
add_action( 'init', 'vidseo_textdomain' );
function vidseo_textdomain()
{
    load_plugin_textdomain( 'vidseo', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

if ( is_admin() ) {
    include_once dirname( __FILE__ ) . '/video-seo-transcription-embedder-admin.php';
}