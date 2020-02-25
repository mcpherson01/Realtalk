<?php get_header();?>
<?php
	if (!session_id()) {
   		 session_start();
	}
?>
<?php
	global $post;
	
	if($post->post_status=="draft"){
		echo "<h2>".get_the_title($post->ID)."</h2>";
		echo "<p>".get_post_meta($post->ID,'njt_like_comment_message',true)."</p>";
		get_footer();
		die;
	}
	$_SESSION['post_id_campaign']=$post->ID;
	
	$api_fb = new NJT_APP_LIKE_COMMENT_API();
// Link Callback 
	$home=home_url();
	$page_process = get_page_by_title('process');
	$link_call=get_the_permalink($page_process->ID);
	$link_call=str_replace ("http://","https://", $link_call);
	

		if(isset($_GET['code'])){
			//$token = $api_fb->get_Token();
			$token = $api_fb->get_Token_check_error($link_call);
		
			$me = $api_fb->Me($token);
			$id = $me['id'];

		}else{
			
			// Count Click Link
			$key= 'njt_like_comment_link_'.$post->ID;
			$njt_metacheck = get_option($key);
			
			if($njt_metacheck){
			 	wp_redirect($api_fb->GetLinkLogin($link_call,array('email','public_profile')));
			 	 exit();
			}
		}
?>
<?php get_footer();?>