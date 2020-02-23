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

	<div id="content-top">
		<div id="menu-bg"></div>
		<div id="top-index-overlay"></div>

		<div id="content" class="clearfix<?php if($fullwidth) echo(' fullwidth');?>">
			<div id="main-area">
				<?php get_template_part('includes/breadcrumbs'); ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="full_entry clearfix">
					<?php if (get_option('elegantestate_integration_single_top') <> '' && get_option('elegantestate_integrate_singletop_enable') == 'on') echo(get_option('elegantestate_integration_single_top')); ?>

					<?php $width = 159;
						  $height = 159;
						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<div class="entry_content<?php if ($thumb <> '' && get_option('elegantestate_thumbnails_index') == 'on') echo(' setwidth') ?>">
						<?php if($thumb <> '' && get_option('elegantestate_page_thumbnails') == 'on') { ?>
							<div class="small-thumb">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
								<span class="overlay"></span>
							</div> 	<!-- end .small-thumb -->
						<?php }; ?>

						<h1 class="single-title"><?php the_title(); ?></h1>
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ElegantEstate').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<div id="et-login">
							<div class='et-protected'>
								<div class='et-protected-form'>
									<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

									<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
										<p><label><span><?php esc_html_e('Username','ElegantEstate'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
										<p><label><span><?php esc_html_e('Password','ElegantEstate'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
										<input type='submit' name='submit' value='Login' class='etlogin-button' />
									</form>
								</div> <!-- .et-protected-form -->
							</div> <!-- .et-protected -->
						</div> <!-- end #et-login -->

						<div class="clear"></div>

						<?php edit_post_link(esc_html__('Edit this page','ElegantEstate')); ?>
					</div> <!-- end .entry_content -->

				</div> <!-- .full_entry -->

				<?php if (get_option('elegantestate_show_pagescomments') == 'on') comments_template('', true); ?>
				<?php endwhile; endif; ?>
			</div> <!-- end #main-area -->

			<?php if (!$fullwidth) get_sidebar(); ?>

<?php get_footer(); ?>