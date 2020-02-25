<div class="wrap">
	<div class="icon32 icon32-posts-video" id="icon-edit">
		<br>
	</div>
	<h2>
		<?php if( 'edit' == $_GET['action'] ):?>
			<?php printf( __( 'Edit playlist <em>%s</em>', 'cbc_video' ), $this->feed_obj->get('title') ); ?>
			<?php printf( '<a href="%1$s" title="%2$s" class="add-new-h2">%2$s</a>', menu_page_url('cbc_auto_import', false) . '&action=add_new', __( 'Add new', 'cbc_video' ) ); ?>
		<?php else:?>
			<?php _e('Add new playlist', 'cbc_video');?>
		<?php endif;?>
		<a class="add-new-h2" href="<?php menu_page_url('cbc_auto_import');?>"><?php _e('Cancel', 'cbc_video');?></a>
	</h2>

	<form method="post"
		action="<?php echo menu_page_url( 'cbc_auto_import', false ) . '&action=' . ( 'edit' == $_GET['action'] ? 'edit&id=' . $_GET['id'] : 'add_new' ) ;?>">
		<?php if( $this->has_error() ):?>
		<div id="message" class="error">
			<p><?php echo $this->has_error(); ?></p>
		</div>
		<?php endif;?>
		<?php wp_nonce_field('cbc-save-playlist', 'cbc_wp_nonce');?>
		
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="post_title">*<?php _e('Playlist name', 'cbc_video');?>:</label></th>
					<td><input type="text" name="cbc_feed[title]" id="post_title"
						value="<?php echo esc_attr( $this->feed_obj->get('title') );?>" />
						<span class="description"><?php _e('A name for your internal reference.', 'cbc_video');?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="playlist_type">*<?php _e('Feed type', 'cbc_video')?>:</label></th>
					<td>
						<?php
						$args = array( 
								'options' => array( 
										'user' => __( 'User playlist', 'cbc_video' ), 
										'channel' => __( 'YouTube channel', 'cbc_video' ), 
										'playlist' => __( 'YouTube playlist', 'cbc_video' ) 
								), 
								'name' => 'cbc_feed[type]', 
								'id' => 'playlist_type', 
								'selected' => $this->feed_obj->get( 'type' ) 
						);
						cbc_select( $args );
						?>
						<span class="description"><?php _e('Choose the kind of playlist you want to import.', 'cbc_video');?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="playlist_id">*<?php _e('Playlist ID', 'cbc_video');?>:</label></th>
					<td><input type="text" name="cbc_feed[id]" id="playlist_id"
						value="<?php echo $this->feed_obj->get('id') ;?>" /> <a href="#"
						id="cbc_verify_playlist" class="button"><?php _e('Check playlist', 'cbc_video');?></a>
						<div id="cbc_check_playlist" class="description"><?php _e('Enter playlist ID or user ID according to Feed Type selection.', 'cbc_video');?></div>

					</td>
				</tr>
				
			<?php
			// users dropdown
			$users = wp_dropdown_users( array( 
					'show_option_all' => __( 'Current user', 'cbc_video' ), 
					'echo' => false, 
					'name' => 'cbc_feed[import_user]', 
					'id' => 'cbc_video_user', 
					'hide_if_only_one_author' => true, 
					'selected' => $this->feed_obj->get( 'import_user' ) 
			) );
			if( $users ):
				?>
				<tr valign="top">
					<th scope="row"><label for="cbc_video_user"><?php _e('Import as user', 'cbc_video');?>:</label></th>
					<td>
						<?php echo $users;?>
						<span class="description"><?php _e('Video posts will be created as written by the selected user.', 'cbc_video');?></span>
					</td>
				</tr>
			<?php endif;// end users dropdown?>
				
				<?php
				$hidden = $this->feed_obj->get( 'type' ) == 'user' || $this->feed_obj->get( 'type' ) == 'channel';
				?>
				<tr valign="top" id="publish-date-filter"
					<?php cbc_hide( $hidden, false );?>>
					<th scope="row"><label for="start_date"><?php _e('Import if published after', 'cbc_video');?>:</label></th>
					<td><input type="text" id="start_date" name="cbc_feed[start_date]"
						value="<?php echo $this->feed_obj->get('start_date');?>" /> <script>
						jQuery(document).ready(function() {
						    jQuery('#start_date').datepicker({
						        dateFormat : 'M d yy'
						    });
						});
						</script> <span class="description"><?php _e('If a date is specified, only videos published after this date will be imported.', 'cbc_video');?></span>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><label for="playlist_live"><?php _e('Add to import queue?', 'cbc_video');?></label></th>
					<td><input type="checkbox" name="cbc_feed[playlist_live]"
						id="playlist_live" value="1"
						<?php cbc_check( ( $this->feed_obj->get('status') == 'publish' ) );?> />
						<span class="description"><?php _e('If checked, playlist will be added to importing queue and will import when its turn comes.', 'cbc_video');?></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="playlist_repeat"><?php _e('Repeat import in queue', 'cbc_video');?>:</label></th>
					<td>
						<select name="cbc_feed[repeat]">
							<?php 
								for( $i=1; $i<=5; $i++ ):
							?>
							<option value="<?php echo $i;?>"<?php if( $i == $this->feed_obj->get('repeat') ):?> selected="selected"<?php endif;?>><?php printf( _n( '%s time', '%s times', $i, 'cbc_video' ), number_format_i18n( $i ) );?></option>
							<?php endfor;?>
						</select>
						<span class="description"><?php _e('Number of times that this automatic import will run before importing the next automatic import in queue.', 'cbc_video');?></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="no_reiterate"><?php _e('When finished, import only new videos', 'cbc_video');?> :</label></th>
					<td><input type="checkbox" name="cbc_feed[no_reiterate]"
						id="no_reiterate" value="1"
						<?php cbc_check( $this->feed_obj->get('no_reiterate') );?> /> <span
						class="description"><?php _e("After finishing to import all videos in playlist the plugin will check only for new videos.", 'cbc_video');?></span>
						<?php
						$hide = ! ( 'playlist' == $this->feed_obj->get( 'type' ) && $this->feed_obj->get( 'no_reiterate' ) );
						?>
						<div id="playlist-alert" class="warning"
							<?php cbc_hide( $hide, true );?>>
							<?php _e( 'Please make sure that the playlist is ordered on YouTube by <strong>Date added(newest - oldest)</strong>', 'cbc_video' );?><br />
							<?php _e( "If you're not sure how the playlist is ordered you should uncheck the option to import new videos after playlist finished importing.", 'cbc_video' );?>
						</div></td>
				</tr>
				
				<?php
				$obj = cbc_get_class_instance();
				$args = array( 
						'show_count' => 1, 
						'hide_empty' => 0, 
						'taxonomy' => $obj->get_post_tax(), 
						'name' => 'cbc_feed[native_tax]', 
						'id' => 'native_tax', 
						'selected' => $this->feed_obj->get( 'native_tax' ), 
						'hide_if_empty' => true, 
						'echo' => false 
				);
				$plugin_options = cbc_get_settings();
				if( isset( $plugin_options ) && $plugin_options[ 'import_categories' ] ){
					$args[ 'show_option_all' ] = __( 'Create categories from YouTube', 'cbc_video' );
				}else{
					$args[ 'show_option_all' ] = __( 'Select category (optional)', 'cbc_video' );
				}
				
				// if set to import as regular post, change taxonomy to category
				if( isset( $plugin_options[ 'post_type_post' ] ) && $plugin_options[ 'post_type_post' ] ){
					$args[ 'taxonomy' ] = 'category';
				}
				
				$plugin_categories = wp_dropdown_categories( $args );
				if( $plugin_categories ):
					$hidden = $this->feed_obj->get( 'theme_import' ) && cbc_check_theme_support();
					?>
				<tr valign="top" id="native_tax_row"
					<?php cbc_hide( $hidden, true );?>>
					<th scope="row"><label for="native_tax"><?php _e('Import in category', 'cbc_video');?>:</label></th>
					<td>
						<?php echo $plugin_categories;?>
						<span class="description"><?php _e('Select category for all videos imported from this playlist.', 'cbc_video');?></span>
					</td>
				</tr>
				<?php endif;?>
				
				
				<?php
				$theme_support = cbc_check_theme_support();
				if( $theme_support ):
					?>
				<tr>
					<th valign="top"><label for="theme_import"><?php printf( __('Import as post compatible with <em>%s</em>?', 'cbc_video'), $theme_support['theme_name']);?></label>
					</th>
					<td><input type="checkbox" name="cbc_feed[theme_import]"
						id="theme_import" value="1"
						<?php cbc_check( $this->feed_obj->get('theme_import') );?> /> <span
						class="description">
							<?php printf( __('If you choose to import in %s, all videos will be imported as post type <strong>%s</strong> and will be visible in your blog categories.', 'cbc_video'), $theme_support['theme_name'], $theme_support['post_type']);?>
						</span></td>
				</tr>				
				<?php
					$args = array( 
							'show_count' => 1, 
							'hide_empty' => 0, 
							'name' => 'cbc_feed[theme_tax]', 
							'id' => 'theme_tax', 
							'selected' => $this->feed_obj->get( 'theme_tax' ), 
							'hide_if_empty' => true, 
							'echo' => false 
					);
					if( ! $theme_support[ 'taxonomy' ] && 'post' == $theme_support[ 'post_type' ] ){
						$args[ 'taxonomy' ] = 'category';
					}else{
						$args[ 'taxonomy' ] = $theme_support[ 'taxonomy' ];
					}
					
					$plugin_options = cbc_get_settings();
					if( isset( $plugin_options ) && $plugin_options[ 'import_categories' ] ){
						$args[ 'show_option_all' ] = __( 'Create categories from YouTube', 'cbc_video' );
					}else{
						$args[ 'show_option_all' ] = __( 'Select category (optional)', 'cbc_video' );
					}
					$plugin_categories = wp_dropdown_categories( $args );
					if( $plugin_categories ):
						?>
				<tr valign="top" id="theme_tax_row"
					<?php cbc_hide( $this->feed_obj->get('theme_import'), false );?>>
					<th scope="row"><label for="theme_tax"><?php printf( __('Import in <strong>%s</strong> category', 'cbc_video'), $theme_support['theme_name']);?>:</label></th>
					<td>
						<?php echo $plugin_categories;?>
						<span class="description"><?php _e('Select category for all videos imported from this playlist as theme posts.', 'cbc_video');?></span>
					</td>
				</tr>
				<?php endif;?>				
				<?php 
					endif
				?>
				<!-- 
				<tr valign="top">
					<th scope="row"><label for=""></label></th>
					<td>
					</td>
				</tr>
				-->
			</tbody>
		</table>
		<?php submit_button( __('Save', 'cbc_video'));?>	
	</form>

</div>