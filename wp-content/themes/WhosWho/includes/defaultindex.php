<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="home-post-wrap2">
		<!--Begin Post-->
			<h2 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
				<?php the_title() ?>
				</a></h2>

			<?php $thumb = '';
				  $width = 120;
				  $height = 120;
				  $classtext = '';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php if (get_option('whoswho_thumbnails') == 'false' && get_option('whoswho_blog_style')=='on') $thumb = ''; ?>

			<?php if($thumb != '') { ?>
				<div class="thumbnail-div">
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				</div>
			<?php }; ?>

			<?php get_template_part('includes/postinfo'); ?>

			<?php if (get_option('whoswho_blog_style')=='false') truncate_post(310);
				  else the_content(); ?>

			<?php if (get_option('whoswho_blog_style')=='false') { ?>
				<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>"><?php esc_html_e('Read More','WhosWho'); ?></a></div>
			<?php }; ?>
			<div style="clear: both;"></div>
	</div>
	<!--End Post-->
<?php endwhile; ?>
	<div style="clear: both;"></div>

	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
    else { ?>
         <?php get_template_part('includes/navigation'); ?>
    <?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>