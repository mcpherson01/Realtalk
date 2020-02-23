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
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry<?php if($fullwidth) echo(' no_sidebar');?>">
			<div class="entry-top"></div>

			<?php get_template_part('includes/share'); ?>

			<div class="post clearfix">
				<div class="content clearfix">

					<h1 class="title"><?php the_title(); ?></h1>

					<div class="clear"></div>

					<?php $thumb = '';
						  $width = 184;
						  $height = 184;
						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'thumb');
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('lightbright_page_thumbnails') == 'on') { ?>
						<div class="thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

					<div id="et-login">
						<div class='et-protected'>
							<div class='et-protected-form'>
								<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

								<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
									<p><label><span><?php esc_html_e('Username','LightBright'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
									<p><label><span><?php esc_html_e('Password','LightBright'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
									<input type='submit' name='submit' value='Login' class='etlogin-button' />
								</form>
							</div> <!-- .et-protected-form -->
						</div> <!-- .et-protected -->
					</div> <!-- end #et-login -->

					<div class="clear"></div>

					<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>

				</div> <!-- end .content -->

				<div class="entry-bottom-top"></div>

				<div class="entry-meta clearfix">
					<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?></span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
					<?php if(!is_single()) { ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
					<?php }; ?>
				</div> <!-- end .entry-meta -->

			</div> <!-- end .post -->

			<div class="entry-bottom"></div>
		</div> <!-- end .entry -->
	<?php endwhile; endif; ?>
	</div> <!-- end #main-area -->

	<?php if (!$fullwidth) get_sidebar(); ?>

<?php get_footer(); ?>