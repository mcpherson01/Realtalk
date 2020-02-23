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

<div id="container">
	<div id="container2">
		<div id="left-div">
			<div class="post-wrapper <?php if($fullwidth) echo (' no_sidebar');?>">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1 class="titles2">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','BlueMist'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</h1>
					<div style="clear: both;"></div>

					<?php if (get_option('bluemist_page_thumbnails') == 'on') { ?>

						<?php $thumb = '';

						$width = (int) get_option('bluemist_thumbnail_width_pages');
						$height = (int) get_option('bluemist_thumbnail_height_pages');
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb <> '') { ?>
							<div style="float: left; margin: 15px 15px 10px 0px;">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</div>
						<?php }; ?>

					<?php }; ?>

					<?php the_content(); ?>
					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','BlueMist'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','BlueMist'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->


					<div style="clear: both;"></div>

					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','BlueMist').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','BlueMist')); ?>

				</div> <!-- end .post-wrapper -->

				<?php if (get_option('bluemist_show_pagescomments') == 'on') { ?>
					<?php comments_template('', true); ?>
				<?php }; ?>
			<?php endwhile; endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->
	<?php if (!$fullwidth) get_sidebar(); ?>
</div>	<!-- end #container -->
<?php get_footer(); ?>
</body>
</html>