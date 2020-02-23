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

<div id="container"<?php if ($fullwidth) echo ' class="no_sidebar"'; ?>>
<div id="left-div">
    <div id="left-inside">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!--Start Post-->
        <div class="post-wrapper">
            <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
			<?php if (get_option('lightsource_page_thumbnails') == 'on') { get_template_part('includes/thumbnail'); } ?>
            <?php the_content(); ?>
			<div style="clear: both;"></div>
			<div id="et-login">
				<div class='et-protected'>
					<div class='et-protected-form'>
						<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

						<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
							<p><label><span><?php esc_html_e('Username','LightSource'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
							<p><label><span><?php esc_html_e('Password','LightSource'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
							<input type='submit' name='submit' value='Login' class='etlogin-button' />
						</form>
					</div> <!-- .et-protected-form -->
				</div> <!-- .et-protected -->
			</div> <!-- end #et-login -->

			<div class="clear"></div>
		</div>
	<?php endwhile; endif; ?>
    </div>
</div>
<?php if($fullwidth) echo ('</div>');?>
<!--Begin Sidebar-->
<?php if (!$fullwidth) get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>