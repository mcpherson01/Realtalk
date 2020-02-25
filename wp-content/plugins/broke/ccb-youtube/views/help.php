<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e('Info & Help', 'cbc_video');?></h1>
	
	<?php if( !cbc_check_theme_support() ):?>
	<div id="message" class="error">
		<p>
			<strong><?php _e("Seems like your theme isn't compatible with the plugin.", 'cbc_video');?></strong>
			<a class="button"
				href="<?php echo cbc_docs_link( 'tutorials/third-party-compatibility' );?>"><?php _e('See how to make it compatible!', 'cbc_video');?></a>
		</p>
	</div>
	<?php else:?>
	<div id="message" class="updated">
		<p>
			<strong><?php _e("Congratulations, your current theme is compatible with the plugin.", 'cbc_video');?></strong>
		</p>
	</div>
	<?php endif;?>
	
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content" style="position: relative;">

				<h3><?php _e('Default compatible WordPress themes', 'cbc_video');?></h3>
				<p>
					<?php _e('If any of the themes below is installed and active, you have the option to import YouTube videos directly as posts compatible with the theme.', 'cbc_video');?>
				</p>
				<ol>
					<?php foreach($themes as $theme):?>
					<li>
						<?php
						$class = 'not-installed';
						if( isset( $theme[ 'installed' ] ) && $theme[ 'installed' ] ){
							$class = 'cbc-installed';
						}
						if( isset( $theme[ 'active' ] ) && $theme[ 'active' ] ){
							$class = 'cbc-active';
						}
						?>
						<?php printf('<a href="%1$s" target="_blank" title="%2$s" class="%3$s">%2$s</a>', $theme['url'], $theme['theme_name'], $class);?>
					</li>
					<?php endforeach;?>
				</ol>

				<p class="notice"
					style="padding: 2em 1em; font-size: 1.1em; font-style: italic;">
					<?php _e("If your theme isn't listed above, the next thing to try is to <strong>import videos as regular post type</strong>. To do this, just visit page plugin page Settings and check the option <strong>Import as regular post type (aka post)</strong>.", 'cbc_video');?><br />
					<?php _e('This will enable you to import YouTube videos as regular posts that have the same player settings as the custom post type and will follow the rules you set in Settings page.', 'cbc_video');?>
					<br />
					<?php printf(__("If importing as regular post type doesn't work for you (for example your WP theme has video capabilities and you want to import videos as posts compatible with your theme), just %sfollow the tutorial to make your WP theme compatible with the plugin%s.", 'cbc_video'), '<a href="' . cbc_docs_link( 'tutorials/third-party-compatibility' ) . '" target="_blank">', '</a>');?>
				</p>

				<hr />

				<h3><?php _e('Compatible WordPress plugins', 'cbc_video');?></h3>
				<p>
					<?php _e( 'The plugin was tested and made compatible with following plugins:', 'cbc_video' );?>
				</p>
				<ul>
					<li><a href="https://wordpress.org/plugins/amp/" target="_blank"><?php _e( 'AMP', 'cbc_video' );?></a>
						(<em><a
							href="<?php echo cbc_docs_link('tutorials/amp-plugin-compatibility/')?>"
							target="_blank"><?php _e( 'Click here for more details', 'cbc_video' )?></a></em>)</li>
					<li><a href="https://yoast.com/wordpress/plugins/video-seo/"
						target="_blank"><?php _e( 'Yoast Video SEO', 'cbc_video' );?></a></li>
				</ul>

				<hr />

				<h3><?php _e( 'Shortcodes reference', 'cbc_video' );?></h3>
				<ul>
				<?php foreach( $shortcodes_obj->get_shortcodes() as $shortcode => $data ):?>
					<li>
						<h3>[<?php echo $shortcode;?>]</h3>
						<h4><?php _e( 'Attributes', 'cbc_video' );?></h4>
						<ul>
						<?php foreach( $data['atts'] as $att => $details ):?>
							<li><strong><?php echo $att;?></strong>: <?php echo $details['description'];?></li>
						<?php endforeach;?>
						</ul>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<?php do_meta_boxes( 'cbc_help_screen', 'side', false )?>
				</div>
			</div>
		</div>
	</div>
</div>
