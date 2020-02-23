<?php
/*
Template Name: Login Page
*/
?>
<?php get_header(); ?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="post-top">
	<div class="breadcrumb">
		<?php if(function_exists('bcn_display')) { bcn_display(); }
		else { ?>
			<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php the_title() ?></em>
		<?php }; ?>
	</div> <!-- end breadcrumb -->
</div> <!-- end post-top -->

<div id="main-area-wrap" <?php if($fullwidth) echo ('class="no_sidebar"');?>>
	<div id="wrapper">
		<div id="main" class="noborder">
			<h1 class="page-title"><?php the_title() ?></h1>
			<div id="post-content">

				<?php $width = (int) get_option('enews_thumbnail_width_pages');
					  $height = (int) get_option('enews_thumbnail_height_pages');
					  $classtext = 'thumbnail alignleft';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb <> '' && get_option('enews_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<?php }; ?>

				<?php the_content(); ?>
					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','eNews'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','eNews'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->
				<?php edit_post_link(esc_html__('Edit this page','eNews')); ?>

			</div> <!-- end post-content -->
			<br class="clearfix"/>
			<?php if (get_option('enews_show_pagescomments') == 'on') comments_template('', true); ?>

		</div> <!-- end main -->
<?php endwhile; endif; ?>
<?php if (!$fullwidth) get_sidebar(); ?>
<?php get_footer(); ?>