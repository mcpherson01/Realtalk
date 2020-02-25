<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directlyhm;
if(!class_exists('NJT_APP_LIKE_COMMENT_ADMIN_SETTINGS')){
	class NJT_APP_LIKE_COMMENT_ADMIN_SETTINGS{
		public function __construct() {
			add_action('admin_menu', array($this, 'admin_menu_settings'));
			add_action('admin_enqueue_scripts', array( $this, 'admin_styles' ) );
			add_action('wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
			add_action('admin_init',array($this,'njt_fb_api_like_comment_settings'));
			add_action('init', array($this,'njt_advoid_do_output_buffer')); //(1)
			// AJAX
			add_action( 'wp_ajax_njt_like_comment_settings_alert', array( $this, 'njt_like_comment_settings_alert_call' ));
        	add_action( 'wp_ajax_nopriv_njt_like_comment_settings_alert', array($this, 'njt_like_comment_settings_alert_call') );
        	add_action( 'wp_ajax_njt_like_comment_export_csv', array( $this, 'njt_like_comment_export_csv_call' ));
        	add_action( 'wp_ajax_nopriv_njt_like_comment_export_csv', array($this, 'njt_like_comment_export_csv_call') );

        	//
        	add_action( 'wp_ajax_njt_like_comment_find_group_id_name', array( $this, 'njt_like_comment_find_group_id_name' ));

        	add_action( 'wp_ajax_njt_like_comment_add_new_group', array( $this, 'njt_like_comment_add_new_group' ));

        	// renew mailchimp
        	add_action( 'wp_ajax_njt_renew_mailchimp', array( $this, 'njt_renew_mailchimp' ));
        	add_action( 'wp_ajax_njt_spiderlink_mailChimpSyc', array( $this, 'njt_spiderlink_mailChimpSyc' ));
        	//
        	add_shortcode('spiderlink',array($this,'njt_spiderlink_shortcode'));
		}	
		public function njt_advoid_do_output_buffer(){
			ob_start(); // fixed : Warning: Cannot modify header information - headers already sent by (output started at (1)
		} 
		public function njt_fb_api_like_comment_settings(){
			//session_start();
			ob_start(); // fixed : Warning: Cannot modify header information - headers already sent by (output started at (2)
			register_setting( 'njt_app_like_comment','njt_app_like_comment_app_id');
			register_setting( 'njt_app_like_comment','njt_app_like_comment_app_id_serect');
			register_setting( 'njt_app_like_comment','njt_token_full_permission');
			register_setting( 'njt_app_like_comment','njt_app_like_comment_app_custom_slug');
			register_setting('njt_app_like_comment','njt_app_like_comment_app_is_cache');
			register_setting('njt_app_like_comment','njt_like_comment_publish_to');
			register_setting('njt_app_like_comment','njt_spiderlink_mail_chimp_api_key');
			register_setting('njt_app_like_comment','njt_spiderlink_mail_chimp_api_active');
		}
		public function admin_menu_settings() {
			add_menu_page(__('SpiderLink',NJT_APP_LIKE_COMMENT), __('SpiderLink', NJT_APP_LIKE_COMMENT),'manage_options', 'njt-fb-api-settings', array($this, 'call_fb_api_settings'), NJT_APP_LIKE_COMMENT_URL.'assets/images/icon.svg','56');
		if(get_option('njt_app_fb_like_comment_user')) :
			add_submenu_page( 'njt-fb-api-settings', __('Add New Campaign',NJT_APP_LIKE_COMMENT),__('Add New Campaign',NJT_APP_LIKE_COMMENT), 'manage_options', 'post-new.php?post_type=njt_fb_like_comment');
			add_submenu_page( 'njt-fb-api-settings', __('Facebook Group',NJT_APP_LIKE_COMMENT),__('Facebook Group',NJT_APP_LIKE_COMMENT), 'manage_options', 'list-fb-group',array($this,'call_fb_list_fb_group'));
			//
			add_submenu_page( 'njt-fb-api-settings', __('All Templates',NJT_APP_LIKE_COMMENT),__('Templates',NJT_APP_LIKE_COMMENT), 'manage_options', 'list-design',array($this,'call__list_design'));

			add_submenu_page( 'njt-fb-api-settings', __('Add New Design',NJT_APP_LIKE_COMMENT),__('Add New Design',NJT_APP_LIKE_COMMENT), 'manage_options', 'add-design',array($this,'call__add_design'));
			//
		    $hook=add_submenu_page( 'njt-fb-api-settings', __('Subscriber List',NJT_APP_LIKE_COMMENT),__('Subscriber List',NJT_APP_LIKE_COMMENT), 'manage_options', 'list-user-subscriber',array($this,'call_fb_list_user_settings'));
		    add_action( "load-$hook", array($this,'njt_show_screen_option_list_user'));
			add_filter('set-screen-option',array($this,'pippin_set_screen_option'), 10, 3);
			add_submenu_page( 'njt-fb-api-settings', __('Settings',NJT_APP_LIKE_COMMENT),__('Settings',NJT_APP_LIKE_COMMENT), 'manage_options', 'njt-fb-api-settings', array($this,'call_fb_api_settings') );
			add_submenu_page( 'njt-fb-api-settings', __('Support',NJT_APP_LIKE_COMMENT), __('Support',NJT_APP_LIKE_COMMENT), 'manage_options', '');
			add_submenu_page( 'njt-fb-api-settings', __('More Plugins',NJT_APP_LIKE_COMMENT), __('More Plugins',NJT_APP_LIKE_COMMENT), 'manage_options', '');
		endif;
		}
		public function admin_styles(){
			wp_enqueue_style('njt-app-fb-like-comment-admin-style',NJT_APP_LIKE_COMMENT_URL.'assets/css/admin.css',array(),NJT_APP_LIKE_COMMENT_VERSION);

        	wp_enqueue_style('njt-fb-api-font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

        	wp_enqueue_script('njt-fb-api-settings-js',NJT_APP_LIKE_COMMENT_URL.'assets/js/njt-like-comment.js',array('jquery'),NJT_APP_LIKE_COMMENT_VERSION);

        	wp_enqueue_media();
		}
		public function frontend_styles(){
			global $post;
			wp_enqueue_style('njt-app-fb-like-comment-fr-style',NJT_APP_LIKE_COMMENT_URL.'assets/css/front-end.css',array(),NJT_APP_LIKE_COMMENT_VERSION);
			wp_enqueue_style('njt-app-fb-like-comment-font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
            if(get_option('njt_app_like_comment_app_is_cache') && !empty(get_option('njt_app_like_comment_app_is_cache'))) :
            	if($post->post_type=="njt_fb_like_comment"):
			wp_enqueue_script('njt-fb-api-settings-is-cache-js',NJT_APP_LIKE_COMMENT_URL.'assets/js/check_is_cache.js',array('jquery'),NJT_APP_LIKE_COMMENT_VERSION);
		        endif;
		    endif;
		    wp_enqueue_style('njt-app-fb-like-comment-admin-editor2',NJT_APP_LIKE_COMMENT_URL.'assets/css/editor/editor.css',array(),NJT_APP_LIKE_COMMENT_VERSION);
		}
	    public function call_fb_api_settings(){
	    	require_once(NJT_APP_LIKE_COMMENT_INC.'settings_fb_api.php');
	    }
	    // AJAX
	    public function njt_like_comment_settings_alert_call(){
	    	if(isset($_POST['name']) && isset($_POST['please']) && isset($_POST['like']) && isset($_POST['comment']) && isset($_POST['done']))
	    	{
	    		global $wpdb;
	    		$design_table=$wpdb->prefix.'njt_like_comment_design';
	    		$design_action =$_POST["design_action"];
	    		
	    		$title = !empty($_POST['title']) ? $_POST['title'] : "Title Design";
	    		$name=stripslashes($_POST['name']);
	    		$img=stripslashes($_POST['img']);;
	    		$please=stripslashes($_POST['please']);
	    		$like=stripslashes($_POST['like']);
	    		$comment=stripslashes($_POST['comment']);
	    		$done=stripslashes($_POST['done']);
	    		if($design_action=="none"){

	    			$wpdb->insert( $design_table, 
								array( 
										'title' => $title,
										'name' => $name,
										'img' => $img,
										'please' => $please,
										'like'=>$like,
										'comment' => $comment,
										'done' => $done,
										
									), array( '%s','%s','%s','%s','%s','%s','%s' ));
	    		}else{
	    			$wpdb->update( $design_table,array('title'=>$title,'name' => $name,'img'=>$img,'please' => $please,'like'=>$like,'comment'=>$comment,'done'=>$done),array( 'ID' => $design_action ), array('%s','%s','%s','%s','%s','%s','%s'),array( '%d' ));
	    		}
	            echo "success"; die;
	    	}
	    }
	    // show screen option
	    public function njt_show_screen_option_list_user(){
	    	$args = array(
				'label' => __('Members per page', 'pippin'),
				'default' => 20,
				'option' => 'njt_l_c_user__per_page'
			);
			add_screen_option( 'per_page', $args );
	    }
	    public function pippin_set_screen_option($status, $option, $value) {
				if ( 'njt_l_c_user__per_page' == $option ) return $value;
		}
	    // list menu user subscriber
	    public function call_fb_list_user_settings(){
	    	include_once(NJT_APP_LIKE_COMMENT_INC.'classess/tables-user.php');
	    	$this->table = new NJT_L_C_List_Table_User();
	    	$list_user =$this->table;
			?>
			<div style="margin: 10px 20px -35px 0px" class="wrap"><h1 class="wp-heading-inline">Subscriber List</h1></div>
	        <div id='list-users' class="wrap list-slide">
	            <div id="icon-users" class="icon32"><br/></div>
	          <h2><?php __('List User',NJT_APP_LIKE_COMMENT) ?></h2>
	          <form id="movies-filter" method="get">
	               <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
	               <?php 
	               $list_user->prepare_items(); 
	               $list_user->search_box(__('Search Subscribers', NJT_APP_LIKE_COMMENT), 'search_user_id');  
	               $list_user->display() ;
	               ?>
	          </form>
	        </div>
       <?php
	    }

	    //
	    public function call_fb_list_fb_group(){
	    	include_once(NJT_APP_LIKE_COMMENT_INC.'classess/tables-group.php');
	    	$this->table = new NJT_L_C_List_Facebook_Group();
	    	$list_user =$this->table;
			?>
			<div style="margin: 10px 20px -35px 0px" class="wrap"><h1 class="wp-heading-inline">Facebook Group</h1></div>
			<div id='list-users' class="wrap list-slide">
	            <div id="icon-users" class="icon32"><br/></div>
	          <h2><?php __('List Group',NJT_APP_LIKE_COMMENT) ?></h2>
	          <form id="movies-filter" method="get">
	               <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
	               <?php 
	               $list_user->prepare_items(); 
	               $list_user->search_box(__('Search Groups', NJT_APP_LIKE_COMMENT), 'search_user_id');  
	               $list_user->display() ;
	               ?>
	          </form>
	        </div>


	        <!-- popup -->
	        <div class="spider_create_group_popup">
			    <div class="spider_create_group_format_body">
			        <!--<a title="Close" class="spider_close_popup" href="javascript:;"></a>-->
			           	<div class="spider-popup-content">
			                <form id="frm_add_new_group_spider" class="form-horizontal" >
			                    <div class="form-group row">
			                        <div class="col-md-12">
			                            	<p style="text-align: center;color: red;display: none;" id="spider_add_group_error"></p><!-- <?php _e("Data is not valid, cannot be added",'spiderlink-fb');?>-->
			                            	<input type="hidden" id="njt_spider_fb_group_id" name="njt_spider_fb_group_id" value="">
				                          	<span style="display: none;">  
				                            	<p class="p_njt_app_like_comment">Enter Group Name</p>
				                            	<input disabled="disabled" class="form-control" type="text" style="width:100%;height: 35px;" id="njt_spider_fb_group_name" name="njt_spider_fb_group_name" value="">
				                            </span>
			                            	<p style="font-weight: bold;" class="njt_spider_margin p_njt_app_like_comment">Enter New Facebook Group URL</p>
			                            	<input class="form-control" type="text" style="width:100%;height: 35px;" id="njt_spider_fb_group_url" name="njt_spider_fb_group_url" value="">
			                            	<p>Please enter a Facebook <b style="font-weight: bold;">public group</b> URL, for example <a style="text-decoration: none;" target="_blank" href="https://facebook.com/groups/1990915214520705/">https://facebook.com/groups/1990915214520705/</a></p>
			                            	<div style="display: none;" id="njt-loader"></div>
			                            	<strong><p id="njt_spider_parse_group_name" style="padding-top: 10px;"></p></strong>
			                        </div>
			                    </div>
			                </form>
			                 <p style="float: right;" class="njt_spider_margin p_njt_app_like_comment">
			                 	<a style="float: left; margin: 1px 20px 0px 20px;" class="button njt_close_popup_gr" href="javascript:void(0)">Cancel</a>

			                 	<a id="njt-btn-add-gr-menu" href="javascript:void(0)" class="button button-primary button-large">Add New Facebook Group</a>
			                 	<!--
			                    <button name="njt_spider_add_group" id="njt_spider_add_group_tab_menu" class="btn btn-primary">Add new group</button>
			                	-->
			                 </p>
			           </div>
			    </div>
			</div>
	        <!-- poppup-->

       <?php
	    }

	    //
	    public function call__list_design(){
	    	require_once(NJT_APP_LIKE_COMMENT_INC.'all-design.php');
	    } 

	    public function call__add_design(){
	    	require_once(NJT_APP_LIKE_COMMENT_INC.'add-new-design.php');
	    }
	    //
	    
	    // AJAX EXPORT FILE 
	    public function njt_like_comment_export_csv_call(){
	    	if(isset($_POST['export'])){
				$args=array(
		          'posts_per_page' => -1,
		          'post_type'=>'njt_user_subscriber',
		        );
		        $users  = new  WP_Query($args);
		       	foreach ($users->posts as $key => $value) {
		       		$user_subscriber[]=array($value->ID,get_post_meta($value->ID,'njt_fb_l_c_first_name_user' ,true),get_post_meta($value->ID,'njt_fb_l_c_last_name_user' ,true),'https://facebook.com/'. get_post_meta($value->ID,'njt_fb_l_c_id_user' ,true),get_post_meta($value->ID,'njt_fb_l_c_email_user' ,true),get_post_meta($value->ID,'njt_fb_l_c_gender_user' ,true),get_post_meta($value->ID,'njt_fb_l_c_lang_user' ,true),get_the_date('m/d/Y',$value->ID));
		       	}
		       	$file__csv = wp_upload_dir()['basedir'].'/spiderlink.csv';
		       	if(file_exists($file__csv)){
		       		 unlink($file__csv);
		       	}

		   		$filename ="spiderlink.csv";
				$fp = fopen($file__csv, 'w');
		   		header('Content-type: application/csv');
		   		header('Content-Encoding: UTF-8');
    			header('Content-Type: text/csv; charset=utf-8' );
				header('Content-Disposition: attachment; filename='.$filename);
	    		foreach ($user_subscriber as $key => $list) {
	    				fputcsv($fp, $list);
	    		}
			    echo "success";
	    		die;
	    	}
	    }


	    public function njt_like_comment_find_group_id_name(){
	    	if(isset($_POST['group_url'])){
				$fb_api = new NJT_APP_LIKE_COMMENT_API();
  				//$user_token = get_option('njt_app_fb_like_comment_user');
  				$user_token =get_option('njt_token_full_permission');
				$group_url=!empty($_POST['group_url']) ? $_POST['group_url'] :"";

				if(!empty($group_url)){
					$check=strstr($group_url,'facebook.com/groups/');
					if($check){
  						$arguments = explode('/', $group_url);
  						$group_id=$arguments[4];

	  					if(is_numeric($group_id)){
	    					$data_group=$fb_api->SpiderLink_Group_Name($group_id,$user_token);
	    					
	    					if(isset($data_group["error"]["message"])){
	    						echo $data_group["error"]["message"];die;
	    					}else{
	    						
					    		echo json_encode($data_group);die;
	    					}
	   					
	  					}else{
	    					
	    					$data_group=$fb_api->SpiderLink_Group_ID_Name_Search($group_id,$user_token);
						    if(empty($data_group)){
						     	die("No result");
						    }else if(gettype($data_group)=="object"){
						     	echo json_encode($data_group);die;
						    }else{
						      die($data_group);
						    }
  						}
  					//	die;
					}else{
						die("No result");
					}
				}
			}
	    }

	    //
	    public function njt_like_comment_add_new_group(){

	    	if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['group_url'])){
				$id=!empty($_POST['id']) ? $_POST['id'] : "";
				$name=!empty($_POST['name']) ? $_POST['name'] : "";
				$group_url=!empty($_POST['group_url']) ? $_POST['group_url'] : "";
				$fb_api = new NJT_APP_LIKE_COMMENT_API();
  				$user_token =get_option('njt_token_full_permission');
  				if(!empty($group_url)){
					$check=strstr($group_url,'facebook.com/groups/');
					if($check){
  						$arguments = explode('/', $group_url);
  						$group_id=$arguments[4];

	  					if(is_numeric($group_id)){
	    					$data_group=$fb_api->SpiderLink_Group_Name($group_id,$user_token);
	    					
	    					if(isset($data_group["error"]["message"])){
	    						echo $data_group["error"]["message"];die;
	    					}
	  					}else{
	    					
	    					$data_group=$fb_api->SpiderLink_Group_ID_Name_Search($group_id,$user_token);
						    if(gettype($data_group)=="string"){
						    	echo $data_group;die;
						    }
  						}
					}else{
						die("No result");
					}
				}else{
					die("error1");//url not correct format
				}

			   	$post_group = new NJT_POST_TYPE_USER_SUB();
			  		
			  	$agrs = array(
							'id_group'=>$id,
				);

			  	if(!$post_group->CheckGroupExit($agrs)){
			  	
			  			$arr_group = array(
	            				'mess' => 'group'.rand(111111,999999),
	           					'post_date' => current_time('Y-m-d H:i:s'),
	            				'post_type' => 'njt_fb_gr',
	            				'post_status' => 'publish',
	            				'njt_fb_gr_id_group'=>$id,

								'njt_fb_gr_name_group'=>$name,
								'njt_fb_gr_group_url'=>$group_url,
								
	       				);
			  			$User_post_id=$post_group->Insert_Group($arr_group);
			  			
			            $option="<option selected='selected' value='".$id."'>".$name."</option>"; echo $option;die;
			            ?>
  						<?php }else{echo "exits";die;?>
  						<?php }
  			
					
			}

	    }

	    // RENEW MAIL CHIMP
	    public function njt_renew_mailchimp(){
	    		$api = new NJT_SPIDERLINK_API_MAIL_CHIMP();
				$api->fetch_lists();
				echo wp_send_json_success( );
				exit();
	    }
	    // Mail Chimp Sync
	    public function njt_spiderlink_maillchimp_sub_user($list,$value,$i=0,$j=0){
				if(is_array($list)){
					$error='';
					$count = ceil(count($list)/500);
					$api_mailchip = new NJT_SPIDERLINK_API_MAIL_CHIMP();
						if($i<=$count){
						 $item_user= array();
						 while ($j < $i*500-1 && isset($list[$j])){
						 	$item_user[]=$list[$j];
						 	$j++;
						}
							$args = array(
								'members'=>$item_user,
								'update_existing'=>true
							);
							try{
							$subscribed=	$api_mailchip->UserSub($value,$args);
							}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING $x){
							$error= ''.$x ;
							return array('msg'=>$error,'status'=>false);
			}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX_RESOURCE_NOT_FOUND $e){
				$error= ''. $e;
				return array('msg'=>$error,'status'=>false);
			}
			catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX $e){
				$error= ''. $e ;
				return array('msg'=>$error,'status'=>false);
			}
			return $j;
					}else{
						return true;
					}
				}
				return array('msg'=>$error,'status'=>false);
			}
	    public function njt_spiderlink_mailChimpSyc(){
	    	error_reporting(E_ALL);
	        ini_set('display_errors', '0');
	        $i = isset($_GET['i'])?$_GET['i']:0;
	        $j = isset($_GET['j'])?$_GET['j']:0;
			$user = new NJT_POST_TYPE_USER_SUB();
			$list = $user->getAllUserAddMailChimp();
			$list_un=array_unique($list,SORT_REGULAR);
			$list_error = array();
			$list_mail_chimp = $list=get_option('njt_spiderlink_mail_chimp_api_active');
			if($list_mail_chimp!=false){
					foreach ($list_mail_chimp as $key => $value){
						$list_users = array();
						foreach ($list_un as $key_user => $item) {
							$list_users[]=$item;
						};
						$count_sub=$this->njt_spiderlink_maillchimp_sub_user($list_users,$value,$i,$j);
						$list_error[$value]=$count_sub['msg'];
					}
					wp_send_json_success(array(
						'msg'=>__('Sync Done!, ','njt-app-like-comment-fb'),
						'count_send'=>$count_sub,
						'total'=>count($list_users),
						'status'=>true,
						));
			}else{
					wp_send_json_error(array('msg'=>__( 'You need to select a MailChimp list to sync'), 'njt-fi' ));
			}
			exit();
	    }
	    //
	    protected function _shortcode_atts($defaults=array(),$atts){
		    if(isset($atts['class']))
		      $atts['defined_class'] = $atts['class'];
		    return shortcode_atts ( $defaults, $atts );
	    }
	    public function njt_spiderlink_shortcode($atts, $content = null){
	    	extract ( $this->_shortcode_atts ( array (
		        'text' => 'View Now',
		        'url' => ''
		      ), $atts ) );
		      ob_start ();
		      $link = get_the_permalink((int)$url);
		  	  ?>
		  	  <style type="text/css">
		  	  	a.btn-viewnow{
		  	  		padding: 30px 0px;
		  	  		height: 76px;
				    margin-top: 45px;
				    padding-left: 24px;
				    background-color: #3b579d;
				    border-radius: 10px;
				    color: #ffffff;
				    cursor: pointer;
				    text-align: left;
		  	  	}
		  	  	a.btn-viewnow:hover{
		  	  		opacity: 0.8;
		  	  	}
		  	  	a.btn-viewnow .icon{
		  	  		display: inline-block;
				    vertical-align: middle;
				    width: 76px;
				    height: 76px;
				    line-height: 100px;
				    margin-left: 20px;
				    text-align: center;
				    background-color: #2f4b92;
				    border-radius: 0 10px 10px 0;
		  	  	}
		  	  	a.btn-viewnow span{
		  	  		display: inline-block;
				    vertical-align: middle;
				    min-width: 200px;
				    font-family: 'Montserrat',sans-serif;
				    font-size: 1.8em;
				    font-weight: bold;
				    line-height: 76px;
				    text-align: center;
		  	  	}
		  	  	i.fa.fa-facebook-square{
		  	  		font-size: 2.2em;
    				line-height: 76px;
		  	  	}
		  	  </style>
		  	  		<a class="btn-viewnow" href="<?php echo $link; ?>" title="<?php echo $text ?>"><span><?php echo $text; ?></span><div class="icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="42px" height="42px" viewBox="0 0 90 90" style="enable-background:new 0 0 90 90;" xml:space="preserve">
<g>
	<path id="Facebook__x28_alt_x29_" d="M90,15.001C90,7.119,82.884,0,75,0H15C7.116,0,0,7.119,0,15.001v59.998   C0,82.881,7.116,90,15.001,90H45V56H34V41h11v-5.844C45,25.077,52.568,16,61.875,16H74v15H61.875C60.548,31,59,32.611,59,35.024V41   h15v15H59v34h16c7.884,0,15-7.119,15-15.001V15.001z" fill="#FFFFFF"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
</div></a>
		  	  <?php
		      return ob_get_clean ();
	    }
	}
}
new NJT_APP_LIKE_COMMENT_ADMIN_SETTINGS();
