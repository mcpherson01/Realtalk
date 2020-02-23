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
		<!--Start Post-->
        <span class="single-entry-titles" style="margin-top: 18px;"></span>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="post-wrapper">
                  <?php if (get_option('egamer_integration_single_top') <> '' && get_option('egamer_integrate_singletop_enable') == 'on') { ?>
                  <div style="clear: both;"></div>
		  <?php echo(get_option('egamer_integration_single_top')); ?>
          <?php }; ?>
          <div style="clear: both;"></div>
        <?php if (get_option('egamer_page_thumbnails') == 'on') { ?>
			<?php $width = (int) get_option('egamer_thumbnail_width_pages');
				  $height = (int) get_option('egamer_thumbnail_height_pages');

				  $classtext = 'linkimage';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
				  $thumb = $thumbnail["thumb"];  ?>

			<?php if($thumb <> '') { ?>
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			<?php } ?>

        <?php }; ?>
            <h1 class="post-title" style="margin-top: 13px;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></h1>
            <?php the_content(); ?>
                      <?php #if (get_option('egamer_integration_single_bottom') <> '' && get_option('egamer_integrate_singlebottom_enable') == 'on') { ?>
                  <div style="clear: both;"></div>

				<div id="et-login">
					<div class='et-protected'>
						<div class='et-protected-form'>
							<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

							<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
								<p><label><span><?php esc_html_e('Username','eGamer'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
								<p><label><span><?php esc_html_e('Password','eGamer'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
								<input type='submit' name='submit' value='Login' class='etlogin-button' />
							</form>
						</div> <!-- .et-protected-form -->
					</div> <!-- .et-protected -->
				</div> <!-- end #et-login -->

				<div class="clear"></div>
			<?php endwhile; endif; ?>
		  <?php #echo(get_option('egamer_integration_single_bottom')); ?>
          <?php #}; ?>
        </div>
        <?php $video = get_post_meta($post->ID, 'Video', $single = true); ?>
    <?php
if($video <> '') { ?>
    <span class="single-entry-titles" style="margin-top: 18px;"><?php esc_html_e('Play Video','eGamer') ?></span>
    <div class="post-wrapper" style="padding-top: 14px;"> <?php echo $video; ?> </div>
    <?php }
else { echo ''; } ?>

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