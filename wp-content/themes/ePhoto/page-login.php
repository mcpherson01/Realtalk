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
<div id="container2">
<div id="left-div2" <?php if($fullwidth) echo ('style="width: 910px;"');?>>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<!--Start Post-->
		<div class="post-wrapper" <?php if($fullwidth) echo ('style="width: 900px;"');?>>
			<h1 class="post-title2"><?php the_title(); ?></h1>
			<div style="clear: both;"></div>

			<?php if (get_option('ephoto_page_thumbnails') == 'on') { ?>
				<?php $width = (int) get_option('ephoto_thumbnail_width_pages');
					  $height = (int) get_option('ephoto_thumbnail_height_pages');
					  $classtext = 'blogthumbnail';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb <> '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php } ?>
			<?php } ?>

			<?php the_content(); ?>
					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','ePhoto'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','ePhoto'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->
			<br class="clearfix"/>
		</div>
		<?php if (get_option('ephoto_show_pagescomments') == 'on') { ?>
			<div class="comments-wrapper">
				<?php comments_template('', true); ?>
			</div>
			<img src="<?php bloginfo('template_directory'); ?>/images/comments-bottom-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.gif" alt="comments-bottom" style="float: left;" />
		<?php }; ?>

    <!--End Post-->
    <?php endwhile; endif; ?>
</div>
<?php if (!$fullwidth) get_sidebar(); ?>

</div>

	<div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div>

<?php get_footer(); ?>

</body>
</html>