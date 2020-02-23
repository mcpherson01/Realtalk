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

<?php get_template_part('includes/breadcrumbs','index'); ?>

<div id="main-content" <?php if($fullwidth) echo ('class="fullwidth"');?>>
	<div id="main-content-bg">
		<div id="main-content-bottom-bg" class="clearfix">
			<div id="left-area">
				<div id="main-products" class="clearfix">
					<?php get_template_part('loop','page'); ?>

					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','Boutique'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','Boutique'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->

					<div class="clear"></div>

				</div> <!-- end #main-products -->
			</div> <!-- end #left-area -->

			<?php if (!$fullwidth) get_sidebar(); ?>
		</div> <!-- end #main-content-bottom-bg -->
	</div> <!-- end #main-content-bg -->
</div> <!-- end #main-content -->
<?php get_footer(); ?>