<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directlyhm;
if(!class_exists('NJT_SPIDERLINK_AJAX')){
	class NJT_SPIDERLINK_AJAX{
		public function __construct() {
			// ajax add
			add_action( 'wp_ajax_njt_like_comment_add_new_group_menu', array( $this, 'njt_like_comment_add_new_group_menu' ));
        	add_action( 'wp_ajax_nopriv_njt_like_comment_add_new_group_menu', array($this, 'njt_like_comment_add_new_group_menu') );
        	

        	add_action( 'wp_ajax_njt_like_comment_delete_design', array( $this, 'njt_like_comment_delete_design' ));
        	add_action( 'wp_ajax_nopriv_njt_like_comment_delete_design', array($this, 'njt_like_comment_delete_design') );
	        
		}
		// AJAX // ADD
		public function njt_like_comment_add_new_group_menu(){
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
						die("No result"); //url not correct format
					}
				}else{
					die("error1");
				}
				
			   	$post_group = new NJT_POST_TYPE_USER_SUB();
			  			
			  	$agrs = array(
							'id_group'=>$id,
				);

			  	if(!$post_group->CheckGroupExit($agrs)){
			  	
			  		$image=$fb_api->SpiderLink_Group_Icon_To_GroupID($id,$user_token);
			  			
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
			  			
			  		$icon = $image['icon'];
			  			echo '<tr><th scope="row" class="check-column"><input type="checkbox" name="facebookgroup[]" value="'.$User_post_id.'"></th><td class="id column-id has-row-actions column-primary" data-colname="ID">'.$id.'<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button></td><td class="picture_group column-picture_group" data-colname="Picture"><a href="'.$njt_fb_gr_group_url.'" target="_blank"><img src="'.$icon.'"></a></td><td class="group_name column-group_name" data-colname="Name"><a href="'.$group_url.'" target="_blank">'.$name.'</a></td><td class="day column-day" data-colname="Date">'.current_time('m/d/Y').'</td></tr>';
		   				die;
			            	//print_r($image['icon']);die;
			            ?>
  					<?php }else{echo "exits";die;?>
  						<?php }
  			
					}
			}
		
		
		public function njt_like_comment_delete_design(){
			global $wpdb;
			$table_design = $wpdb->prefix.'njt_like_comment_design';
			if(isset($_POST['id_design'])){
				$id_design = $_POST['id_design'];
				$delete=$wpdb->delete($table_design, array( 'id' => $id_design), array('%d') );
				die("success");
			}
		}
	}
}
new NJT_SPIDERLINK_AJAX();