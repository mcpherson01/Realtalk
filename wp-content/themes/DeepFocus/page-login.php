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

<div id="content-full">
	<div id="hr">
		<div id="hr-center">
			<div id="intro">
				<div class="center-highlight">

					<div class="container">

						<?php get_template_part('includes/breadcrumbs'); ?>

					</div> <!-- end .container -->
				</div> <!-- end .center-highlight -->
			</div>	<!-- end #intro -->
		</div> <!-- end #hr-center -->
	</div> <!-- end #hr -->

	<div class="center-highlight">
		<div class="container">

			<?php if ($fullwidth) { ?>
				<div id="full" class="clearfix">
			<?php } else { ?>
				<div id="content-area" class="clearfix">
					<div id="left-area">
			<?php } ?>

					<?php if (get_option('deepfocus_integration_single_top') <> '' && get_option('deepfocus_integrate_singletop_enable') == 'on') echo(get_option('deepfocus_integration_single_top')); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<div class="entry clearfix post<?php if($fullwidth) echo(' full');?>">
							<?php $width = 185;
								  $height = 185;
								  $classtext = '';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<h1 class="title"><?php the_title(); ?></h1>


							<?php if($thumb == '') echo('<div class="clear"></div>'); ?>

							<?php if($thumb <> '' && get_option('deepfocus_page_thumbnails') == 'on') { ?>
								<div class="post-thumbnail">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</div> 	<!-- end .thumbnail -->
							<?php }; ?>

							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','DeepFocus').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

							<div id="et-login">
								<div class='et-protected'>
									<div class='et-protected-form'>
										<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

										<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
											<p><label><span><?php esc_html_e('Username','DeepFocus'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
											<p><label><span><?php esc_html_e('Password','DeepFocus'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
											<input type='submit' name='submit' value='Login' class='etlogin-button' />
										</form>
									</div> <!-- .et-protected-form -->
								</div> <!-- .et-protected -->
							</div> <!-- end #et-login -->

							<div class="clear"></div>

							<?php edit_post_link(esc_html__('Edit this page','DeepFocus')); ?>
						</div> <!-- end .entry -->
					<?php endwhile; endif; ?>
					<?php if (get_option('deepfocus_integration_single_bottom') <> '' && get_option('deepfocus_integrate_singlebottom_enable') == 'on') echo(get_option('deepfocus_integration_single_bottom')); ?>

					</div> <!-- end #left-area -->

				<?php if (!$fullwidth) get_sidebar(); ?>

			</div> <!-- end #content-area -->

		</div> <!-- end .container -->

		<?php get_footer(); ?>