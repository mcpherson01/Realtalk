<div class="wrap">
	<div class="icon32" id="icon-options-general">
		<br>
	</div>
	<h2><?php _e('Videos - Plugin settings', 'cbc_video');?></h2>
	<form method="post" action="<?php echo $form_action;?>">
		<div id="cbc_tabs">
			<?php wp_nonce_field('cbc-save-plugin-settings', 'cbc_wp_nonce');?>
			<ul class="cbc-tab-labels">
				<li><a href="#cbc-settings-post-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('Post options', 'cbc_video')?></a></li>
				<li><a href="#cbc-settings-content-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('Content options', 'cbc_video')?></a></li>
				<li><a href="#cbc-settings-image-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('Image options', 'cbc_video')?></a></li>
				<li><a href="#cbc-settings-import-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('Import options', 'cbc_video')?></a></li>
				<li><a href="#cbc-settings-embed-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('Embed options', 'cbc_video')?></a></li>
				<li><a href="#cbc-settings-auth-options"><i
						class="dashicons dashicons-arrow-right"></i> <?php _e('API & License', 'cbc_video')?></a></li>
			</ul>
			<!-- Tab post options -->
			<div id="cbc-settings-post-options">
				<table class="form-table">
					<tbody>
						<!-- Import type -->
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-admin-tools"></i> <?php _e('General settings', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="post_type_post"><?php _e('Import as regular post type (aka post)', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="post_type_post" value="1"
								id="post_type_post"
								<?php cbc_check( $options['post_type_post'] );?> /> <span
								class="description">
								<?php _e('Videos will be imported as <strong>regular posts</strong> instead of custom post type video. Posts having attached videos will display having the same player options as video post types.', 'cbc_video');?>
								</span></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="archives"><?php _e('Embed videos in archive pages', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="archives" value="1"
								id="archives" <?php cbc_check( $options['archives'] );?> /> <span
								class="description">
									<?php _e('When checked, videos will be visible on all pages displaying lists of video posts.', 'cbc_video');?>
								</span></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="use_microdata"><?php _e('Include microdata on video pages', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="use_microdata" value="1"
								id="use_microdata"
								<?php cbc_check( $options['use_microdata'] );?> /> <span
								class="description">
									<?php _e('When checked, all pages displaying videos will also include microdata for SEO purposes ( more on <a href="http://schema.org" target="_blank">http://schema.org</a> ).', 'cbc_video');?>
								</span></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="check_video_status"><?php _e('Check video statuses after import', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="check_video_status" value="1"
								id="check_video_status"
								<?php cbc_check( $options['check_video_status'] );?> /> <span
								class="description">
									<?php _e('When checked, will verify on YouTube every 24H if the video still exists or is embeddable and if not, it will automatically set the post status to pending. This action is triggered by your website visitors.', 'cbc_video');?>
								</span></td>
						</tr>

						<!-- Visibility -->
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-video-alt3"></i> <?php _e('Video post type options', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="public"><?php _e('Video post type is public', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="public" value="1" id="public"
								<?php cbc_check( $options['public'] );?> /> <span
								class="description">
								<?php if( !$options['public'] ):?>
									<span style="color: red;"><?php _e('Videos cannot be displayed in front-end. You can only incorporate them in playlists or display them in regular posts using shortcodes.', 'cbc_video');?></span>
								<?php else:?>
								<?php _e('Videos will display in front-end as post type video are and can also be incorporated in playlists or displayed in regular posts.', 'cbc_video');?>
								<?php endif;?>
								</span></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="homepage"><?php _e('Include videos post type on homepage', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="homepage" value="1"
								id="homepage" <?php cbc_check( $options['homepage'] );?> /> <span
								class="description">
									<?php _e('When checked, if your homepage displays a list of regular posts, videos will be included among them.', 'cbc_video');?>
								</span></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="main_rss"><?php _e('Include videos post type in main RSS feed', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="main_rss" value="1"
								id="main_rss" <?php cbc_check( $options['main_rss'] );?> /> <span
								class="description">
									<?php _e('When checked, custom post type will be included in your main RSS feed.', 'cbc_video');?>
								</span></td>
						</tr>


						<!-- Rewrite settings -->
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-admin-links"></i> <?php _e('Video post type rewrite (pretty links)', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="post_slug"><?php _e('Post slug', 'cbc_video')?>:</label></th>
							<td><input type="text" id="post_slug" name="post_slug"
								value="<?php echo $options['post_slug'];?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="taxonomy_slug"><?php _e('Taxonomy slug', 'cbc_video')?> :</label></th>
							<td><input type="text" id="taxonomy_slug" name="taxonomy_slug"
								value="<?php echo $options['taxonomy_slug'];?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="tag_taxonomy_slug"><?php _e('Tags slug', 'cbc_video')?> :</label></th>
							<td><input type="text" id="tag_taxonomy_slug"
								name="tag_taxonomy_slug"
								value="<?php echo $options['tag_taxonomy_slug'];?>" /></td>
						</tr>
					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>	
			</div>
			<!-- /Tab post options -->

			<!-- Tab content options -->
			<div id="cbc-settings-content-options">
				<table class="form-table">
					<tbody>
						<!-- Content settings -->
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-admin-post"></i> <?php _e('Post content settings', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="import_categories"><?php _e('Import categories', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="import_categories"
								name="import_categories"
								<?php cbc_check($options['import_categories']);?> /> <span
								class="description"><?php _e('Categories retrieved from YouTube will be automatically created and videos assigned to them accordingly.', 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="import_tags"><?php _e('Import tags', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="import_tags"
								name="import_tags" <?php cbc_check($options['import_tags']);?> />
								<span class="description"><?php _e('Tags retrieved from YouTube will be automatically created and videos assigned to them accordingly.', 'cbc_video');?></span><br />
								<span class="description"><strong><?php _e( 'Please note that only the tags of the videos that you own will be imported due to YouTube API limitation.', 'cbc_video' );?></strong></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="max_tags"><?php _e('Maximum number of tags', 'cbc_video')?>:</label></th>
							<td><input type="text"
								value="<?php echo esc_attr( $options['max_tags'] );?>"
								id="max_tags" name="max_tags" size="1" /> <span
								class="description"><?php _e('Maximum number of tags that will be imported.', 'cbc_video');?></span>
							</td>
						</tr>


						<tr valign="top">
							<th scope="row"><label for="import_date"><?php _e('Import date', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" name="import_date"
								id="import_date" <?php cbc_check($options['import_date']);?> />
								<span class="description"><?php _e("Imports will have YouTube's publishing date.", 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="import_title"><?php _e('Import titles', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="import_title"
								name="import_title" <?php cbc_check($options['import_title']);?> />
								<span class="description"><?php _e('Automatically import video titles from feeds as post title.', 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="import_description"><?php _e('Import descriptions as', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'content' => __( 'post content', 'cbc_video' ), 
												'excerpt' => __( 'post excerpt', 'cbc_video' ), 
												'content_excerpt' => __( 'post content and excerpt', 'cbc_video' ), 
												'none' => __( 'do not import', 'cbc_video' ) 
										), 
										'name' => 'import_description', 
										'selected' => $options[ 'import_description' ] 
								);
								cbc_select( $args );
								?>
								<p class="description"><?php _e('Import video description from feeds as post description, excerpt or none.', 'cbc_video')?></p>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="remove_after_text"><?php _e('Remove text from descriptions found after', 'cbc_video')?>:</label></th>
							<td><input type="text" name="remove_after_text"
								value="<?php echo $options['remove_after_text'];?>"
								id="remove_after_text" size="70" />
								<p class="description">
									<?php _e('If text above is found in description, all text following it (including the one entered above) will be removed from post content.', 'cbc_video');?><br />
									<?php _e('<strong>Please note</strong> that the plugin will search for the entire string entered here, not parts of it. An exact match must be found to perform the action.', 'cbc_video');?>
								</p></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="prevent_autoembed"><?php _e('Prevent auto embed on video content', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" name="prevent_autoembed"
								id="prevent_autoembed"
								<?php cbc_check($options['prevent_autoembed']);?> /> <span
								class="description">
									<?php _e('If content retrieved from YouTube has links to other videos, checking this option will prevent auto embedding of videos in your post content.', 'cbc_video');?>
								</span></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="make_clickable"><?php _e("Make URL's in video content clickable", 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" name="make_clickable"
								id="make_clickable"
								<?php cbc_check($options['make_clickable']);?> /> <span
								class="description">
									<?php _e("Automatically make all valid URL's from content retrieved from YouTube clickable.", 'cbc_video');?>
								</span></td>
						</tr>

					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>	
			</div>
			<!-- /Tab content options -->

			<!-- Tab image options -->
			<div id="cbc-settings-image-options">
				<table class="form-table">
					<tbody>
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-format-image"></i> <?php _e('Image settings', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="featured_image"><?php _e('Import images', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" name="featured_image"
								id="featured_image"
								<?php cbc_check($options['featured_image']);?> /> <span
								class="description"><?php _e("YouTube video thumbnail will be set as post featured image.", 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="image_on_demand"><?php _e('Import featured image on request', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" name="image_on_demand"
								id="image_on_demand"
								<?php cbc_check($options['image_on_demand']);?> /> <span
								class="description"><?php _e("YouTube video thumbnail will be imported only when featured images needs to be displayed (ie. a post created by the plugin is displayed).", 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="image_size"><?php _e('Image size', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'' => __( 'Choose', 'cbc_video' ), 
												'default' => __( 'Default (120x90 px)', 'cbc_video' ), 
												'medium' => __( 'Medium (320x180 px)', 'cbc_video' ), 
												'high' => __( 'High (480x360 px)', 'cbc_video' ), 
												'standard' => __( 'Standard (640x480 px)', 'cbc_video' ), 
												'maxres' => __( 'Maximum (1280x720 px)', 'cbc_video' ) 
										), 
										'name' => 'image_size', 
										'selected' => $options[ 'image_size' ] 
								);
								cbc_select( $args );
								?>	
								( <input type="checkbox" value="1" name="maxres" id="maxres"
								<?php cbc_check( $options['maxres'] );?> /> <label for="maxres"><?php _e('try to retrieve maximum resolution if available', 'cbc_video');?></label>
								)
							</td>
						</tr>

					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>
			</div>
			<!-- /Tab image options -->

			<!-- Tab import options -->
			<div id="cbc-settings-import-options">
				<table class="form-table">
					<tbody>
						<!-- Manual Import settings -->
						<tr>
							<th colspan="2"><h4>
									<i class="dashicons dashicons-download"></i> <?php _e('Bulk Import settings', 'cbc_video');?></h4></th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="import_status"><?php _e('Import status', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'publish' => __( 'Published', 'cbc_video' ), 
												'draft' => __( 'Draft', 'cbc_video' ), 
												'pending' => __( 'Pending', 'cbc_video' ) 
										), 
										'name' => 'import_status', 
										'selected' => $options[ 'import_status' ] 
								);
								cbc_select( $args );
								?>
								<p class="description"><?php _e('Imported videos will have this status.', 'cbc_video');?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="import_frequency"><?php _e('Automatic import', 'cbc_video')?>:</label></th>
							<td>
								<?php _e('Import ', 'cbc_video');?>
								<?php
								$args = array( 
										'options' => cbc_automatic_update_batches(), 
										'name' => 'import_quantity', 
										'selected' => $options[ 'import_quantity' ] 
								);
								cbc_select( $args );
								?>
								<?php _e('every', 'cbc_video');?>
								<?php
								$args = array( 
										'options' => cbc_automatic_update_timing(), 
										'name' => 'import_frequency', 
										'selected' => $options[ 'import_frequency' ] 
								);
								cbc_select( $args );
								?>
								<p class="description"><?php _e('How often should YouTube be queried for playlist updates.', 'cbc_video');?></p>
								<?php if( $options['page_load_autoimport'] ):?>
								<span class="description" style="color: red;">
									<?php _e( 'You chose to auto import videos by using the legacy page load trigger. We recommend that you set the number of videos to be imported at a maximum of 10 or 15 videos at a time.', 'cbc_video' );?>
								</span>
								<?php endif;?>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="cbc_conditional_import"><?php _e( 'Enable conditional automatic imports', 'cbc_video' );?>:</label>
							</th>
							<td><input type="checkbox" value="1" id="cbc_conditional_import"
								name="conditional_import"
								<?php checked( $options['conditional_import'] );?> /> <span
								class="description"><?php _e( 'When enabled, automatic imports will run only when a custom URL is opened on your website.', 'cbc_video' );?></span>
								<?php if( $options['conditional_import'] ) :?>
								<p>
									<?php printf( __( 'Important! Please make sure that you access URL %s by either setting a server cron job or using an alternative method that will generate a hit on this URL at least equal to automatic import setting from above.', 'cbc_video' ), '<code>' . cbc_autoimport_uri( false ) . '</code>' );?>
								</p>
								<?php endif;?>
								<?php if( empty( $options['autoimport_param'] ) ):?>
									<input type="hidden" name="autoimport_param"
								value="<?php echo wp_generate_password( 16, false );?>" /> 
								<?php else:?>
									<input type="hidden" name="autoimport_param"
								value="<?php echo $options['autoimport_param'];?>" />	
								<?php endif;?>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="page_load_autoimport"><?php _e('Legacy automatic import', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="page_load_autoimport"
								id="page_load_autoimport" value="1"
								<?php cbc_check( (bool)$options['page_load_autoimport'] )?> /> <span
								class="description"><?php _e( 'Trigger automatic video imports on page load (will increase page load time when doing automatic imports)', 'cbc_video' );?></span>
								<p>
									<?php _e( 'Starting with version 1.2, automatic imports are triggered by making a remote call to your website that triggers the imports. This decreases page loading time and improves the import process.', 'cbc_video' );?><br />
									<?php _e( 'Some systems may not allow this functionality. If you notice that your automatic import playlists aren\'t importing, enable this option.', 'cbc_video' );?>
								</p></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="unpublish_on_yt_error"><?php _e('Remove playlist from queue on YouTube error', 'cbc_video');?>:</label></th>
							<td><input type="checkbox" name="unpublish_on_yt_error"
								id="unpublish_on_yt_error" value="1"
								<?php cbc_check( (bool)$options['unpublish_on_yt_error'] );?> />
								<span class="description">
									<?php _e( 'When checked, if automatically imported playlist returns a YouTube error when queued, it will be unpublished.', 'cbc_video' );?>
								</span></td>
						</tr>

						<tr>
							<th scope="row"><label for="manual_import_per_page"><?php _e('Manual import results per page', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => cbc_automatic_update_batches(), 
										'name' => 'manual_import_per_page', 
										'selected' => $options[ 'manual_import_per_page' ] 
								);
								cbc_select( $args );
								?>
								<p class="description"><?php _e('How many results to display per page on manual import.', 'cbc_video');?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>
			</div>
			<!-- /Tab import options -->

			<!-- Tab embed options -->
			<div id="cbc-settings-embed-options">
				<table class="form-table">
					<tbody>
						<tr>
							<th colspan="2">
								<h4>
									<i class="dashicons dashicons-video-alt3"></i> <?php _e('Player settings', 'cbc_video');?></h4>
								<p class="description"><?php _e('General YouTube player settings. These settings will be applied to any new video by default and can be changed individually for every imported video.', 'cbc_video');?></p>
							</th>
						</tr>

						<tr>
							<th><label for="cbc_aspect_ratio"><?php _e('Player size', 'cbc_video');?>:</label></th>
							<td class="cbc-player-settings-options"><label
								for="cbc_aspect_ratio"><?php _e('Aspect ratio', 'cbc_video');?>:</label>
								<?php
								$args = array( 
										'options' => array( 
												'4x3' => '4x3', 
												'16x9' => '16x9' 
										), 
										'name' => 'aspect_ratio', 
										'id' => 'cbc_aspect_ratio', 
										'class' => 'cbc_aspect_ratio', 
										'selected' => $player_opt[ 'aspect_ratio' ] 
								);
								cbc_select( $args );
								?>
								<label for="cbc_width"><?php _e('Width', 'cbc_video');?>:</label>
								<input type="text" name="width" id="cbc_width" class="cbc_width"
								value="<?php echo $player_opt['width'];?>" size="2" />px
								| <?php _e('Height', 'cbc_video');?> : <span class="cbc_height"
								id="cbc_calc_height"><?php echo cbc_player_height( $player_opt['aspect_ratio'], $player_opt['width'] );?></span>px
							</td>
						</tr>

						<tr>
							<th><label for="cbc_video_position"><?php _e('Show video in custom post','cbc_video');?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'above-content' => __( 'Above post content', 'cbc_video' ), 
												'below-content' => __( 'Below post content', 'cbc_video' ) 
										), 
										'name' => 'video_position', 
										'id' => 'cbc_video_position', 
										'selected' => $player_opt[ 'video_position' ] 
								);
								cbc_select( $args );
								?>
							</td>
						</tr>

                        <tr>
                            <th><label for="cvwp-nocookie"><?php _e( 'No cookies video embed', 'cbc_video' );?>:</label></th>
                            <td>
                                <input type="checkbox" value="1" name="nocookie" id="cvwp-nocookie"<?php cbc_check( (bool) $player_opt['nocookie'] );?> />
                                <span class="description"><?php _e('embed video from cookieless domain', 'cbc_video');?></span>
                            </td>
                        </tr>

						<tr>
							<th><label for="cbc_volume"><?php _e('Volume', 'cbc_video');?></label>:</th>
							<td><input type="text" name="volume" id="cbc_volume"
								value="<?php echo $player_opt['volume'];?>" size="1"
								maxlength="3" /> <label for="cbc_volume"><span
									class="description">( <?php _e('number between 0 (mute) and 100 (max)', 'cbc_video');?> )</span></label>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="autoplay"><?php _e('Autoplay', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="autoplay"
								name="autoplay"
								<?php cbc_check( (bool )$player_opt['autoplay'] );?> /></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="cbc_controls"><?php _e('Show player controls', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="cbc_controls"
								class="cbc_controls" name="controls"
								<?php cbc_check( (bool)$player_opt['controls'] );?> /></td>
						</tr>

						<tr valign="top" class="controls_dependant"
							<?php cbc_hide((bool)$player_opt['controls']);?>>
							<th scope="row"><label for="fs"><?php _e('Allow fullscreen', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" name="fs" id="fs" value="1"
								<?php cbc_check( (bool)$player_opt['fs'] );?> /></td>
						</tr>

						<tr valign="top" class="controls_dependant"
							<?php cbc_hide((bool)$player_opt['controls']);?>>
							<th scope="row"><label for="autohide"><?php _e('Autohide controls', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'0' => __( 'Always show controls', 'cbc_video' ), 
												'1' => __( 'Hide controls on load and when playing', 'cbc_video' ), 
												'2' => __( 'Fade out progress bar when playing', 'cbc_video' ) 
										), 
										'name' => 'autohide', 
										'selected' => $player_opt[ 'autohide' ] 
								);
								cbc_select( $args );
								?>
							</td>
						</tr>

						<tr valign="top" class="controls_dependant"
							<?php cbc_hide((bool)$player_opt['controls']);?>>
							<th scope="row"><label for="theme"><?php _e('Player theme', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'dark' => __( 'Dark', 'cbc_video' ), 
												'light' => __( 'Light', 'cbc_video' ) 
										), 
										'name' => 'theme', 
										'selected' => $player_opt[ 'theme' ] 
								);
								cbc_select( $args );
								?>
							</td>
						</tr>

						<tr valign="top" class="controls_dependant"
							<?php cbc_hide((bool)$player_opt['controls']);?>>
							<th scope="row"><label for="color"><?php _e('Player color', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'red' => __( 'Red', 'cbc_video' ), 
												'white' => __( 'White', 'cbc_video' ) 
										), 
										'name' => 'color', 
										'selected' => $player_opt[ 'color' ] 
								);
								cbc_select( $args );
								?>
							</td>
						</tr>

						<tr valign="top" class="controls_dependant"
							<?php cbc_hide((bool)$player_opt['controls']);?>>
							<th scope="row"><label for="modestbranding"><?php _e('No YouTube logo on controls bar', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="modestbranding"
								name="modestbranding"
								<?php cbc_check( (bool)$player_opt['modestbranding'] );?> /> <span
								class="description"><?php _e('Setting the color parameter to white will cause this option to be ignored.', 'cbc_video');?></span>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="iv_load_policy"><?php _e('Annotations', 'cbc_video')?>:</label></th>
							<td>
								<?php
								$args = array( 
										'options' => array( 
												'1' => __( 'Show annotations by default', 'cbc_video' ), 
												'3' => __( 'Hide annotations', 'cbc_video' ) 
										), 
										'name' => 'iv_load_policy', 
										'selected' => $player_opt[ 'iv_load_policy' ] 
								);
								cbc_select( $args );
								?>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="rel"><?php _e('Show related videos', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="rel" name="rel"
								<?php cbc_check( (bool)$player_opt['rel'] );?> /> <label
								for="rel"><span class="description"><?php _e('when checked, after video ends player will display related videos', 'cbc_video');?></span></label>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="showinfo"><?php _e('Show video title by default', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="showinfo"
								name="showinfo"
								<?php cbc_check( (bool )$player_opt['showinfo']);?> /></td>
						</tr>

						<tr valign="top">
							<th scope="row"><label for="disablekb"><?php _e('Disable keyboard player controls', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="disablekb"
								name="disablekb"
								<?php cbc_check( (bool)$player_opt['disablekb'] );?> /> <span
								class="description"><?php _e('Works only when player has focus.', 'cbc_video');?></span>
								<p class="description"><?php _e('Controls:<br> - spacebar : play/pause,<br> - arrow left : jump back 10% in current video,<br> - arrow-right: jump ahead 10% in current video,<br> - arrow up - volume up,<br> - arrow down - volume down.', 'cbc_video');?></p>
							</td>
						</tr>
					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>
			</div>
			<!-- /Tab embed options -->

			<!-- Tab auth options -->
			<div id="cbc-settings-auth-options">
				<table class="form-table">
					<tbody>
						<tr>
							<th colspan="2">
								<h4>
									<i class="dashicons dashicons-admin-network"></i> <?php _e('YouTube API key', 'cbc_video');?></h4>
							</th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="youtube_api_key"><?php _e('Enter YouTube API server key', 'cbc_video')?>:</label></th>
							<td>
								<?php _e( 'This option will soon be deprecated in favor of OAuth. Please make sure you fill the OAuth credentials below.', 'cbc_video' );?><br />
								<a href="#" id="yt-server-key-deprecate"><?php _e( 'I understand, let me fill server key anyway', 'cbc_video' );?></a>
								<div class="hide-if-js" id="yt-server-key-deprecated">
								<?php
								/**
								 * Filter that allows hiding of server key field
								 * 
								 * @var boolean
								 */
								$show = apply_filters( 'cbc_show_server_key_form_field', true );
								if( $show ):
									?>
									<input type="text" name="youtube_api_key" id="youtube_api_key"
										value="<?php echo $youtube_api_key;?>" size="60" />
								
								<?php else: ?>
								<?php
									/**
									 * Filter that allows output of a message in case server key field is missing
									 * 
									 * @var string
									 */
									$message = apply_filters( 'cbc_hidden_server_key_field_message', '' );
									echo $message;
								endif;
								?>	
									<p class="description">
										<?php if( !cbc_get_yt_api_key('validity') ):?>
										<span style="color: red;"><?php _e('YouTube API key is invalid. All requests will stop unless a valid API key is provided. Please check the Google Console for the correct API key.', 'cbc_video');?></span><br />
										<?php endif;?>
										<?php _e('To get your YouTube API key, visit this address:', 'cbc_video');?> <a
											href="https://code.google.com/apis/console" target="_blank">https://code.google.com/apis/console</a>.<br />
										<?php _e('After signing in, visit <strong>Create a new project</strong> and enable <strong>YouTube Data API</strong>.', 'cbc_video');?><br />
										<?php _e('To get your API key, visit <strong>APIs & auth</strong> and under <strong>Public API access</strong> create a new <strong>Server Key</strong>.', 'cbc_video');?><br />
										<?php  printf( __('For more detailed informations please see <a href="%s" target="_blank">this tutorial</a>.', 'cbc_video') , 'https://wpythub.com/documentation/getting-started/set-youtube-server-key/' ); ?>
									</p>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="show_quota_estimates"><?php _e('Show YouTube API daily quota', 'cbc_video')?>:</label></th>
							<td><input type="checkbox" value="1" id="show_quota_estimates"
								name="show_quota_estimates"
								<?php cbc_check( $options['show_quota_estimates'] );?> /> <span
								class="description">
									<?php _e( 'When checked, will display estimates regarding your daily YouTube API available units.', 'cbc_video' );?>
								</span></td>
						</tr>

						<tr>
							<td colspan="2">
								<h4>
									<i class="dashicons dashicons-admin-network"></i> <?php _e('YouTube OAuth credentials', 'cbc_video');?></h4>
								<p class="description">
									<?php _e( 'By allowing the plugin to access your YouTube account, you will be able to quickly create automatic imports from your YouTube playlists and will also be able to import any public YouTube video.', 'cbc_videos' );?><br />
									<?php _e( 'After entering the OAuth credentials and granting access to your YouTube account, the server API key from the field above will not be used anymore and can be left empty.', 'cbc_video' );?><br />
									<?php _e( 'To get your OAuth credentials, please visit: ', 'cbc_video' );?> <a
										href="https://code.google.com/apis/console" target="_blank">https://code.google.com/apis/console</a>.
								</p>
								<p class="notice" style="padding: 1em 1em;">
									<?php _e( 'When creating OAuth credentials, make sure that under Authorized redirect URIs you enter: ' )?> <strong><?php echo cbc_get_oauth_redirect_uri();?></strong>
								</p>
							</td>
						</tr>
						<?php if( empty( $oauth_opt['client_id'] ) || empty( $oauth_opt['client_secret'] ) ):?>
						<tr valign="top">
							<th scope="row"><label for="oauth_client_id"><?php _e('Client ID', 'cbc_video')?>:</label></th>
							<td><input type="text" name="oauth_client_id"
								id="oauth_client_id"
								value="<?php echo $oauth_opt['client_id'];?>" size="60" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="oauth_client_secret"><?php _e('Client secret', 'cbc_video')?>:</label></th>
							<td><input type="text" name="oauth_client_secret"
								id="oauth_client_secret"
								value="<?php echo $oauth_opt['client_secret'];?>" size="60" />
								<p class="description">
								<a href="https://youtu.be/kn9aOAe6O3I?t=1m03s" target="_blank"><?php _e( 'See how to generate OAuth credentials and authorize the plugin to use YouTube API.', 'cbc_video' );?></a>
								</p>
							</td>
						</tr>
						<?php else: ?>
						<tr valign="top">
							<td colspan="2">
								<p class="description">
									<?php if( empty( $oauth_opt['token']['value'] ) ):?>
									<?php _e( 'In order to be able to use the plugin you must grant it access to your YouTube account by clicking the button below.', 'cbc_video' );?>
									<?php else :?>
									<?php _e( 'You have granted plugin access to your YouTube account. To remove access, please click the button below.', 'cbc_video' );?>
									<?php endif;?>
								</p>
								<p><?php cbc_show_oauth_link();?></p>
								<hr />
								<p class="description">									
									<?php _e( 'You have successfully entered your OAuth credentials. To enter new ones, please clear the current credentials.', 'cbc_video' );?>
								</p>
								<p><?php cbc_clear_oauth_credentials_link();?></p>
							</td>
						</tr>
						<?php endif;?>
						
						<tr>
							<th colspan="2">
								<h4>
									<i class="dashicons dashicons-businessman"></i> <?php _e('Purchase code', 'cbc_video');?></h4>
								<p class="description"><?php _e('Envato purchase code will enable automatic updates.', 'cbc_video');?></p>
							</th>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="envato_purchase_code"><?php _e('Enter purchase code', 'cbc_video')?>:</label></th>
							<td><input type="text" name="envato_purchase_code"
								id="envato_purchase_code" value="<?php echo $envato_licence;?>"
								size="60" />
								<p class="description">
									<?php _e('You can find your purchase code by accessing your Envato marketplace Downloads page <br />and clicking on Licence Certificate link that can be found under your plugin purchase.', 'cbc_video');?><br />
									<a
										href="<?php echo cbc_docs_link( 'getting-started/set-purchase-code' );?>"
										target="_blank"><?php _e( 'See a tutorial on how to fill your license key', 'cbc_video' );?></a>
								</p></td>
						</tr>
					</tbody>
				</table>
				<?php submit_button(__('Save settings', 'cbc_video'));?>
			</div>
			<!-- /Tab auth options -->
		</div>
		<!-- #cbc_tabs -->
	</form>
</div>