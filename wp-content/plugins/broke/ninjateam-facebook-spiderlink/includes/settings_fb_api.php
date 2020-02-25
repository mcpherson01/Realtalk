<?php
global $wpdb;
$type = isset($_GET['type']) ? $_GET['type']:'';
	if ($type!=''){
		$link_call_back=add_query_arg(array('page'=>'njt-fb-api-settings','type'=>$type),admin_url('admin.php'));
	}
	else{
		$link_call_back=add_query_arg(array('page'=>'njt-fb-api-settings'),admin_url('admin.php'));
}
if(get_option('njt_app_like_comment_app_id') && get_option('njt_app_like_comment_app_id')!="" && get_option('njt_app_like_comment_app_id_serect') && get_option('njt_app_like_comment_app_id_serect')!=""){
	
	$fb_api = new NJT_APP_LIKE_COMMENT_API();
	//$link_login= $fb_api->GetLinkLogin($link_call_back,array('manage_pages','email','publish_actions','publish_pages','public_profile','user_posts','user_managed_groups'));
	$link_login= $fb_api->GetLinkLogin($link_call_back,array('email','public_profile'));
	if(isset($_GET['code'])){
		$token = $fb_api->get_Token($link_call_back);
		$user_token= $fb_api->extoken($token);
		update_option('njt_app_fb_like_comment_user',$user_token);
		wp_redirect($link_call_back);
		exit();
	}
	$user_token=get_option('njt_app_fb_like_comment_user');
	$check=$fb_api->check_token_live($user_token);
	//

}
?>	
<h2 class="nav-tab-wrapper">
	<a href="?page=njt-fb-api-settings" class="nav-tab <?php if(!isset($_GET['type'])) echo 'nav-tab-active'; ?>">General Options</a>
	<?php if(isset($check) && $check==1){ ?>
	<!--<a href="?page=njt-fb-api-settings&type=njt_design" class="nav-tab <?php if(isset($_GET['type']) && $_GET['type']=='njt_design') echo 'nav-tab-active'; ?>">Design</a>-->
	<a href="?page=njt-fb-api-settings&type=njt_mailchimp" class="nav-tab <?php if(isset($_GET['type']) && $_GET['type']=='njt_mailchimp') echo 'nav-tab-active'; ?>">MailChimp Settings</a>
	<?php } ?>
</h2>
<?php if(!isset($_GET['type'])) : ?>
	<?php if( isset($_GET['settings-updated']) ): ?>
