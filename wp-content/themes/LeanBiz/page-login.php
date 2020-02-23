<?php
/*
Template Name: Login Page
*/
?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs','page'); ?>

<div id="content-border" <?php if($fullwidth) echo ('class="fullwidth"');?>>
	<div id="content-top-border-shadow"></div>
	<div id="content-bottom-border-shadow"></div>
	<div id="content" class="clearfix">
		<div id="content-right-bg" class="clearfix">
			<div id="left-area">
				<div class="entry post clearfix<?php if ( get_option('leanbiz_show_pagescomments') == 'false' || 0 == get_comments_number() ) echo ' comments_disabled'; ?>">
					<?php get_template_part('loop','page'); ?>

					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','LeanBiz'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','LeanBiz'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->

					<div class="clear"></div>
				</div> <!-- end .entry -->
				<?php if (get_option('leanbiz_show_pagescomments') == 'on') comments_template('', true); ?>
			</div> 	<!-- end #left-area -->
			<?php if (!$fullwidth){ ?>
				<div id="content-top-shadow"></div>
				<div id="content-bottom-shadow"></div>
				<div id="content-widget-light"></div>
				<?php get_sidebar(); ?>
			<?php } ?>
		</div> <!-- end #content-right-bg -->
	</div> <!-- end #content -->
</div> <!-- end #content-border -->

<?php get_footer(); ?>