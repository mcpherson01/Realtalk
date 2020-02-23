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
<?php if($fullwidth) echo ('<style>#wrapper2 {background-image:none; }</style>');?>

<div id="container">
<div id="left-div"<?php if($fullwidth) echo (' style="width: 900px;');?>>
    <div id="left-inside">

        <!--Start Post-->
        <div class="home-post-wrap" <?php if($fullwidth) echo ('style="width: 880px;');?>>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Basic'), get_the_title()) ?>">
					<?php the_title() ?>
					</a></h1>
				<div style="clear: both;"></div>
				<?php if (get_option('basic_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
				<?php the_content(''); ?>
						<div id="et-login">
							<div class='et-protected'>
								<div class='et-protected-form'>
									<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

									<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
										<p><label><span><?php esc_html_e('Username','Basic'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
										<p><label><span><?php esc_html_e('Password','Basic'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
										<input type='submit' name='submit' value='Login' class='etlogin-button' />
									</form>
								</div> <!-- .et-protected-form -->
							</div> <!-- .et-protected -->
						</div> <!-- end #et-login -->

				<div style="clear: both;"></div>
				<?php if (get_option('basic_show_pagescomments') == 'on') { ?>
					<?php comments_template('', true); ?>
				<?php }; ?>
			<?php endwhile; endif; ?>
        </div>

    </div>
</div>
<!--Begin Sidebar-->
<?php if (!$fullwidth) get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>