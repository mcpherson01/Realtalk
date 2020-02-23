<?php
/* 
 * Plugin Name: Mayosis Core
 * Plugin URI: https://teconce.com
 * Description: This is core plugin for mayosis digital marketplace theme
 * Version:    2.6.2
 * Author:      Teconce Team
 * Author URI:  https://teconce.com
 * Text Domain: mayosis
 * Copyright:   2018, Teconce Team
 */

if( ! class_exists( 'mayosis_core' ) ) {
    class mayosis_core{

        /**
         * Plugin version, used for cache-busting of style and script file references.
         *
         * @since   1.0.0
         *
         * @var  string
         */
        const VERSION = '2.6.2';

        /**
         * Instance of this class.
         *
         * @since   1.0.0
         *
         * @var   object
         */
        protected static $instance = null;

        public function __construct(){
            add_action('init', array(&$this, 'init'));
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('after_setup_theme', array(&$this, 'load_digitalmarketplace_core_text_domain'));
            register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
            register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook

        }

        /**
         * Register the plugin text domain
         *
         * @return void
         */
        function load_digitalmarketplace_core_text_domain() {
            load_plugin_textdomain( 'mayosis', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
        }

        /**
         * Return an instance of this class.
         *
         * @since    1.0.0
         *
         * @return  object  A single instance of this class.
         */
        public static function get_instance() {

            // If the single instance hasn't been set, set it now.
            if ( null == self::$instance ) {
                self::$instance = new self;
            }

            return self::$instance;

        }


    }

}
// Load the instance of the plugin
add_action( 'mayosis_core', 'get_instance' );

// Footer Text
add_filter('admin_footer_text', 'mayosis_remove_footer_admin'); //footer info
function mayosis_remove_footer_admin () {
    echo '<span id="footer_text">'. esc_html__('Mayosis Digital Marketplace Theme Developed by','mayosis') .' <a href="https://teconce.com/" target="_blank">'. esc_html__('Teconce', 'mayosis') .'</a>'. esc_html__(' For Digital Marketplace by wordpress','mayosis')  . '</span>';
}
add_action('login_enqueue_scripts', 'digitalmarketplace_login_logo'); //login logo

add_filter('login_headertitle', 'digitalmarketplace_login_logo_url_title'); //login logo title

include( plugin_dir_path( __FILE__ ) .'library/login-backend.php');
include( plugin_dir_path( __FILE__ ) .'library/edd-advanced.php');
include( plugin_dir_path( __FILE__ ) .'library/theme_customize.php');
include( plugin_dir_path( __FILE__ ) .'library/user-follow/user_follow.php');
include( plugin_dir_path( __FILE__ ) .'library/license-manager/mayosis-licensebox-options.php');


include( plugin_dir_path( __FILE__ ) .'metabox/page.php');
include( plugin_dir_path( __FILE__ ) .'metabox/page-color.php');
include( plugin_dir_path( __FILE__ ) .'metabox/download-category.php');
include( plugin_dir_path( __FILE__ ) .'metabox/menu_custom_fields.php');
include( plugin_dir_path( __FILE__ ) .'metabox/category-metabox.php');
include( plugin_dir_path( __FILE__ ) .'shortcodes/mayosis-shortcode.php');


include( plugin_dir_path( __FILE__ ) .'elementor/elementor-main.php');

include( plugin_dir_path( __FILE__ ) .'widgets/mayosis-instagram-widget.php');
include( plugin_dir_path( __FILE__ ) .'widgets/search_widget.php');
include( plugin_dir_path( __FILE__ ) .'widgets/post-categories.php');
include( plugin_dir_path( __FILE__ ) .'widgets/about-us.php');
include( plugin_dir_path( __FILE__ ) .'widgets/subscribe.php');
include( plugin_dir_path( __FILE__ ) .'widgets/blog_tag.php');
include( plugin_dir_path( __FILE__ ) .'widgets/recent_post.php');
include( plugin_dir_path( __FILE__ ) .'widgets/counter.php');
include( plugin_dir_path( __FILE__ ) .'widgets/recent-searches-widget.php');
include( plugin_dir_path( __FILE__ ) .'widgets/payment-icon.php');

if (class_exists('Easy_Digital_Downloads')):
    include( plugin_dir_path( __FILE__ ) .'widgets/social_widget.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/product-details.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/product-features.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/product-release-info.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/digital-recent-product.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/product_tag.php');
    include( plugin_dir_path( __FILE__ ) .'widgets/download-filters.php');
     include( plugin_dir_path( __FILE__ ) .'widgets/product-additional-widget-pack.php');
    include( plugin_dir_path( __FILE__ ) .'metabox/edd-gallery.php');
    include( plugin_dir_path( __FILE__ ) .'metabox/edd-features.php');
    include( plugin_dir_path( __FILE__ ) .'metabox/edd.php');
    include( plugin_dir_path( __FILE__ ) .'library/edd-category-grid.php');
    include( plugin_dir_path( __FILE__ ) .'library/edd-management.php');
    include( plugin_dir_path( __FILE__ ) .'library/author-cover.php');
    include( plugin_dir_path( __FILE__ ) .'library/mayosis-edd-template.php');
    include( plugin_dir_path( __FILE__ ) .'library/user-profile/edd-user-profiles.php');
    if (class_exists( 'EDD_Front_End_Submissions' ) ) {
    include( plugin_dir_path( __FILE__ ) .'widgets/downloads-author.php');
    }
endif;

 if (class_exists( 'ESSB_Manager' ) ) {
     include( plugin_dir_path( __FILE__ ) .'library/easy-social-share.php');
     include( plugin_dir_path( __FILE__ ) .'library/easy-social-loactions.php');
 }else{
     include( plugin_dir_path( __FILE__ ) .'library/social-share.php');
     
 }

add_action( 'fes_load_fields_require', 'mayosis_fes_custom_fields' );
function mayosis_fes_custom_fields(){ 
    if ( class_exists( 'EDD_Front_End_Submissions' ) ){
    if ( version_compare( fes_plugin_version, '2.3', '>=' ) ) { 
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-facebook.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-twitter.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-linkedin.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-behance.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-dribble.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-address.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-demo.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-video.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-audio.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-version.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-gallery.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-cover.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-freelance.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-file-included.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-file-size.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-compatible.php');
    include( plugin_dir_path( __FILE__ ) .'fes-fields/fes-documentation.php');
    
    add_filter(  'fes_load_fields_array', 'mayosis_fes_metas', 10, 1 );
			function mayosis_fes_metas( $fields ){
                
				$fields['facebook_profile'] = 'FES_facebook_profile_Field';
				$fields['twitter_profile'] = 'FES_twitter_profile_Field';
				$fields['linkedin_profile'] = 'FES_linkedin_profile_Field';
				$fields['behance_profile'] = 'FES_behance_profile_Field';
				$fields['dribble_profile'] = 'FES_dribble_profile_Field';
				$fields['address'] = 'FES_address_Field';
				$fields['demo_link'] = 'FES_demo_link_Field';
				$fields['video_url'] = 'FES_video_url_Field';
				$fields['audio_url'] = 'FES_audio_url_Field';
				$fields['product_version'] = 'FES_product_version_Field';
				$fields['vdw_gallery_id'] = 'FES_vdw_gallery_id_Field';
				$fields['fes_cover_photo'] = 'FES_fes_cover_photo_Field';
				$fields['fes_author_available'] = 'FES_fes_author_available_Field';
				$fields['file_type'] = 'FES_file_type_Field';
				$fields['file_size'] = 'FES_file_size_Field';
				$fields['compatible_with'] = 'FES_compatible_with_Field';
				$fields['documentation'] = 'FES_documentation_Field';
				return $fields;
				
			}
    }
}

}


// exclude from submission form in admin

add_filter( 'fes_templates_to_exclude_render_submission_form_admin',  'mayosis_fes_exclude' ,10, 1  );


function mayosis_fes_exclude( $fields ) {
	array_push( $fields, 'demo_link' );
	array_push( $fields, 'video_url' );
	array_push( $fields, 'audio_url' );
	array_push( $fields, 'file_type' );
	array_push( $fields, 'file_size' );
	array_push( $fields, 'compatible_with' );
	array_push( $fields, 'documentation' );
	array_push( $fields, 'product_version' );
	array_push( $fields, 'vdw_gallery_id' );
	return $fields;
}
if (class_exists('WPBakeryShortCode')):


    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_icon_box.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_theme_button.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_post.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_clients.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_theme_dual_button.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_theme_hero.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_subscribe.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_testimonial.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_pricing_table.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_vc_extend.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_search.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_counter.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_team.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_contact.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_licence.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_slider.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis_object_parallax.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/mayosis-modal.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/search_term.php');
    



if (class_exists('Easy_Digital_Downloads')):
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_featured.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_recent.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_hero.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_recent_grid.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_login.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_register.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_justified_grid.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_masonary_grid.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_category_grid.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_popular.php');
    include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_hero_block.php');
    
    
   if ( class_exists( 'EDD_Front_End_Submissions' ) ):
     include( plugin_dir_path( __FILE__ ) .'vc-elements/edd_author.php');
     endif;
endif;

endif;

if( function_exists('edd_get_settings') ) {
	remove_filter('the_content', 'edd_append_purchase_link');
	remove_filter('edd_after_download_content', 'edd_append_purchase_link');


}



include( plugin_dir_path( __FILE__ ) .'library/hit-counter/ajax-hits-counter.php');
require( plugin_dir_path( __FILE__ ) .'library/mayosis_options.php');
require( plugin_dir_path( __FILE__ ) .'library/mayosis-presets.php');
include( plugin_dir_path( __FILE__ ) .'library/header-helper.php');
  
   

  // Include Kirki
 include( plugin_dir_path( __FILE__ ) .'library/kirki/kirki.php');
 include( plugin_dir_path( __FILE__ ) .'library/header-builder/header-builder-options/header-contain.php');
include( plugin_dir_path( __FILE__ ) .'library/header-builder/header-builder-panel.php');
include( plugin_dir_path( __FILE__ ) .'library/header-builder/builder-config.php');

include( plugin_dir_path( __FILE__ ) .'library/theme-options/option-panel.php');

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   Visual Composer  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
// Before VC Init
add_action('vc_before_init', 'vc_before_init_actions');
function vc_before_init_actions()
{
    // Setup VC to be part of a theme
    if (function_exists('vc_set_as_theme')) {
        vc_set_as_theme(true);
    }
    // Link your VC elements's folder
    if (function_exists('vc_set_shortcodes_templates_dir')) {
        vc_set_shortcodes_templates_dir(get_template_directory() . '/vc_templates');
    }
    // Disable Instructional/Help Pointers
    if (function_exists('vc_pointer_load')) {
        remove_action('admin_enqueue_scripts', 'vc_pointer_load');
    }
}
// After VC Init
add_action('vc_after_init', 'vc_after_init_actions');
function vc_after_init_actions()
{
    // Enable VC by default on a list of Post Types
    if (function_exists('vc_set_default_editor_post_types')) {
        $list = array(
            'page',
            'post',
            'download'
            // add here your custom post types slug
        );
        vc_set_default_editor_post_types($list);
    }
    // Disable AdminBar VC edit link
    if (function_exists('vc_frontend_editor')) {
        remove_action('admin_bar_menu', array(
            vc_frontend_editor(),
            'adminBarEditLink'
        ), 1000);
    }
    // Disable Frontend VC links
    if (function_exists('vc_disable_frontend')) {
        vc_disable_frontend();
    }
}



add_action( 'init', 'mayosis_register_post_types' );
function mayosis_register_post_types() {
    register_post_type('testimonial', array(
        'public' => true,
        'label' => 'Testimonial',
        'menu_icon'           => 'dashicons-welcome-write-blog',
        'labels' => array(
            'name' => 'Testimonial',
            'singular_name' => 'Testimonials',
            'add_new' => 'Add New Testimonial',
        ),
        'supports' => array('title', 'thumbnail'),
        'can_export' => true,
    ));

    register_post_type('slider', array(
        'public' => true,
        'label' => 'Slider',
        'menu_icon'           => 'dashicons-images-alt',
        'labels' => array(
            'name' => 'Slider',
            'singular_name' => 'Sliders',
            'add_new' => 'Add New Slider',
        ),
        'supports' => array('title', 'thumbnail'),
        'can_export' => true,
    ));

    register_post_type('licence',
        array(
            'labels' => array(
                'name' => __( 'License' ),
                'singular_name' => __( 'License' ),
                'add_new' => __( 'Add New' ),
                'add_new_item' => __( 'Add New License' ),
                'edit' => __( 'Edit' ),
                'edit_item' => __( 'Edit License' ),
                'new_item' => __( 'New License' ),
                'view' => __( 'View License' ),
                'view_item' => __( 'View License' ),
                'search_items' => __( 'Search Licenses' ),
                'not_found' => __( 'No Licenses found' ),
                'not_found_in_trash' => __( 'No Licenses found in Trash' ),
                'parent' => __( 'Parent License' ),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-tickets',
            'show_ui' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'supports' => array( 'title'),
            'query_var' => true
        )
    );

}
add_action( 'init', 'mayosis_license_taxonomies', 0 );

function mayosis_license_taxonomies()
{
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x( 'License Group', 'taxonomy general name' ),
        'singular_name' => _x( 'License Groups', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Group' ),
        'popular_items' => __( 'Popular Group' ),
        'all_items' => __( 'All License Group' ),
        'parent_item' => __( 'Parent License Group' ),
        'parent_item_colon' => __( 'Parent License Group:' ),
        'edit_item' => __( 'Edit License Group' ),
        'update_item' => __( 'Update License Group' ),
        'add_new_item' => __( 'Add New License Group' ),
        'new_item_name' => __( 'New Recording License Group' ),
    );
    register_taxonomy('license-group',array('licence'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'license-group' ),
    ));
}



function short_excerpt($string)
{
    echo substr($string, 0, 210);
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   Post View Count  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////
// function to display number of posts.

function mayosis_views($postID)
{
    global $post;
    if (empty($postID)) $postID = $post->ID;
    $count_key = 'mayosis_views';
    $count = get_post_meta($postID, $count_key, true);
    $count = @number_format($count);
    if (empty($count))
    {
        delete_post_meta($postID, $count_key);
       update_post_meta($postID, $count_key, 0);
        $count = 0;
    }

    return '<span class="post-views">' . $count . ' ' . __('Views', 'mayosis-digital-marketplace-theme') . '</span> ';
}

// function to count views.

function mayosis_setPostViews($postID)
{
    global $post;
    $count = 0;
    $postID = $post->ID;
    $count_key = 'mayosis_views';
    $count = (int)get_post_meta($postID, $count_key, true);
    if (!defined('WP_CACHE') || !WP_CACHE)
    {
        $count++;
        update_post_meta($postID, $count_key, (int)$count);
    }
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   AUTHOR CUSTOM LINK  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function digitalmarketplace_to_author_profile($contactmethods)
{
    $contactmethods['address'] = 'Address';
    $contactmethods['behance_profile'] = 'Behance Profile URL';
    $contactmethods['dribble_profile'] = 'Dribble Profile URL';
    $contactmethods['twitter_profile'] = 'Twitter Profile URL';
    $contactmethods['facebook_profile'] = 'Facebook Profile URL';
    $contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
    $contactmethods['fes_cover_photo'] = 'FES Profile Image';
    $contactmethods['fes_author_available'] = 'Freelance Available Text (i.e Available for Hire)';
    return $contactmethods;
}

add_filter('user_contactmethods', 'digitalmarketplace_to_author_profile', 10, 1);
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////  XML SITEMAP GENARATOR  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

add_action("publish_post", "digitalmarketplace_create_sitemap");
add_action("publish_page", "digitalmarketplace_create_sitemap");

function digitalmarketplace_create_sitemap()
{
    $postsForSitemap = get_posts(array(
        'numberposts' => - 1,
        'orderby' => 'modified',
        'post_type' => array(
            'post',
            'page',
            'download'
        ) ,
        'order' => 'DESC'
    ));
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach($postsForSitemap as $post)
    {
        setup_postdata($post);
        $postdate = explode(" ", $post->post_modified);
        $sitemap.= '<url>' . '<loc>' . get_permalink($post->ID) . '</loc>' . '<lastmod>' . $postdate[0] . '</lastmod>' . '<changefreq>monthly</changefreq>' . '</url>';
    }

    $sitemap.= '</urlset>';
    $fp = fopen(ABSPATH . "sitemap.xml", 'w');
    fwrite($fp, $sitemap);
    fclose($fp);
}
// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Most Recent posts   /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_sidebar_post($numberOfPosts = 5, $thumb = true)
{
    global $post;
    $orig_post = $post;
    $lastPosts = get_posts('no_found_rows=1&suppress_filters=0&numberposts=' . $numberOfPosts);
    foreach($lastPosts as $post):
        setup_postdata($post);
        ?>
        <div class="widget-posts">

            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail">
                <div class="product-thumb grid_dm">
                    <figure class="mayosis-fade-in">
                        <?php
                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                        ?>
                        <figcaption>
                            <div class="overlay_content_center">
                                <a href="<?php
                                the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                </div> </div>

            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                <h3><a href="<?php
                    the_permalink(); ?>"><?php
                        $title  = the_title('','',false);
                        if(strlen($title) > 36):
                            echo trim(substr($title, 0, 32)).'...';
                        else:
                            echo esc_html($title);
                        endif;
                        ?></a></h3>
                <p><?php echo(ajax_hits_counter_get_hits(get_the_ID())); ?>  <?php esc_html_e('Views','mayosis');?> </p>



            </div>
        </div>
    <?php
    endforeach;
    $post = $orig_post;
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   Get Popular posts   /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_popular_posts($pop_posts = 5, $thumb = true)
{
    global $post;
    $orig_post = $post;
    $popularposts = new WP_Query(array(
        'orderby' => 'comment_count',
        'order' => 'DESC',
        'posts_per_page' => $pop_posts,
        'post_status' => 'publish',
        'no_found_rows' => 1,
        'ignore_sticky_posts' => 1
    ));
    while ($popularposts->have_posts()):
        $popularposts->the_post() ?>
        <div class="widget-posts">

            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail">
                <div class="product-thumb grid_dm">
                    <figure class="mayosis-fade-in">
                        <?php
                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                        ?>
                        <figcaption>
                            <div class="overlay_content_center">
                                <a href="<?php
                                the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                <h3><a href="<?php
                    the_permalink(); ?>"><?php
                        the_title(); ?></a></h3>
                <p><?php echo(ajax_hits_counter_get_hits(get_the_ID())); ?>  <?php esc_html_e('Views','mayosis');?>  </p>



            </div>
        </div>
    <?php
    endwhile;
    $post = $orig_post;
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Popular posts / Views   /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_most_viewed_posts($posts_number = 5, $thumb = true)
{
    global $post;
    $original_post = $post;
    $args = array(
        'orderby' => 'meta_value_num',
        'meta_key' => 'hits',
        'posts_per_page' => $posts_number,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="widget-posts">


                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h3>
                    <p><?php echo(ajax_hits_counter_get_hits(get_the_ID())); ?>  <?php esc_html_e('Views','mayosis');?> </p>



                </div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}

// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////   Get Most Viewed posts  /////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_best_reviews_posts($pop_posts = 5, $thumb = true)
{
    global $post;
    $orig_post = $post;
    $cat_query1 = new WP_Query(array(
        'posts_per_page' => $pop_posts,
        'orderby' => 'meta_value_num',
        'meta_key' => 'mayosis_review_score',
        'post_status' => 'publish',
        'no_found_rows' => 1
    ));
    while ($cat_query1->have_posts()):
        $cat_query1->the_post() ?>
        <div class="widget-posts">
            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail">
                <div class="product-thumb grid_dm">
                    <figure class="mayosis-fade-in">
                        <?php
                        the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                        ?>
                        <figcaption>
                            <div class="overlay_content_center">
                                <a href="<?php
                                the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                <h3><a href="<?php
                    the_permalink(); ?>"><?php
                        the_title(); ?></a></h3>
                <p><?php
                    echo mayosis_views(get_the_ID()); ?> </p>
            </div>
        </div>
    <?php
    endwhile;
    $post = $orig_post;
}



// //////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Popular posts / Views  Footer ////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_most_viewed_posts_footer($posts_number = 3, $thumb = true)
{
    global $post;
    $original_post = $post;
    $args = array(
        'orderby' => 'meta_value_num',
        'meta_key' => 'mayosis_views',
        'posts_per_page' => $posts_number,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="bottom-widget-product ">
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>">
                            <?php
                            $title  = the_title('','',false);
                            if(strlen($title) > 40):
                                echo trim(substr($title, 0, 37)).'...';
                            else:
                                echo esc_html($title);
                            endif;
                            ?>
                        </a></h3>
                    <p><?php echo(ajax_hits_counter_get_hits(get_the_ID())); ?>  <?php esc_html_e('Views','mayosis');?> </p>


                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}

// /////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Popular Product  Footer ////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_most_viewed_product_footer($posts_number = 3, $thumb = true)
{
    global $post;
    $original_post = $post;
    $args = array(
        'post_type' => 'download',
        'orderby' => 'meta_value_num',
        'meta_key' => 'hits',
        'posts_per_page' => $posts_number,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="bottom-widget-product ">
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h3>
                    <?php get_template_part( 'includes/product-additional-meta'); ?>


                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}



// /////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Featured Product  Footer ////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_featured_product_footer($posts_number = 3, $thumb = true)
{
    global $post;
    $original_post = $post;
    $args = array(
        'post_type' => 'download',
        'orderby' => 'meta_value_num',
        'meta_key' => 'edd_feature_download',
        'posts_per_page' => $posts_number,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="bottom-widget-product ">
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h3>
                    <?php get_template_part( 'includes/product-additional-meta'); ?>


                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}


// /////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Related Product  Footer ////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_related_product_footer($posts_number = 3, $thumb = true)
{
    global $post;
    $original_post = $post;
    $exclude_post_id = $post->ID;
		$taxchoice = isset( $edd_options['related_filter_by_cat'] ) ? 'download_tag' : 'download_category';
		$custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );
    $args = array(
        'post_type' => 'download',
			'post_status' => 'publish',
			'posts_per_page' => 3,
			'orderby' => 'rand', 
			'ignore_sticky_posts' => 1,
			'post__not_in' => array($post->ID),
			'ignore_sticky_posts'=>1,
			'tax_query' => array(
							array(
								'taxonomy' => $taxchoice,
								'field' => 'id',
								'terms' => $custom_taxterms
							)
						),
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="bottom-widget-product ">
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h3>
                    <?php get_template_part( 'includes/product-additional-meta'); ?>


                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}


// /////////////////////////////////////////////////////////////////////////////////////////
// ////////////////////    Get Related Product  Footer ////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////

function mayosis_same_product_author($posts_number = 3, $thumb = true)
{
    global $post;
    $original_post = $post;
   $author= get_the_author_meta( 'ID' );
		$exclude_post_id = $post->ID;
    $args = array(
        'post_type' => 'download',
			'post_status' => 'publish',
			'posts_per_page' => 3,
			'ignore_sticky_posts' => 1,
			'post__not_in' => array($post->ID),
			'ignore_sticky_posts'=>1,
			'author'=> $author,
    );
    $popularposts = new WP_Query($args);
    if ($popularposts->have_posts()):
        while ($popularposts->have_posts()):
            $popularposts->the_post() ?>
            <div class="bottom-widget-product ">
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-thumbnail paading-left-0">
                    <div class="product-thumb grid_dm">
                        <figure class="mayosis-fade-in">
                            <?php
                            the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) );
                            ?>
                            <figcaption>
                                <div class="overlay_content_center">
                                    <a href="<?php
                                    the_permalink(); ?>"><i class="zil zi-plus"></i></a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 sidebar-details paading-left-0">
                    <h3><a href="<?php
                        the_permalink(); ?>"><?php
                            the_title(); ?></a></h3>
                    <?php get_template_part( 'includes/product-additional-meta'); ?>


                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        endwhile;
    endif;
    $post = $original_post;
    wp_reset_postdata();
}
function mayosis_exif_data() {

    if ( ! is_singular( 'download' ) || ! has_post_thumbnail( get_the_ID() ) ) :
        return;
    endif;

    $thumb_id	= get_post_thumbnail_id();
    $image 		= wp_get_attachment_metadata( $thumb_id );
    $image_meta = $image['image_meta'];

    if ( $image_meta ) :

        ?><div id='product_exif' class='clearfix'>

        <div class='single-product-meta clearfix'>

            <?php

            if ( isset( $image_meta['aperture'] ) && ! empty( $image_meta['aperture'] ) && apply_filters( 'mayosis_display_exif_aperture', true ) ) :
                ?><div class='image-aperture'>
                <span class='label'><?php _e( 'Aperture', 'mayosis' ); ?></span>
                <span class='value'><?php echo $image_meta['aperture']; ?></span>
                </div><?php
            endif;


            if ( isset( $image_meta['camera'] ) && ! empty( $image_meta['camera'] ) && apply_filters( 'mayosis_display_exif_camera', true ) ) :
                ?><div class='image-camera'>
                <span class='label'><?php _e( 'Camera', 'mayosis' ); ?></span>
                <span class='value'><?php echo $image_meta['camera']; ?></span>
                </div><?php
            endif;


            if ( isset( $image_meta['created_timestamp'] ) && ! empty( $image_meta['created_timestamp'] ) && apply_filters( 'mayosis_display_exif_timestamp', true ) ) :
                ?><div class='image-meta-credit'>
                <span class='label'><?php _e( 'Created', 'mayosis' ); ?></span>
                <span class='value'><?php echo date( 'd-m-Y', $image_meta['created_timestamp'] ); ?></span>
                </div><?php
            endif;


            if ( isset( $image_meta['focal_length'] ) && ! empty( $image_meta['focal_length'] ) && apply_filters( 'mayosis_display_exif_focal_length', true ) ) :
                ?><div class='image-meta-focal_length'>
                <span class='label'><?php _e( 'Focal length', 'mayosis' ); ?></span>
                <span class='value'><?php echo $image_meta['focal_length']; ?></span>
                </div><?php
            endif;

            if ( isset( $image_meta['iso'] ) && ! empty( $image_meta['iso'] ) && apply_filters( 'mayosis_display_exif_iso', true ) ) :
                ?><div class='image-meta-iso'>
                <span class='label'><?php _e( 'ISO', 'mayosis' ); ?></span>
                <span class='value'><?php echo $image_meta['iso']; ?></span>
                </div><?php
            endif;

            if ( isset( $image_meta['shutter_speed'] ) && ! empty( $image_meta['shutter_speed'] ) && apply_filters( 'mayosis_display_exif_shutter_speed', true ) ) :
                ?><div class='image-meta-shutter-speed'>
                <span class='label'><?php _e( 'Shutter speed', 'mayosis' ); ?></span>
                <span class='value'><?php echo  $image_meta['shutter_speed']; ?></span>
                </div><?php
            endif;


            ?></div>

        </div><?php


    endif;

}


function mayosis_cat_filter() { ?>
<div class="mayosis-filter-title">
            <?php
            $old=null;
            $pricelowtohigh=null;
            $pricehightolow=null;
            $popular=null;
            $recent=null;
            $titleAtoZ=null;
            $titleZtoA=null;
            if(isset($_GET['orderby'])){
                if($_GET['orderby']=="price_asc"){
                    $pricelowtohigh="selected";
                }

                else if($_GET['orderby']=="price_desc"){
                    $pricehightolow="selected";
                }
                
                else if($_GET['orderby']=="newness_asc"){
                    $recent="selected";
                }

                else if($_GET['orderby']=="newness_desc"){
                    $old="selected";
                }
                else if($_GET['orderby']=="sales"){
                    $popular="selected";
                }
                
                else if($_GET['orderby']=="title_asc"){
                    $titleAtoZ="selected";
                }
                
                else if($_GET['orderby']=="title_desc"){
                    $titleZtoA="selected";
                }
                

            }
            else{
                $old="selected";
            } ?>
       <select class="product_filter_mayosis resizeselect" id="resizing_select" onchange="if (this.value) window.location.href=this.value">
           
           <option <?php echo esc_html($popular); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'sales'))); ?>"><?php esc_html_e('Popular','mayosis'); ?></option>
           
            <option <?php echo esc_html($old); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_desc'))); ?>"><?php esc_html_e('Recent','mayosis'); ?></option>

            <option <?php echo esc_html($recent); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_asc'))); ?>"><?php esc_html_e('Older','mayosis'); ?></option>
            

            
            <option <?php echo esc_html($pricelowtohigh); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'price_asc'))); ?>"><?php esc_html_e('Price (Low to High)','mayosis'); ?></option>
            
            <option <?php echo esc_html($pricehightolow); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'price_desc'))); ?>"><?php esc_html_e('Price (High to Low)','mayosis'); ?></option>
            
            
            <option <?php echo esc_html($titleAtoZ); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_asc'))); ?>"><?php esc_html_e('Title (A - Z)','mayosis'); ?></option>
            
            <option <?php echo esc_html($titleZtoA); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_desc'))); ?>"><?php esc_html_e('Title (Z - A)','mayosis'); ?></option>
        </select>
        
        </div>