<div style="margin-left: 0px;margin-top: 15px;" class="notice notice-success is-dismissible mst-popup-notifi-save-changed">
<p><?php _e('Save changed!',NJT_APP_LIKE_COMMENT) ?></p>
</div>
<?php endif;?>
	<form action="options.php" method="post">
		<?php settings_fields('njt_app_like_comment');
		$app_id=get_option('njt_app_like_comment_app_id');
		$app_serect=get_option('njt_app_like_comment_app_id_serect');
		$token_full=get_option('njt_token_full_permission');
		$custom_slug=get_option('njt_app_like_comment_app_custom_slug');
		$app_is_cache=get_option('njt_app_like_comment_app_is_cache');
		$api_key=get_option('njt_spiderlink_mail_chimp_api_key');
		$lists_active=get_option('njt_spiderlink_mail_chimp_api_active');
		global $wp_rewrite;
        $wp_rewrite->flush_rules(false);
		?>
		<input type="hidden" name="njt_spiderlink_mail_chimp_api_key" value="<?php echo $api_key; ?>">
		<input type="hidden" name="njt_spiderlink_mail_chimp_api_active" value="<?php echo $lists_active; ?>">
		<table class="form-table">
			<tbody>
				<tr class="">
					<th scope="row">
						<label for="">App ID</label>
					</th>
					<td>
						<input type="text" class="regular-text" id="njt_app_like_comment_app_id" name="njt_app_like_comment_app_id" value="<?php echo empty($app_id) ? '' : $app_id; ?>"><p class="description">App ID and App Secret at <a href="https://developers.facebook.com" class="new-window" target="_blank">Facebook Developers</a> are needed for using the Facebook APIs. <a href="https://ninjateam.org/how-to-setup-facebook-secret-spiderlink-wordpress-plugin/" class="new-window" target="_blank">View tutorial</a></p>
					</td>
				</tr>
				<tr class="">
					<th scope="row">
						<label for="">App Secret</label>
					</th>
					<td>
						<input type="text" class="regular-text" id="njt_app_like_comment_app_id_serect" name="njt_app_like_comment_app_id_serect" value="<?php echo empty($app_serect) ? '' : $app_serect; ?>">
					</td>
				</tr>

				<tr class="">
					<th scope="row">
						<label for="">Valid OAuth redirected URls:</label>
					</th>
					<td>
						<input style="width: 80%;border:none;box-shadow:none" type="text" readonly="readonly" class="njt_abd_webhooks" onclick="select();" value="<?php echo str_replace ("http://","https://",$link_call_back);?>">
						<?php
							$new_page_title_process = 'process';
							$new_page_content_process = '';
							$page_check_process = get_page_by_title($new_page_title_process);


						?>
						<input style="width: 80%;border:none;box-shadow:none" type="text" readonly="readonly" class="njt_abd_webhooks" onclick="select();" value="<?php echo str_replace ("http://","https://", get_the_permalink($page_check_process->ID));?>">
						<p class="description">Copy these links into Valid OAuth redirected URls field in your Facebook Developer App.</p>
					</td>
				</tr>

				<tr class="">
					<th scope="row">
						<label for="">Access Token</label>
					</th>
					<td>
						<input type="text" class="regular-text" id="njt_token_full_permission" name="njt_token_full_permission" value="<?php echo empty($token_full) ? '' : $token_full; ?>">
						<p class="description">Enter your Facebook access token <a href="http://ninjateam.org/how-to-get-access-token-for-facebook-spiderlink-make-your-facebook-post-go-viral/" target="_blank">How to get access token?</a></p>
					</td>
				</tr>

				<tr class="">
					<th scope="row">
						<label for="">Custom slug</label>
					</th>
					<td>
						<input type="text" class="regular-text" id="njt_app_like_comment_app_custom_slug" name="njt_app_like_comment_app_custom_slug" value="<?php echo empty($custom_slug) ? 'secret-link' : $custom_slug; ?>">
						<p class="description">Custom structure for your Spider link. Example: yoursite.com/Your-Slug/your-link</p>
					</td>
				</tr>
				<tr class="">
					<th scope="row">
						<label for="">Kill the cache?</label>
					</th>
					<td>
						<label class="njt-switch-button">
							<!-- checked=""-->
							<input <?php if($app_is_cache=="on") echo "checked='checked'"; ?>  name="njt_app_like_comment_app_is_cache" class="njt-switch-button-input njt_app_like_comment_app_is_cache" type="checkbox" />
							<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
							<span class="njt-switch-button-handle"></span> 
						</label>
						<p class="description">Turn on if your site have cache or your secret link is not redirected</p>
					</td>
				</tr>
				<tr class="">
					<?php 
					if(isset($check) && $check==0) :
						?>
					<th scope="row">
						<label for="">Connect to Facebook</label>
					</th>
					<td>
						<a class="button button-primary" href="<?php echo $link_login; ?>">Connect to Facebook</a>
					</td>
				<?php elseif(isset($check) && $check==1): ?>
					<th scope="row">
						<label for="">Connect to Facebook</label>
					</th>
					<td>
						<p class="description"></p>
						<p>Successful connection to <strong><?php echo $fb_api->Me($user_token)['name']; ?></strong>. <a href="<?php echo $link_login;?>" id="njt-reconnet">Reconnect</a>
						</p>
						<p></p>
					</td>
				<?php endif; ?>
			</tr>
		</tbody>
	</table>
	<?php submit_button(); ?>
