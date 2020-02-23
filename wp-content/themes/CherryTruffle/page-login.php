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

<div id="container2"> <img src="<?php echo get_template_directory_uri(); ?>/images/content-top-home-2<?php if($fullwidth) echo ('-full');?>.gif" alt="logo" style="float: left;" />
    <div id="left-div">
        <!--Start Post-->
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="post-wrapper">
				<h1 class="titles2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>
				<div style="clear: both;"></div>

				<?php if (get_option('cherrytruffle_page_thumbnails') == 'on') { ?>
					<?php $width = get_option('cherrytruffle_thumbnail_width_pages');
						  $height = get_option('cherrytruffle_thumbnail_height_pages');
						  $classtext = 'thumbnail';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb != '') { ?>
						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','CherryTruffle'), get_the_title()) ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						</a>
					<?php } ?>
				<?php }; ?>

				<?php the_content(); ?>
						<div id="et-login">
							<div class='et-protected'>
								<div class='et-protected-form'>
									<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

									<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
										<p><label><span><?php esc_html_e('Username','CherryTruffle'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
										<p><label><span><?php esc_html_e('Password','CherryTruffle'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
										<input type='submit' name='submit' value='Login' class='etlogin-button' />
									</form>
								</div> <!-- .et-protected-form -->
							</div> <!-- .et-protected -->
						</div> <!-- end #et-login -->

				<div style="clear: both;"></div>

				<?php if (get_option('cherrytruffle_show_pagescomments') == 'on') { ?>
					<div class="comment-bg">
						<?php comments_template('',true); ?>
						<div style="clear: both;"></div>
					</div>
					<img src="<?php echo get_template_directory_uri(); ?>/images/comment-bottom.gif" alt="logo" style="float: left; margin-bottom: 20px;" />
				<?php }; ?>

			</div>
		<?php endwhile; endif; ?>
    </div>
    <?php if (!$fullwidth) get_sidebar(); ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom-2<?php if($fullwidth) echo ('-full');?>.gif" alt="logo" style="float: left;" /> </div>
<?php get_footer(); ?>
</body></html>