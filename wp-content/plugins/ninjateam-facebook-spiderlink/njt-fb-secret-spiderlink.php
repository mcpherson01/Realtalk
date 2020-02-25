<?php 
/*
* Plugin Name: Facebook SpiderLink |  VestaThemes.com
* Plugin URI: http://ninjateam.org/facebook-secret-link/
* Description: Make Your Facebook Post GO VIRAL
* Version: 2.4
* Author: Ninja Team
* Author URI: https://ninjateam.org
* License: License GNU General Public License version 2 or later;
* Copyright 2018  NinjaTeam
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('NJT_APP_LIKE_COMMENT_FB_SETUP')):
	/**
	* 
	*/
	class NJT_APP_LIKE_COMMENT_FB_SETUP
	{
		function __construct()
		{
			$this->define_constants();
			register_activation_hook(__FILE__, array($this, 'njt_like_comment_table_design'));
			add_action('init', array($this,'create_custom_post_type_user_sub'));
			$this->_includes_file();
			if(!function_exists('is_plugin_active'))
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		public function define_constants(){
			if(!defined('NJT_APP_LIKE_COMMENT')){
				define('NJT_APP_LIKE_COMMENT', 'njt-app-like-comment-fb');
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_VERSION' ) ){
				define( 'NJT_APP_LIKE_COMMENT_VERSION', '1.4' );
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_FOLDER' ) ) {
				define( 'NJT_APP_LIKE_COMMENT_FOLDER', plugin_basename( __FILE__ ) ); 
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_DIR' ) ) {
				define( 'NJT_APP_LIKE_COMMENT_DIR', plugin_dir_path( __FILE__ )  );
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_FILE' ) ) {
				define( 'NJT_APP_LIKE_COMMENT_FILE', __FILE__ );
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_INC' ) ) {
				define( 'NJT_APP_LIKE_COMMENT_INC', NJT_APP_LIKE_COMMENT_DIR.'includes'.'/' );
			}
			if ( ! defined( 'NJT_APP_LIKE_COMMENT_URL' ) ) {
				define( 'NJT_APP_LIKE_COMMENT_URL', plugin_dir_url( __FILE__ ) ); 
			}
			// languages
			load_plugin_textdomain("njt-app-like-comment-fb", "", NJT_APP_LIKE_COMMENT_URL.'/languages');
		}
		public function create_custom_post_type_user_sub(){
			$label = array(
		        'name' => 'List User', 
		        'singular_name' => 'List User' 
		    );
		    $args = array(
		        'labels' => $label, 
		        'description' => 'List user', 
		        'supports' => array(
		            'title',
		            //'editor',
		            //'excerpt',
		           // 'author',
		            //'thumbnail',
		           // 'comments',
		            'trackbacks',
		            'revisions',
		            'custom-fields'
		        ), 
		      //  'taxonomies' => array( 'user_category'), 
		        'hierarchical' => false, 
		        'public' => true, 
		        'show_ui' => true, 
		        'show_in_menu' => false, // true 
		        'show_in_nav_menus' => false, 
		        'show_in_admin_bar' => false, 
		        'menu_position' => 5,
		        'menu_icon' => '',
		        'can_export' => false, 
		        'has_archive' => false, 
		        'exclude_from_search' => false, 
		        'publicly_queryable' => true,
		        'capability_type' => 'post' //
		    );
    		register_post_type('njt_user_subscriber', $args);


    		$label_fb_gr = array(
		        'name' => 'Facebook Group', 
		        'singular_name' => 'Facebook Group' 
		    );
		    $args_fb_gr = array(
		        'labels' => $label_fb_gr, 
		        'description' => 'Facebook Group', 
		        'supports' => array(
		            'title',
		            //'editor',
		            //'excerpt',
		           // 'author',
		            //'thumbnail',
		           // 'comments',
		            'trackbacks',
		            'revisions',
		            'custom-fields'
		        ), 

		        'hierarchical' => false, 
		        'public' => true, 
		        'show_ui' => true, 
		        'show_in_menu' => false, //true, 
		        'show_in_nav_menus' => false, 
		        'show_in_admin_bar' => false, 
		        'menu_position' => 5,
		        'menu_icon' => '',
		        'can_export' => false, 
		        'has_archive' => false, 
		        'exclude_from_search' => false, 
		        'publicly_queryable' => true,
		        'capability_type' => 'post' //
		    );
    		register_post_type('njt_fb_gr', $args_fb_gr);
		}
		public function _includes_file(){
			require(plugin_dir_path(__FILE__).'vendor/autoload.php');
			require(plugin_dir_path(__FILE__).'includes/Facebook_API/apifb.php');
			//API MailChimp
			require_once  NJT_APP_LIKE_COMMENT_INC.'classess/mailchimp/class-mail-chimp-exception.php';
      		require_once  NJT_APP_LIKE_COMMENT_INC.'classess/mailchimp/class-mail-chimp-exception-conncet.php';
      		require_once  NJT_APP_LIKE_COMMENT_INC.'classess/mailchimp/class-mail-chimp-exception-resource-not-found.php';
			require_once  NJT_APP_LIKE_COMMENT_INC.'classess/mailchimp/api.php';
			require_once  NJT_APP_LIKE_COMMENT_INC.'classess/mailchimp/api-client.php';
			
			//
			require_once  NJT_APP_LIKE_COMMENT_INC.'classess/njt-post-type-user.php';
			require_once  NJT_APP_LIKE_COMMENT_INC.'functions.php';
			require_once  NJT_APP_LIKE_COMMENT_INC.'ajax.php';
			// class
			if(get_option('njt_app_fb_like_comment_user') && get_option('njt_app_fb_like_comment_user')!="" && get_option('njt_app_like_comment_app_id') && get_option('njt_app_like_comment_app_id')!="" && get_option('njt_app_like_comment_app_id_serect') && get_option('njt_app_like_comment_app_id_serect')!=""){
				require NJT_APP_LIKE_COMMENT_INC.'classess/njt-app-like-comment-link.php';
				$njt_link= new NJT_LINK_FB_LIKE_COMMENT_API();
				$njt_link->add_options_page();
			}
			//
			require NJT_APP_LIKE_COMMENT_INC.'admin_settings.php';
		}
		public function njt_like_comment_table_design(){
			global $wpdb; // use query table
	          $charset_collate = $wpdb->get_charset_collate();  // format language
	          $table_design = $wpdb->prefix.'njt_like_comment_design';
	            if ($wpdb->get_var("show tables like '$table_design'") != $table_design) {
		      		NJT_L_C_Create_Table_DB($table_design,$charset_collate);    
			    	NJT_L_C_ADD_ROW_DB($table_design);
		        }else{

		        	$row_table_design = $wpdb->get_col( "DESC " . $table_design, 0 );
					//Add column if not present.
					if(!in_array('title', $row_table_design)){
		 				$wpdb->query("ALTER TABLE $table_design ADD COLUMN `title` TEXT NULL AFTER `id`");
		 				
		 			}
		 			//Add column if not present.
					if(!in_array('create_date', $row_table_design)){
		 				$wpdb->query("ALTER TABLE $table_design ADD COLUMN `create_date` DATETIME NULL AFTER `done`");
		 				
		 			}
		        }
		        

		}
	}
	function NJT_L_C_Create_Table_DB($table,$charset_collate){
	    $sql = 'CREATE TABLE '.$table.' (
		              `id` int(11) NOT NULL AUTO_INCREMENT,
		              `title` TEXT NULL,
		              `name` TEXT NULL,
		              `img`  TEXT NULL,
		              `please` TEXT NULL,
		              `like` TEXT NULL,
		              `comment` TEXT NULL,
		              `done` TEXT NULL,
		              UNIQUE KEY id (id)
		              ) '.$charset_collate.';';
		require_once ABSPATH.'wp-admin/includes/upgrade.php';
		dbDelta($sql);
	}
	function NJT_L_C_ADD_ROW_DB($table){
		global $wpdb;
		$title = "Default Template";
		$name="<p class='njt_like_comment_name'>Verify Your Access</p>";
		$img="";
		$please="<p>Please make sure you clicked LIKE and COMMENTED on [this Facebook post].</p>";
		$like="<p>Liked post</p>";
		$comment="<p>Commented (a minimum of [d] characters)</p>";
		$done="<p>I'm done!</p>";
		
		$wpdb->insert( $table, array('title' => $title, 'name' =>$name,'img' =>$img,'please' =>$please,'like' =>$like,'comment'=>$comment,'done'=>$done), array( '%s', '%s','%s','%s','%s','%s','%s') );	
	}
	
endif;
new NJT_APP_LIKE_COMMENT_FB_SETUP;