<?php }




/**
 * Get the parameters for ordering that we'll include in our select field
 * 
 * @since 1.0.0
 * @return Array
 */
function mayosis_edd_orderby_params() {
  $params = array( 
    'newness_asc' => array( 
      'id' => 'newness_asc', // Unique ID 
      'title' => __( 'Newest first', 'mayofilter-for-edd' ), // Text to display in select option 
      'orderby' => 'post_date', // Orderby parameter, must be legit WP_Query orderby param 
      'order' => 'DESC' // Either ASC or DESC
    ),
    'newness_desc' => array(
      'id' => 'newness_desc',
      'title' => __( 'Oldest first', 'mayofilter-for-edd' ),
      'orderby' => 'post_date',
      'order' => 'ASC'
    ),
    'price_asc' => array(
      'id' => 'price_asc',
      'title' => __( 'Price (Lowest to Highest)', 'mayofilter-for-edd' ),
      'orderby' => 'meta_value_num',
      'order' => 'ASC'
    ),
    'price_desc' => array(
      'id' => 'price_desc',
      'title' => __( 'Price (Highest to Lowest)', 'mayofilter-for-edd' ),
      'orderby' => 'meta_value_num',
      'order' => 'DESC'
    ),
    'title_asc' => array(
      'id' => 'title_asc',
      'title' => __( 'Title (A - Z)', 'mayofilter-for-edd' ),
      'orderby' => 'title',
      'order' => 'ASC'
    ),
    'title_desc' => array(
      'id' => 'title_desc',
      'title' => __( 'Title (Z - A)', 'mayofilter-for-edd' ),
      'orderby' => 'title',
      'order' => 'DESC'
    )
  );
  $params = apply_filters( 'mayosis_edd_filter_orderby_params', $params );
  return $params;
}

