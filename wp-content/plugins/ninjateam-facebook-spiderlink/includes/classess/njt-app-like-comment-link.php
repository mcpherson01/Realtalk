<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('NJT_LINK_FB_LIKE_COMMENT_API')){
	class NJT_LINK_FB_LIKE_COMMENT_API{
		
		public $URL;
		private $options;
		private $settings;
		private $slug;
		public function __construct(){
			add_filter( 'jetpack_enable_open_graph', '__return_false' ); //Remove Jetpack’s Open Graph meta tags
			add_filter('wpseo_opengraph_desc', '__return_false' );
			add_filter('wpseo_opengraph_title', '__return_false' );
			add_filter('wpseo_opengraph_image', '__return_false' );
		}
		public function init(){
		}
		public function createPostLink(){
			Create_custom_post_type_campaign();  // call function campaign 
			//
			$new_page_title_process = 'process';
			$new_page_content_process = '';
			$page_check_process = get_page_by_title($new_page_title_process);
			if(!isset($page_check_process->ID)){
				$arr_new_page = array(
	  				'post_type' => 'page',
	  				'post_title' => $new_page_title_process,
	  				'post_content' => $new_page_content_process,
	  				'post_status' => 'publish',
	  				'post_author' => 1,
				);
  				$new_page_process_id = wp_insert_post($arr_new_page);
			}
		}
		function replace_featured_image_box(){  
			remove_meta_box( 'postimagediv', 'njt_fb_like_comment', 'side' );  
			remove_meta_box( 'postexcerpt', 'njt_fb_like_comment', 'normal' );  
		} 
		function njt_meta_box(){
			if(get_option('njt_app_fb_like_comment_user') && get_option('njt_app_fb_like_comment_user')!=""){
				// Title
				add_meta_box( 'njt-like_comment-setup-fb', '<span class="njt_setup_like_comment">Step 1</span> Set up Facebook post', array($this,'njt_like_comment_setup_fb_output'), 'njt_fb_like_comment','normal', 'high' );
				//
				add_meta_box( 'njt-like_comment-set-permission-access', '<span class="njt_setup_like_comment">Step 2</span> Set up permission to get secret link', array($this,'njt_like_comment_set_permission_access_output'), 'njt_fb_like_comment','normal', 'low' );

				add_meta_box( 'njt-like_comment-set-design-campaign', 'Campaign Template', array($this,'njt_like_comment_set_design_campaign_output'), 'njt_fb_like_comment','side');
			}
		}
		function njt_like_comment_setup_fb_output($post){
			Create_Step_1_setup_fb($post->ID);
		}
		function njt_like_comment_set_permission_access_output($post){
			Create_Step_2_permission_access($post->ID);
		}

		function njt_like_comment_set_design_campaign_output($post){
			Create_design_campaign($post->ID);
		}
	
		function njt_check_custom_post_type_page(){
			$currentScreen = get_current_screen();
			//echo $currentScreen->id;
			if( $currentScreen->id === "njt_fb_like_comment" ){
				add_action('admin_enqueue_scripts', array( $this, 'custom_post_type_page_admin_styles' ) );
				add_filter( 'post_updated_messages', array( $this, 'njt_link_fb_like_updated_messages' ) );
				add_filter( 'gettext', array( $this,'njt_change_publish_button'), 10, 2 ); // change text publish --> publish to facebook
				add_filter( 'enter_title_here', array( $this,'njt_change_default_title') );// change title default
				//
				add_action('admin_footer',array($this,'njt_admin_footer_select_option_image'));
			}elseif($currentScreen->id=="toplevel_page_njt-fb-api-settings"){
				add_action('admin_enqueue_scripts', array( $this, 'custom_post_type_page_admin_styles' ) );
				add_action('admin_footer',array($this,'njt_admin_footer_js'));
			}
			elseif($currentScreen->id === "spiderlink_page_list-user-subscriber"){
				add_action( 'admin_head', array( &$this, 'custom_admin_header_list_user' ) );
			}elseif($currentScreen->id ==="spiderlink_page_add-design"){
				add_action('admin_enqueue_scripts', array( $this, 'custom_post_type_page_admin_styles' ) );
				add_action('admin_footer',array($this,'njt_admin_footer_js'));
			}
		}
		function custom_admin_header_list_user(){
			$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
				if( 'list-user-subscriber' != $page )
					return; 
				echo '<style type="text/css">';
				echo '.listuser .column-id { width: 4%; }';
		  //echo '.listuser .column-in_send_list { width: 5%; }';
				echo '.listuser .column-email { width: 20%; }';
				echo '.listuser .column-category { width: 20%; }';
		 // echo '.listnotification .column-link { width: 20%; }';
				echo '</style>';
		}
		function  njt_admin_footer_select_option_image(){
		
			Create_Popup_Add_Facebook_Group();
		}

		function njt_change_publish_button($translation,$text){
			if($text=="Publish")
				return "Publish to Facebook";
			if($text=="Update")
				return "Update";
			return $translation;
		}
		function njt_change_default_title($title){
			return $title = 'Enter campaign title here';
		}
		function njt_admin_footer_js(){
	    	?>
	    	<script src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/js/editor/medium-editor.js'; ?>"></script>
	    	<script src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/js/editor/handlebars.runtime.min.js'; ?>"></script>
	    	
	    	<script src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/js/editor/medium-editor-insert-plugin.min.js'; ?>"></script>
	    	<script src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/js/editor/call_editor.js'; ?>"></script>
	    	<?php
	    }
		function custom_post_type_page_admin_styles(){
        	// editor
        	wp_enqueue_style('njt-app-fb-like-comment-admin-editor',NJT_APP_LIKE_COMMENT_URL.'assets/css/editor/medium-editor.min.css');
        	wp_enqueue_style('njt-app-fb-like-comment-admin-editor1',NJT_APP_LIKE_COMMENT_URL.'assets/css/editor/medium-editor-insert-plugin.min.css');
        	wp_enqueue_style('njt-app-fb-like-comment-admin-editor2',NJT_APP_LIKE_COMMENT_URL.'assets/css/editor/editor.css');
        	//
        	wp_enqueue_script('njt-app-fb-like-comment-custom-js',NJT_APP_LIKE_COMMENT_URL.'assets/js/custom-js.js',array('jquery'),time());
		}
		function njt_link_fb_like_updated_messages($message){
				global $post;
			//	echo "<pre>";
			//	print_r($post);
			//	echo "</pre>";
			if($post->post_status=="publish"){
				if(isset($_GET['post']) && $_GET['post']):
					$publish_to=get_post_meta( $_GET['post'], 'njt_like_comment_publish_to',true);
					if($publish_to=="fanpage" || $publish_to==""):
						$id_post_fb_auto_page=get_post_meta( $_GET['post'], 'njt_like_comment_post_fb_auto_page',true);
					else:
						$id_post_fb_auto_timeline=get_post_meta( $_GET['post'], 'njt_like_comment_post_fb_auto_timeline',true);
					endif;
				endif;
			 	if(get_option('njt_token_full_permission')){
					if(isset($_GET['message']) && $_GET['message']):?>
						<div id="message" class="updated notice is-dismissible"><p><?php
							if($publish_to=="fanpage" || $publish_to==""):?>
								<a target="_blank" href="https://www.facebook.com/<?php echo $id_post_fb_auto_page;?>">View post on Facebook</a>
							<?php elseif($publish_to=="timeline"): ?>
								<a target="_blank" href="https://www.facebook.com/<?php echo $id_post_fb_auto_timeline; ?>">View post on to Facebook</a>
							<?php else:?>
								<a href="#add_height_fb_t_g">Save Changes! Now copy this content to the group.</a>
							<?php endif; ?>
						</p></div>
					<?php endif;?>
				<?php }else{ ?>
					<div style="margin-left: 0px;margin-top: 15px;" class="notice notice-error is-dismissible mst-popup-notifi-save-changed show-error-fail-access-token">
						<p><?php _e('Please enter the Access Token to use this feature!',NJT_APP_LIKE_COMMENT) ?></p>
					</div>
					
				<?php } ?>
			<?php } else if($post->post_status=="draft"){?>
					<div id="message" class="updated notice notice-success is-dismissible"><p>Post updated. <a target="_blank" href="<?php echo get_the_permalink($post->ID); ?>">View post</a></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
			<?php }
		}
		// FUNCTION SAVE CUSTOM POST TYPE
		function njt_link_fb_like_commnent_save( $post_id,$post){

			global $post;
			global $wp_rewrite;
			$wp_rewrite->flush_rules(false);
			if(isset($post->post_status) && $post->post_status!="auto-draft" && !empty($post)) :
			  $array_post=get_post($post_id);
				if(isset($_POST['njt_link_like_comment_nonce']))	{
					$njt_link_like_comment_nonce = $_POST['njt_link_like_comment_nonce'];
					if( !isset( $njt_link_like_comment_nonce ) ) {
						return;
					}
					if( !wp_verify_nonce( $njt_link_like_comment_nonce, 'save_njt_link' ) ) {
						return;
					}
				}
				// design campaign
				if(isset($_POST['njt_design_campaign'])){
					$design_campaign = $_POST['njt_design_campaign'];
					update_post_meta( $post_id, 'njt_design_campaign', $design_campaign );
				}
				// title
				if(isset($_POST['njt_like_comment_title'])){
					$title = sanitize_text_field( $_POST['njt_like_comment_title'] );
					update_post_meta( $post_id, 'njt_like_comment_title', $title );
				}
				//  description
				if(isset($_POST['njt_like_comment_description'])){
					$description = sanitize_text_field( $_POST['njt_like_comment_description'] );
					update_post_meta( $post_id, 'njt_like_comment_description', $description );
				}
				// secrect url
				if(isset($_POST['njt_like_comment_secrect_url'])){
					$secrect_url = sanitize_text_field( $_POST['njt_like_comment_secrect_url'] );
					update_post_meta( $post_id, 'njt_like_comment_secrect_url', $secrect_url );
				}
				// image
				if(isset($_POST['njt_like_comment_image'])){
					$image_url = sanitize_text_field( $_POST['njt_like_comment_image'] );
					update_post_meta( $post_id, 'njt_like_comment_image', $image_url );
				}	
				//  message
				if(isset($_POST['njt_like_comment_message'])){
					//$message = sanitize_text_field( $_POST['njt_like_comment_message'] );
					$message = html_entity_decode(esc_textarea($_POST['njt_like_comment_message']));
					update_post_meta( $post_id, 'njt_like_comment_message', $message );
				}
				// user like
				$user_like = isset( $_POST['njt_like_comment_userlike'] ) ? $_POST['njt_like_comment_userlike'] : "";
				update_post_meta( $post_id, 'njt_like_comment_userlike', $user_like );
				//  user comment
				$user_comment = isset( $_POST['njt_like_comment_usercomment'] ) ? $_POST['njt_like_comment_usercomment'] : "";
				update_post_meta( $post_id, 'njt_like_comment_usercomment', $user_comment );
				//	number comment
				$number_comment = isset( $_POST['njt_like_comment_number_comment'] ) ? $_POST['njt_like_comment_number_comment'] : 0;
				update_post_meta( $post_id, 'njt_like_comment_number_comment', $number_comment );
				//  url_post_fb ?? yes / no
				$custom_url_option = isset( $_POST['njt_like_comment_another_url_post_fb'] ) ? $_POST['njt_like_comment_another_url_post_fb'] : "";
				update_post_meta( $post_id, 'njt_like_comment_another_url_post_fb', $custom_url_option );
				if($custom_url_option!="")
				{
					$njt_input_url_post = sanitize_text_field( $_POST['njt_like_comment_input_url_post'] );
					update_post_meta( $post_id, 'njt_like_comment_input_url_post', $njt_input_url_post );
				}
				//  publish to ? fanpage or timeline
				$publish_to = isset( $_POST['njt_like_comment_publish_to'] ) ? $_POST['njt_like_comment_publish_to'] : "";
				update_post_meta( $post_id, 'njt_like_comment_publish_to', $publish_to );

				//  page
				if($publish_to=="" || $publish_to=="fanpage"){
					if(isset($_POST['njt_like_comment_page_manager'])){
						$id_page = sanitize_text_field( $_POST['njt_like_comment_page_manager'] );
						update_post_meta( $post_id, 'njt_like_comment_page_manager', $id_page );
					}
				}

				if(isset($_POST['njt_like_comment_group_manager'])){
						$id_group = sanitize_text_field( $_POST['njt_like_comment_group_manager'] );
						update_post_meta( $post_id, 'njt_like_comment_group_manager', $id_group );
						
						$hashcode=sanitize_text_field( $_POST['njt_like_comment_hashcode'] );
						update_post_meta($post_id,'njt_like_comment_hashcode',$hashcode);
					
						$njt_spider_fb_message_post_group=sanitize_text_field( $_POST['njt_spider_fb_message_post_group'] );
						update_post_meta($post_id,'njt_spider_fb_message_post_group',$njt_spider_fb_message_post_group);
						
				}

			if($array_post->post_status=="publish"){

				$key= 'njt_like_comment_link_'.$post_id;
				if(!get_option($key) || get_option($key)){
					$token_amin = get_option('njt_app_fb_like_comment_user');
					$fb_api_set = new  NJT_APP_LIKE_COMMENT_API();
					try{
						$check_token = $fb_api_set->checkToken($token_amin);
						if(is_object($check_token) ){
							if(!$check_token->isError() || $check_token->getIsValid()){
								 $link = get_permalink($post_id);
								// $metaf = $fb_api_set->NJT_fetchMeta_1($link,$token_amin);
								 $metaf2 = $fb_api_set->NJT_fetchMeta_2($link,$token_amin);
							//	print_r($metaf);
							//	print_r($metaf2);
					 		//	die;
								update_option($key,true);
							}
						}
					}
					catch(Exception $ex){
					}
				}
				
				if(get_option('njt_token_full_permission')){

					if($publish_to=="fanpage" || $publish_to=="" || $publish_to=="timeline"):  // FANPAGE
						/*Auto Post*/
						$id_page = get_post_meta( $post_id, 'njt_like_comment_page_manager', true );
						$token =get_option('njt_token_full_permission');
						$fb_api = new  NJT_APP_LIKE_COMMENT_API();
						$message = get_post_meta( $post_id, 'njt_like_comment_message', true );
						$link_url =get_the_permalink($post_id);
						// AUTO POST FANPAGE
						if($publish_to=="fanpage" || $publish_to==""):  // FANPAGE
					 		// Auto Post Publish  Conten On FanPage
							if(!get_post_meta( $post_id, 'njt_like_comment_post_fb_auto_page',true)){

								if(!empty($id_page)){

									$id_post_fb_auto=$fb_api->Publish_post_in_page($message,$link_url,$token,$id_page);
								
									update_post_meta( $post_id, 'njt_like_comment_post_fb_auto_page',$id_post_fb_auto['id']);
								}
							}
							else{

								if(!empty($id_page)){
									$id_post_fb_auto=get_post_meta( $post_id, 'njt_like_comment_post_fb_auto_page',true);
									$fb_api->Edit_Post($message,$link_url,$token,$id_post_fb_auto);

								}
							
							}
						else :  // TIMELINE
							
							$link_url = esc_url(get_the_permalink(get_the_ID($post_id)));
						
							// Auto Post Publish  Conten On Timeline (wall me)
							if(!get_post_meta( $post_id, 'njt_like_comment_post_fb_auto_timeline',true)){
								$id_post_fb_auto_timeline=$fb_api->Publish_post_to_Timeline($message, $link_url,$token);
								update_post_meta( $post_id, 'njt_like_comment_post_fb_auto_timeline',$id_post_fb_auto_timeline['id']);
							}
							else{
								$id_post_fb_auto_timeline=get_post_meta( $post_id, 'njt_like_comment_post_fb_auto_timeline',true);
								$fb_api->Edit_Post($message, $link_url,$token,$id_post_fb_auto_timeline);
							}
						endif;

					endif;
				}
			}

			endif;
		}	
		public function _post_updated($post_id,$post_after,$post_before){
			print_r($post_after);
		}
		
		function app_njt_fb_like_comment_columns($columns){
			// New columns to add to table
		/*	
			$new_columns = array(
				'click' => __( 'Click', NJT_APP_LIKE_COMMENT ),
				'date' => __( 'Date', NJT_APP_LIKE_COMMENT )
				);
			  // Remove unwanted publish date column
			unset( $columns['date'] );
			 // Combine existing columns with new columns
			$filtered_columns = array_merge($columns,$new_columns);
			  // Return our filtered array of columns
			return $filtered_columns;
		*/
			 unset( $columns['date'] );
		    $columns['click'] = __( 'Click', NJT_APP_LIKE_COMMENT );
		    $columns['shortcode'] = __( 'Shortcode', NJT_APP_LIKE_COMMENT );
		    $columns['date'] = __( 'Date',NJT_APP_LIKE_COMMENT);

		    return $columns;
		}
		function app_njt_fb_like_comment_custom_column_content($column){
			global $post;
			switch ( $column ) {
				case 'click' :
				      // Retrieve post meta
						$click = get_post_meta( $post->ID, 'njt_like_comment_click', true );
						if($click)
							echo $click;
						else
							echo 0;

				break;
				case 'shortcode':
					$link = get_the_permalink($post->ID);
					$text = "View Now";
					$value_shortcode ="[spiderlink text='".$text."' url ='".$post->ID."']";
					echo '<input style="width: 80%;" type="text" readonly="readonly" class="njt_abd_webhooks" onclick="select();" value="'.$value_shortcode.'"';
					//echo '[spiderlink text="View Now" link ="Yolo"]';
				break;
			}
		}

		function app_njt_fb_like_comment_columns_sortable( $columns ) {
			// Add our columns to $columns array
			$columns['click'] = 'Click';
			$columns['shortcode'] = 'Shortcode';
			$columns['date'] = 'Date';
			return $columns;
		}
		// Redirect single custom post type
		function redirect_custom_post_type($template_path){
			global $post;
			$page_process = get_page_by_title('process');
			if ( get_post_type() == 'njt_fb_like_comment' ) {
				if ( is_single() ) {
					$template_path = NJT_APP_LIKE_COMMENT_INC . 'views/njt_like_comment_single.php';
				}
			}else if(is_page() && $post->ID==$page_process->ID){

					$template_path = NJT_APP_LIKE_COMMENT_INC . 'views/njt_like_comment_page.php';
			}
			return $template_path;
		}
		public function add_options_page( $args=array(), $options = array() ){
				global $post;
				$this->options = $options;
				$this->slug = "link-likecomment";
				$this->textdomain ="njt-app-like-comment-fb";
				$defaults = array(
					'parent'     => 'njt-fb-api-settings',
					'menu_title' => 'Links',
					'page_title' => 'Links',
					'capability' => 'manage_options',
					'link'       => true
					);
				$this->settings = wp_parse_args( $args, $defaults );
				$this->admin_url = admin_url( 'admin.php?page=' . $this->slug );
				add_action('do_meta_boxes', array($this,'replace_featured_image_box'));
				add_action('admin_menu',array(&$this,'options_page'));
				add_action('init',array($this,'createPostLink'));
				add_action( 'add_meta_boxes',  array($this,'njt_meta_box'));
				add_action( 'save_post', array($this,'njt_link_fb_like_commnent_save'),1,2);
		//		add_action( 'post_updated', array($this,'_post_updated'),10,3);
				/*filter line */
				add_action( 'current_screen',array( $this,'njt_check_custom_post_type_page' ));
				add_filter( 'template_include', array($this,'redirect_custom_post_type'), 1 );
				add_action( 'admin_head', array( &$this, 'admin_header' ) );
				// add columns
				add_filter('manage_njt_fb_like_comment_posts_columns' , array( $this,'app_njt_fb_like_comment_columns'));
				
				add_action( 'manage_njt_fb_like_comment_posts_custom_column', array( $this,'app_njt_fb_like_comment_custom_column_content' ) );
				// Let WordPress know to use our filter
				add_filter( 'manage_edit-njt_fb_like_comment_sortable_columns', array( $this,'app_njt_fb_like_comment_columns_sortable' ) );
				// show image and title description on facebook use ob_fb
				add_action( 'wp_head', array($this,'njt_fb_wp_og_fb'),1,1);
		}
		function  options_page() {
			global $submenu;
			$link = $submenu['njt-fb-api-settings'][0];
			unset($submenu['njt-fb-api-settings'][0]);
			$submenu['njt-fb-api-settings'][]=$link;
		}
		function admin_header(){
			global	$post;
			if(isset($post->post_type) && !isset($post->post_type)=='njt_fb_like_comment'){
				return ;
			}
			echo '<style type="text/css">';
			echo '#postexcerpt .inside p { display: none; }';
			echo '</style>';
		}
		// show image title description
		public	function og_fb(){
				global $post;
				$image = get_post_meta( $post->ID, 'njt_like_comment_image', true );
				$title = get_post_meta( $post->ID, 'njt_like_comment_title', true );
				$content = get_post_meta( $post->ID, 'njt_like_comment_description', true );
				?>
				<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:type" content="article" />
				<meta property="og:title" content="<?php echo !empty($title)? $title:$post->post_title;  ?>" />
				<meta property="og:description" content="<?php echo $content;?>" />
				<meta property="og:image" content="<?php echo !empty($image) ? $image:NJT_APP_LIKE_COMMENT_URL.'assets/images/default.png'; ?>" />
				<meta property="fb:app_id" content="<?php echo get_option('njt_app_like_comment_app_id',true ); ?>" />
				<meta property="og:image:width" content="1200" />
				<meta property="og:image:height" content="630" /><?php
		}
		public	function njt_fb_wp_og_fb(){
				global $post;
				if(is_object($post)){
					if($post->post_type=='njt_fb_like_comment'){
						if(class_exists('MASHSB_HEADER_META_TAGS')){
							apply_filters( 'mashsb_opengraph_meta', array($this,$og_fb));
						}else{
							$this->og_fb();
						}
					}
				}
		}
	}
}
?>