</form>
<?php elseif($_GET['type']=="njt_design"): ?>
<?php
$table_design = $wpdb->prefix.'njt_like_comment_design';
$design=$wpdb->get_row( "SELECT * FROM $table_design WHERE id = 1" );
?>
	<div style="margin: 20px 0px;" class="msg"></div>
	<form style="margin-top: 50px;" id="njt_form_settings_app_like_comment">
		<div id="njt-like-comment-container">
			<div id="" class="editable njt-like-comment-app-name njt_like_comment_editor_name" data-placeholder="Type some text">
				<p class="njt_like_comment_name"><?php echo $design->name;?></p>
			</div>
			<?php if($design->img=="") $design->img=NJT_APP_LIKE_COMMENT_URL.'assets/images/like.png'; ?>
			<input type="hidden" id="njt_like_comment_image_icon_url" value="<?php echo $design->img; ?>">
			<div class="editable-0 njt-like-comment-app-img njt_like_comment_editor_img" id="">
				<div style="margin-top: 35px;height: 170px;" class="njt_like_comment_image_container_icon">
				<a <?php if($design->img) echo "style='display:none;'"; ?> href="#" id="njt-l-c-insert-img" class="button">Select Image</a>
					<img style="width: 150px;height: 150px;" id="njt_like_comment_icon_src"  src="<?php echo $design->img; ?>">
					<p <?php if($design->img=="") echo "style='display:none;'"; ?> id="njt-l-c-delete-img">Remove</p>
				</div>
			</div>
			<div class="njt_like_comment_editor_1">
				<div id="njt_like_comment_editor_1" class="editable-1 njt_like_comment_editor_please" data-placeholder="Type some text">
					<?php echo $design->please;?>
				</div>
			</div>
			<div class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/check_none.svg'; ?>">
				<div style="margin-left: 25px;overflow: auto;" id="njt_like_comment_editor_2" class="editable-2 njt_like_comment_editor_like" data-placeholder="Type some text">
					<?php echo $design->like;?>
				</div>
			</div>
			<div style="padding-top: 15px;" class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/check_none.svg'; ?>">
				<div style="margin-left: 25px;overflow: auto;" id="njt_like_comment_editor_2" class="editable-3 njt_like_comment_editor_comment" data-placeholder="Type some text">
					<?php echo $design->comment;?>
				</div>
			</div>
			<div class="njt_like_comment_editor_4">
				<div id="njt_like_comment_editor_4" class="njt-action-button-shadow-animate-green">
					<div id="" class="editable-4 njt_like_comment_editor_done" data-placeholder="Type some text">
						<?php echo $design->done;?>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div style="margin-top: 50px;"></div>
	<div id="njt-like-comment-container-note">
		<p>
			<b>Tags:</b> - Use <strong>[Your Text]</strong> to display the Facebook post URL, example [This Facebook Post]<br/>
			<p style="margin-left: 35px;"> - Use <strong>[d]</strong> to display the minimum characters required</p>
		</p>
		<div style="margin-top: 50px;">
		<a href="javascript:void(0)" class="button button-primary njt_submit_form_settings"> Save Changes</a>
		</div>
	</div>
<?php elseif($_GET['type']=="njt_mailchimp"): ?>
	<?php if( isset($_GET['settings-updated']) ): ?>
