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

<div class="single_wrap <?php if($fullwidth) echo (' no_sidebar');?>">

    <div class="single_post">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h1>
		<?php if (get_option('coldstone_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
        <?php the_content();?>
					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','ColdStone'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','ColdStone'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->

		<?php edit_post_link(); ?>
		<div style="clear: both;"></div>
		<?php if (get_option('coldstone_show_pagescomments') == 'on') { ?>
			<?php comments_template('', true); ?>
		<?php }; ?>
	<?php endwhile; endif; ?>
    </div>
    <!-- /single_post -->
    <?php if (!$fullwidth) get_sidebar(); ?>
</div>
<div class="footer" style="height:15px;margin-bottom:0;"></div>
<?php get_footer(); ?>