/**
 * Filter the [downloads] query
 * @since 1.0.0
 * @param $query The query to filter
 * @param $atts The shortcode atts
*/
function mayosis_edd_filter_query( $query, $atts ) { 
  // We're going to modify the order and orderby parameters depending on variables contained in the URL
  if( isset( $_GET['mayosis_orderby'] ) ) {
    // If a orderby option has been set, get the array of parameters
    $params = mayosis_edd_orderby_params();
    $orderby = $_GET['mayosis_orderby'];
    // Check the parameter that we've chosen exists
    if( isset( $params[$orderby] ) ) {
      $param = $params[$orderby];
      // Set the query parameters according to our selection
      $query['orderby'] = esc_attr( $param['orderby'] );
      $query['order'] = esc_attr( $param['order'] );
      if( strpos( $param['id'], 'price' ) !== false ) {
        // Specify meta key if we're querying by price
        $query['meta_key'] = 'edd_price';
      }
    }
  }
// Return the query, with thanks
return $query;
}
add_filter( 'edd_downloads_query', 'mayosis_edd_filter_query', 10, 2 );

/**
 * Filter the [downloads] shortcode to add dropdown field 
 * @since 1.0.0
 * @param $display The markup to print
*/
function mayosis_edd_add_dropdown( $display ) {
  $orderby = '';
  // Get the current parameter
  if( isset( $_GET['mayosis_orderby'] ) ) {
    $orderby = $_GET['mayosis_orderby'];
  }
  // Get the array of parameters
  $params = mayosis_edd_orderby_params();
  $select = '';
  if( ! empty( $params ) ) {
    // Build the select field
    $select = '<form class="mayofilter-edd-sorting">';
    $select .= '<select class="mayofilter-orderby" name="mayosis_orderby">';
    // Iterate through each parameter to add options to the select field
    foreach( $params as $param ) {
      $select .= '<option value="' . $param['id'] . '" ' . selected( $param['id'], $orderby, false ) . '>' . $param['title'] . '</option>';
    }
    $select .= '</select>';
    $select .= '</form>';
    // Add a script to submit the form when a new selection is made
    $select .= '<script>
      jQuery(document).ready(function($) {
        $(".mayofilter-orderby").change( function(){
          $(this).closest("form").submit();
        });
      });
    </script>';

    // Add the select field to the top of the downloads grid
    $display = $select . $display;
  }
  return $display; 
}
add_filter( 'downloads_shortcode', 'mayosis_edd_add_dropdown', 10, 1 );

/**
 * Admin bar Remove
 *
 */
add_action('after_setup_theme', 'mayosis_remove_adminbar');

function mayosis_remove_adminbar() {
if (!current_user_can('administrator') && !current_user_can('author') &&  !current_user_can('editor') && !is_admin()) {
show_admin_bar(false);
}
}


/**
 * Shortcode Copyright Year
 *
 */
function year_shortcode() {
    $year = date('Y');
    return $year;
}

add_shortcode('year', 'year_shortcode');

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_mayosis_core() {

    if ( ! class_exists( 'AppSero\Insights' ) ) {
        require_once __DIR__ . '/library/insights.php';
    }

    $insights = new AppSero\Insights( 'ecaf686d-e1b4-42f3-9261-223b10502277', 'Mayosis Core', __FILE__ );
    $insights->init_plugin();
}

add_action( 'init', 'appsero_init_tracker_mayosis_core' );