<div style="margin-left: 0px;margin-top: 15px;" class="notice notice-success is-dismissible mst-popup-notifi-save-changed">
<p><?php _e('Save changed!',NJT_APP_LIKE_COMMENT) ?></p>
</div>
<?php endif;?>
	<form action="options.php" method="post">
	<?php settings_fields('njt_app_like_comment');
		$app_id=get_option('njt_app_like_comment_app_id');
		$app_serect=get_option('njt_app_like_comment_app_id_serect');
		$custom_slug=get_option('njt_app_like_comment_app_custom_slug');
		$app_is_cache=get_option('njt_app_like_comment_app_is_cache');
		$api_key=get_option('njt_spiderlink_mail_chimp_api_key');
		$lists_active=get_option('njt_spiderlink_mail_chimp_api_active');
		global $wp_rewrite;
        $wp_rewrite->flush_rules(false);
	?>	
		<input type="hidden" name="njt_app_like_comment_app_id" value="<?php echo $app_id; ?>">
		<input type="hidden" name="njt_app_like_comment_app_id_serect" value="<?php echo $app_serect; ?>">
		<input type="hidden" name="njt_app_like_comment_app_custom_slug" value="<?php echo $custom_slug; ?>">
		<input type="hidden" name="njt_app_like_comment_app_is_cache" value="<?php echo $app_is_cache; ?>">
		<table class="form-table">
			<tbody>
				<?php
						$connected = get_option('njt_spiderlink_mail_chimp_api_key');
						if(!empty($connected)){
								
								try{
									$api = new NJT_SPIDERLINK_API_MAIL_CHIMP(get_option('njt_spiderlink_mail_chimp_api_key'));
									
									$connected = $api->is_connected();
									
								}catch( NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING $e){
									
									$connected = false;

								}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX $e ){
									
									$connected = false;
								}


							}
				?>
				<tr class="">
					<th scope="row">
						<label for="">Connected</label>
					</th>
					<td>
						<?php if( $connected ) { ?>
						<span style="background: green; padding: 4px;color: #fff; float: left;" class="status positive">CONNECTED</span>
						<?php }else{?>
						<span style="background: red; padding: 4px;color: #fff; float: left;" class="status positive">NOT CONNECTED</span>
						<?php }?>
					</td>
				</tr>
				<tr class="">
					<th scope="row">
						<label for="">API KEY</label>
					</th>
					<td>
						<input type="text" class="regular-text" id="" name="njt_spiderlink_mail_chimp_api_key" value="<?php echo !empty($api_key) ? $api_key : ''; ?>">
						<p class="description">The API key for connecting with your MailChimp account. <a href="https://admin.mailchimp.com/account/api" class="new-window" target="_blank">Get your API key here.</a></p>
					</td>
				</tr>
			<?php 
			if($connected){
				$api = new NJT_SPIDERLINK_API_MAIL_CHIMP(get_option('njt_spiderlink_mail_chimp_api_key'));
				try{
					$list = $api->lists_cache(true);
				}catch( NjJ_SPIDERLINK_MAIL_CHIMP_EX_CONNECTING $e){
					
					///$connected = false;

				}catch(NjJ_SPIDERLINK_MAIL_CHIMP_EX $e ){
					
					//$connected = false;
				}
			?>
				<tr class="">
					<th scope="row">
						<label for="">Your MailChimp Account</label>
					</th>
					<td>
						<div class="njt-mail-chimp-account">
							<span class="njt-spiderlink-mailchimp-renew-result"></span>
							<a href="javascript:void(0)" id="njt-spiderlink_renew_mail_chimp" class="button njt-spiderlink_renew_mail_chimp"><?php _e('Renew MailChimp lists',NJT_APP_LIKE_COMMENT)  ?> </a>

								<?php 
									if(isset($list)){

								?>
								<?php 
								$lists_active =get_option('njt_spiderlink_mail_chimp_api_active' );

								?>
								<ul>
										<?php 

										if(is_array($list)){
											foreach ($list as $key => $value) {

												?>
													<li>
														<input <?php echo is_array($lists_active)&&in_array($value->id, $lists_active)?'checked="checked"':'' ?> id="njt_spiderlink_mailchimp_lists" type="checkbox" name="njt_spiderlink_mail_chimp_api_active[]" value="<?php echo $value->id; ?>">
														<span><?php echo $value->name ?></span>
													</li>
												<?php

											}

										}

										?>
									</ul>

								<?php } ?>

						</div>	
					</td>
				</tr>
			<?php } ?>
				
				<tr>
					<th></th>
					<td>
						<?php
						$lists_active =get_option('njt_spiderlink_mail_chimp_api_active',true );

							if($connected==true&&!empty($lists_active)){


								?>
								<div>
								<span style="margin-bottom: 5px; display: block; color: green" class="njt-spiderlink-mail-chimp-sync-result"></span>
								</div>
								
								<div style="float: left;margin-right: 10px;padding: 0;padding-top: 0;margin: 0;margin-right: 10px;margin-top: 10px;"  class="submit" >
									<a style=" display: block;float: left;" href="javascript:void(0)" title="<?php  echo __('Syc Now',NJT_APP_LIKE_COMMENT)?>" class="button njt-spiderlink-mailchimp-sync-now">
										<?php echo __('Sync Now', NJT_APP_LIKE_COMMENT); ?>
                						<!-- <p style="margin-top: 0;padding: 2px 10px 1px;" class=""></p> -->
                						<p class="njt-spiderlink-loading"></p>
            						</a>
            					</div>
								<?php
							}?>
							<?php submit_button(); ?>
					</td>
				</tr>
			</tbody>
		</table>
		
	</form>
<?php endif;?>
