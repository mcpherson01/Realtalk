<?php error_reporting(0);?>
<?php get_header();?>
<?php
	if (!session_id()) {
   		 session_start();
	}
?>
<?php
	global $post;
	$post_id_campaign=(int)$_SESSION['post_id_campaign'];
	$custom_url_option = get_post_meta( $post_id_campaign, 'njt_like_comment_another_url_post_fb', true );

	$user_like=(get_post_meta( $post_id_campaign, 'njt_like_comment_userlike', true )=="on") ? 1 : 0;

	$user_comment=(get_post_meta( $post_id_campaign, 'njt_like_comment_usercomment', true )=="on") ? 1 : 0;
	
	$number_comment=get_post_meta( $post_id_campaign, 'njt_like_comment_number_comment', true );
	$link_url=get_post_meta( $post_id_campaign, 'njt_like_comment_secrect_url', true );
	$api_fb = new NJT_APP_LIKE_COMMENT_API();
// Link Callback 
	$home=home_url();
	$link_call=get_the_permalink($post->ID);
	if($custom_url_option=="") {
		$publish_to = get_post_meta( $post_id_campaign, 'njt_like_comment_publish_to', true );
		
		

		if($publish_to=="fanpage" || $publish_to==""){
			$id_post=get_post_meta( $post_id_campaign, 'njt_like_comment_post_fb_auto_page',true);
			$id_page_fanpage=get_post_meta( $post_id_campaign, 'njt_like_comment_page_manager', true );
		}else if($publish_to=="timeline"){
			$id_post=get_post_meta( $post_id_campaign, 'njt_like_comment_post_fb_auto_timeline',true);
		}else{
			// group
			$id_group=get_post_meta($post_id_campaign,'njt_like_comment_group_manager',true);

			
		}
		
		$check=1;
	}else{
		
		$url_input_post=get_post_meta( $post_id_campaign, 'njt_like_comment_input_url_post', true );
		
		//	var_dump($url_input_post);
		$publish_to=get_post_meta($post_id_campaign, 'njt_like_comment_publish_to',true);
		if($publish_to=="fanpage" || $publish_to==""){
			$check1=strstr($url_input_post,'/permalink.php');  // type permalink
			$check2=strstr($url_input_post,'/photos/');
			$check3=strstr($url_input_post,'/videos/');
			$check4=strstr($url_input_post,'/posts/');
			if($check1)
			{
				parse_str((parse_url($url_input_post, PHP_URL_QUERY)),$idpage_idpost);
				$id_post = $idpage_idpost['story_fbid'];
				$id_page = $idpage_idpost['id'];
				$id_post = $id_page."_".$id_post;
			}
			if($check2 || $check3)
			{
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(?:.+)(?:(?:\/)|(?:album_id\=))([0-9]+)\/?#', $url_input_post, $idpage_idpost);
				$id_post=$idpage_idpost[1];
			}
			if($check4)
			{
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(?:.+)(?:(?:\/)|(?:album_id\=))([0-9]+)\/?#', $url_input_post, $idpage_idpost);
				$id_post=$idpage_idpost[1];
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(.+)\/(posts)\/?#', $url_input_post, $idpage_idpost);
				$name=$idpage_idpost[1];
			}
        }else{
			$check1=strstr($url_input_post,'/permalink.php');  // type permalink
			if($check1)
			{
				parse_str((parse_url($url_input_post, PHP_URL_QUERY)),$idpage_idpost);
				$id_post = $idpage_idpost['story_fbid'];
				$id_page = $idpage_idpost['id'];
				$id_post = $id_page."_".$id_post;
			}
			$check2=strstr($url_input_post,'/photo.php?fbid=');
			if($check2){
				parse_str((parse_url($url_input_post, PHP_URL_QUERY)),$idpage_idpost);
				$id_post=$idpage_idpost['fbid'];
			}
			$check3=strstr($url_input_post,'/videos/');
			$check4=strstr($url_input_post,'/posts/');
			if($check3)
			{
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(?:.+)(?:(?:\/)|(?:album_id\=))([0-9]+)\/?#', $url_input_post, $idpage_idpost);
				$id_post=$idpage_idpost[1];
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(.+)\/(videos)\/?#', $url_input_post, $idpage_idpost);
				$name=$idpage_idpost[1];
			}
			if($check4)
			{
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(?:.+)(?:(?:\/)|(?:album_id\=))([0-9]+)\/?#', $url_input_post, $idpage_idpost);
				$id_post=$idpage_idpost[1];
				preg_match('#https?:\/\/(?:www\.)?(?:m\.)?facebook.com\/(.+)\/(posts)\/?#', $url_input_post, $idpage_idpost);
				$name=$idpage_idpost[1];
			}
		}

	}

	if(isset($_GET['code'])){
		//$token = $api_fb->get_Token();
		$token = $api_fb->get_Token_check_error($link_call);
		$me = $api_fb->Me($token);
		$id = $me['id'];
		$name = $me['name'];

		// get token site admin manager
		$token_admin =get_option('njt_token_full_permission');

		if($publish_to=="fanpage"){
			$id_page_fanpage=get_post_meta( $post_id_campaign, 'njt_like_comment_page_manager', true );

			$page_access_token=$api_fb->Get_Access_Token_Page($token_admin,$id_page_fanpage);
			
			$array_info=$api_fb->Get_UserLike_UserComment_Posts_Fanpage($page_access_token,$id_post);
			/*
			echo "<pre>";
			print_r($array_info);
			echo "</pre>";
			die;
			*/
		}else if($publish_to=="timeline"){

			$array_info=$api_fb->Get_UserLike_UserComment_Posts($token_admin,$id_post);
			/*
			echo "<pre>";
			print_r($array_info);
			echo "</pre>";
			die;
			*/
		}else{
			$token_full_permission = get_option('njt_token_full_permission');
			
			$list_post_id=$api_fb->Spider_GET_ALL_Group_Page_Post($id_group,$token_full_permission);
			
			$flash_check_post=0;
			
			foreach ($list_post_id->data as $key => $group) {
			    if(isset($group->message)){

			    	$check=strstr($group->message,get_post_meta($post_id_campaign,'njt_like_comment_hashcode',true));
				    if($check){

				      $flash_check_post=1;
				      $id_post=$group->id;
				      break;
				     }

			    } 
			     
			}
			
			// check if not post
			if($flash_check_post==0){  // No post found related to link (may not post, delete post)
				?>
				<img style="display: block;margin:auto" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/404.jpg'; ?>">
				<?php
				get_footer();
				die;
			}

			$array_info=$api_fb->Get_UserLike_UserComment_Posts_Group($token_full_permission,$id_post);


		}
		

		/*
			GET INFO USER ACCEPT APP
		*/
   			$post_nit = new NJT_POST_TYPE_USER_SUB();
   			$data = $api_fb->user_data($token);
   		//	$data = $api_fb->GET_INFO_USER_SUB_FULL_PER($token_admin,$id);

   			//code 
			if(isset($data['id'])){
				$agrs = array(
					'id'=>$data['id'],
					'email'=>$data['email'] 
				);
	   			if(!$post_nit->CheckUserExit($agrs)){
					$picture=$data['picture'];
			 		$picture = $picture['data'];
			 		$picture= $picture['url'];
			 		$arr = array(
	            				'mess' => $data['name'],
	           					'post_date' => current_time('Y-m-d H:i:s'),
	            				'post_type' => 'njt_user_subscriber',
	            				'post_status' => 'publish',
	            				'njt_fb_l_c_id_user'=>$data['id'],//$id,
								'njt_fb_l_c_gender_user'=>$data['gender'],
								'njt_fb_l_c_lang_user'=>$data['locale'],
								'njt_fb_l_c_picture_user'=>$picture,
								'njt_fb_l_c_email_user'=>$data['email'],
								'njt_fb_l_c_name_user'=>$data['name'],
								'njt_fb_l_c_first_name_user'=>$data['first_name'],
								'njt_fb_l_c_last_name_user'=>$data['last_name'],
								'njt_fb_l_c_token_user'=>$token,
	       			);
			 		$User_post_id=$post_nit->Insert($arr);
				}
			}
			// Count Click
		
			if(get_post_meta($post_id_campaign , 'list_user_campaign',true)){
				$string_list_user_campaign = get_post_meta($post_id_campaign , 'list_user_campaign',true);
				$array_list_user_campaign = explode(',',$string_list_user_campaign);
				if(!in_array($data['id'], $array_list_user_campaign)){
					array_push($array_list_user_campaign,$data['id']);
					$string_merge = implode(",",$array_list_user_campaign);
					update_post_meta($post_id_campaign , 'list_user_campaign',$string_merge);
					//update
					$click=(int)get_post_meta( $post_id_campaign, 'njt_like_comment_click',true);
					update_post_meta( $post_id_campaign , 'njt_like_comment_click', $click+1);
				}
			}else{
			  $array_list_user_campaign = array();
			  array_push($array_list_user_campaign,$data['id']);
			  $string_merge = implode(",",$array_list_user_campaign);
			  update_post_meta($post_id_campaign , 'list_user_campaign',$string_merge);
			  update_post_meta( $post_id_campaign , 'njt_like_comment_click', 1 );
			}
			
		/*
			GET INFO USER ACCEPT APP
		*/
			// id_page with /posts/
		if($publish_to=="fanpage" || $publish_to=="")
		{
			if(isset($check4) && $check4){
				$id_page_user=$api_fb->Get_ID_Page($token,$name);
				$id_post=$id_page_user.'_'.$id_post;
			}
		}
		else{
			if((isset($check3) && $check3) || (isset($check4) && $check4)){
				$id_page_user=$api_fb->Get_ID_Page($token,$name);
				$id_post=$id_page_user.'_'.$id_post;
			}
		}
		$flag_like=0;$flag_comment=0;$flag_comment_value=0;
		
		// Check User Like
		if($user_like==1){
			 
		        if(isset($array_info->reactions->data)){
				
					foreach ($array_info->reactions->data as $key => $value) {
							if(($value->id==$id || $value->name==$name) && $value->type == "LIKE"){
				                $flag_like=1;
				            }
					}
				}
		    
		}
		else{
		        $flag_like=1;
		}
		// Check User Comment
		if($user_comment==1){   
		  	
			if(isset($array_info->comments->data)){
				
					foreach ($array_info->comments->data as $key => $value) {
						if($value->from->id==$id || $value->from->name==$name){
			                        $flag_comment=1;

			                        if(isset($value->message) &&  strlen($value->message) >= (int)$number_comment){
			                            $flag_comment_value=1;
			                        }
			                }
					}
			}else{
					$flag_comment=0;
			}
		 	
		}else{
	      $flag_comment=1;$flag_comment_value=1;
		}
		 

		
	
		if($flag_like==1&&$flag_comment==1&&$flag_comment_value==1){
			
			if($link_url==""){ ?>
			            <script type="text/javascript">
			                 window.top.location.href ="<?php echo home_url(); ?>";
			           	</script> 
			<?php }else{?>
			            <script type="text/javascript">
			            	window.top.location.href ="<?php echo $link_url; ?>";
			            </script>              
			<?php }?>  


		<?php }else{ ?> 
			<?php 
		  		global $wpdb;
		  		$design_campaign = get_post_meta( $post_id_campaign, 'njt_design_campaign',true);
				$table_design = $wpdb->prefix.'njt_like_comment_design';
				if(empty($design_campaign)){
					$name="<p class='njt_like_comment_name'>Verify Your Access</p>";
					$img = NJT_APP_LIKE_COMMENT_URL.'assets/images/like.png';
					$please="<p>Please make sure you clicked LIKE and COMMENTED on [this Facebook post].</p>";
					$like="<p>Like post</p>";
					$comment="<p>Leave a comment (minimum [d] characters)</p>";
					$done="<p>I'm done!</p>";
				}else{
					$design=$wpdb->get_row( "SELECT * FROM $table_design WHERE id = $design_campaign" );
					$name = $design->name;
					if($design->img==""){
						$img = NJT_APP_LIKE_COMMENT_URL.'assets/images/like.png';
					}else{
						$img = $design->img;
					}
					$please=$design->please;
					$like=$design->like;
					$comment=$design->comment;
					$done=$design->done;
				}
				
		 	?>
		 	<!-- Show Alert -->
			<div id="njt-like-comment-container" style="margin-bottom: 50px;margin-top: 25px">
			<div id="" class="njt-like-comment-app-name njt_like_comment_editor_name" data-placeholder="Type some text">
				<?php echo $name; ?>
			</div>
			<div style="padding: 20px 0px" class="njt-like-comment-app-img njt_like_comment_editor_img" id="">
			
				<img style="display: block;margin: auto;width: 150px;height: 150px;padding: 0;" src="<?php echo $img; ?>">
			</div>
			<div class="njt_like_comment_editor_1">
				<div id="njt_like_comment_editor_1" class="editable-1 njt_like_comment_editor_please" data-placeholder="Type some text">
					<?php
					   $replace ="<a target='_blank' href='https://www.facebook.com/".$id_post."'>";
					   $njt_please=str_replace("[",$replace,$please);
					   echo str_replace("]","</a>",$njt_please);
					?>
				</div>
			</div>
		<?php if($user_like==1){ ?>
			<?php if($flag_like==1) 
			 			$images_check=NJT_APP_LIKE_COMMENT_URL.'assets/images/'."checked.svg";
			 	   else
			 	   		$images_check=NJT_APP_LIKE_COMMENT_URL.'assets/images/'."check_none.svg";
			 ?>
			<div class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo $images_check; ?>">
				<div style="margin-left: 25px;overflow: auto;<?php if($flag_like==1) echo 'color:#00a651'; else  echo 'color:#d50000';?>" id="njt_like_comment_editor_2" class="njt_like_comment_editor_like" data-placeholder="Type some text">
					<?php echo $like; ?>
				</div>
			</div>
		<?php } ?>
		<?php if($user_comment==1){ ?>
			 <?php if($flag_comment==1) 
			 			$images_check=NJT_APP_LIKE_COMMENT_URL.'assets/images/'."checked.svg";
			 	   else
			 	   		$images_check=NJT_APP_LIKE_COMMENT_URL.'assets/images/'."check_none.svg";
			 ?>
			<div style="padding-top: 15px;" class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo $images_check; ?>">
				<div style="margin-left: 25px;overflow: auto;<?php if($flag_comment==1) echo 'color:#00a651'; else  echo 'color:#d50000';?>" id="njt_like_comment_editor_2" class="njt_like_comment_editor_comment" data-placeholder="Type some text">
					<span <?php if($flag_comment_value!=1) echo "style='color:#d50000;'"; ?>><?php echo str_replace("[d]",$number_comment,$comment);?></span>
				</div>
			</div>
		<?php } ?>	
			<div class="njt_like_comment_editor_4">
				<div style="height: 77px;width: 100%;" id="njt_like_comment_editor_4" class="njt-action-button-shadow-animate-green">
				   <a href="<?php echo $link_call; ?>">
					<div id="" class="njt_like_comment_editor_done" data-placeholder="Type some text">
						<?php echo $done; ?>
					</div>
				   </a>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
			<!-- Show Alert  --><?php
		
		} 

		}else{
		/*	
			// Count Click Link
			if(get_post_meta( $post_id_campaign, 'njt_like_comment_click',true)){
				$click=(int)get_post_meta( $post_id_campaign, 'njt_like_comment_click',true);
				update_post_meta( $post_id_campaign , 'njt_like_comment_click', $click+1);
			}
			else
			{
				update_post_meta( $post_id_campaign , 'njt_like_comment_click', 1 );
			}
			// Count Click Link
		*/
			$key= 'njt_like_comment_link_'.$post_id_campaign;
			$njt_metacheck = get_option($key);
			
			if($njt_metacheck){
			 	wp_redirect($api_fb->GetLinkLogin($link_call,array('email','public_profile')));
			 	 exit();
			 }
		}
?>
<?php get_footer();?>