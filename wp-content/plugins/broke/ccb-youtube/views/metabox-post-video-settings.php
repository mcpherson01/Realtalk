<?php wp_nonce_field('cbc-save-video-settings', 'cbc-video-nonce');?>
<table class="form-table cbc-player-settings-options">
	<tbody>
		<tr>
			<th><label for="cbc_aspect_ratio"><?php _e('Player size', 'cbc_video');?>:</label></th>
			<td><label for="cbc_aspect_ratio"><?php _e('Aspect ratio');?> :</label>
				<?php
				$args = array( 
						'options' => array( 
								'4x3' => '4x3', 
								'16x9' => '16x9' 
						), 
						'name' => 'aspect_ratio', 
						'id' => 'cbc_aspect_ratio', 
						'class' => 'cbc_aspect_ratio', 
						'selected' => $settings[ 'aspect_ratio' ] 
				);
				cbc_select( $args );
				?>
				<label for="cbc_width"><?php _e('Width', 'cbc_video');?>:</label> <input
				type="text" name="width" id="cbc_width" class="cbc_width"
				value="<?php echo $settings['width'];?>" size="2" />px
				| <?php _e('Height', 'cbc_video');?> : <span class="cbc_height"
				id="cbc_calc_height"><?php echo cbc_player_height( $settings['aspect_ratio'], $settings['width'] );?></span>px
			</td>
		</tr>

        <tr>
            <th><label for="cvwp-nocookie"><?php _e( 'No cookies video embed', 'cbc_video' );?>:</label></th>
            <td>
                <input type="checkbox" value="1" name="nocookie" id="cvwp-nocookie"<?php cbc_check( (bool) $settings['nocookie'] );?> />
                <span class="description"><?php _e('embed video from cookieless domain', 'cbc_video');?></span>
            </td>
        </tr>

		<tr>
			<th><label for="cbc_video_position"><?php _e('Display video in custom post','cbc_video');?>:</label></th>
			<td>
				<?php
				$args = array( 
						'options' => array( 
								'above-content' => __( 'Above post content', 'cbc_video' ), 
								'below-content' => __( 'Below post content', 'cbc_video' ) 
						), 
						'name' => 'video_position', 
						'id' => 'cbc_video_position', 
						'selected' => $settings[ 'video_position' ] 
				);
				cbc_select( $args );
				?>
			</td>
		</tr>
		<tr>
			<th><label for="cbc_volume"><?php _e('Volume', 'cbc_video');?>:</label></th>
			<td><input type="text" name="volume" id="cbc_volume"
				value="<?php echo $settings['volume'];?>" size="1" maxlength="3" />
				<label for="cbc_volume"><span class="description">( <?php _e('number between 0 (mute) and 100 (max)', 'cbc_video');?> )</span></label>
			</td>
		</tr>
		<tr>
			<th><label for="cbc_autoplay"><?php _e('Autoplay', 'cbc_video');?>:</label></th>
			<td><input name="autoplay" id="cbc_autoplay" type="checkbox"
				value="1" <?php cbc_check((bool)$settings['autoplay']);?> /> <label
				for="cbc_autoplay"><span class="description">( <?php _e('when checked, video will start playing once page is loaded', 'cbc_video');?> )</span></label>
			</td>
		</tr>

		<tr>
			<th><label for="cbc_controls"><?php _e('Show controls', 'cbc_video');?>:</label></th>
			<td><input name="controls" id="cbc_controls" class="cbc_controls"
				type="checkbox" value="1"
				<?php cbc_check((bool)$settings['controls']);?> /> <label
				for="cbc_controls"><span class="description">( <?php _e('when checked, player will display video controls', 'cbc_video');?> )</span></label>
			</td>
		</tr>

		<tr class="controls_dependant"
			<?php cbc_hide((bool)$settings['controls']);?>>
			<th><label for="cbc_fs"><?php _e('Allow full screen', 'cbc_video');?>:</label></th>
			<td><input name="fs" id="cbc_fs" type="checkbox" value="1"
				<?php cbc_check((bool)$settings['fs']);?> /></td>
		</tr>

		<tr class="controls_dependant"
			<?php cbc_hide((bool)$settings['controls']);?>>
			<th><label for="cbc_autohide"><?php _e('Autohide controls');?>:</label></th>
			<td>
				<?php
				$args = array( 
						'options' => array( 
								'0' => __( 'Always show controls', 'cbc_video' ), 
								'1' => __( 'Hide controls on load and when playing', 'cbc_video' ), 
								'2' => __( 'Hide controls when playing', 'cbc_video' ) 
						), 
						'name' => 'autohide', 
						'id' => 'cbc_autohide', 
						'selected' => $settings[ 'autohide' ] 
				);
				cbc_select( $args );
				?>
			</td>
		</tr>

		<tr class="controls_dependant"
			<?php cbc_hide((bool)$settings['controls']);?>>
			<th><label for="cbc_theme"><?php _e('Player theme', 'cbc_video');?>:</label></th>
			<td>
				<?php
				$args = array( 
						'options' => array( 
								'dark' => __( 'Dark', 'cbc_video' ), 
								'light' => __( 'Light', 'cbc_video' ) 
						), 
						'name' => 'theme', 
						'id' => 'cbc_theme', 
						'selected' => $settings[ 'theme' ] 
				);
				cbc_select( $args );
				?>
			</td>
		</tr>

		<tr class="controls_dependant"
			<?php cbc_hide((bool)$settings['controls']);?>>
			<th><label for="cbc_color"><?php _e('Player color', 'cbc_video');?>:</label></th>
			<td>
				<?php
				$args = array( 
						'options' => array( 
								'red' => __( 'Red', 'cbc_video' ), 
								'white' => __( 'White', 'cbc_video' ) 
						), 
						'name' => 'color', 
						'id' => 'cbc_color', 
						'selected' => $settings[ 'color' ] 
				);
				cbc_select( $args );
				?>
			</td>
		</tr>

		<tr class="controls_dependant" valign="top"
			<?php cbc_hide($settings['controls']);?>>
			<th scope="row"><label for="modestbranding"><?php _e('No YouTube logo on controls bar', 'cbc_video')?>:</label></th>
			<td><input type="checkbox" value="1" id="modestbranding"
				name="modestbranding"
				<?php cbc_check( (bool)$settings['modestbranding'] );?> /> <span
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
						'selected' => $settings[ 'iv_load_policy' ] 
				);
				cbc_select( $args );
				?>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="rel"><?php _e('Show related videos', 'cbc_video')?>:</label></th>
			<td><input type="checkbox" value="1" id="rel" name="rel"
				<?php cbc_check( (bool)$settings['rel'] );?> /> <label for="rel"><span
					class="description"><?php _e('when checked, after video ends player will display related videos', 'cbc_video');?></span></label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="showinfo"><?php _e('Show video title in player', 'cbc_video')?>:</label></th>
			<td><input type="checkbox" value="1" id="showinfo" name="showinfo"
				<?php cbc_check( (bool )$settings['showinfo']);?> /></td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="disablekb"><?php _e('Disable keyboard player controls', 'cbc_video')?>:</label></th>
			<td><input type="checkbox" value="1" id="disablekb" name="disablekb"
				<?php cbc_check( (bool)$settings['disablekb'] );?> /> <span
				class="description"><?php _e('Works only when player has focus.', 'cbc_video');?></span>
			</td>
		</tr>

	</tbody>
</table>