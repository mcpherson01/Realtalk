<?php if (is_category()) { ?>
    <span class="current-category">
	    <?php single_cat_title(esc_html__('Currently Browsing: ','StudioBlue'), 'display'); ?>
    </span>
<?php }; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php $thumb = '';
		  $width = 90;
		  $height = 90;
		  $classtext = 'no_border';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

    <div class="home-post-wrap2">
		<div style="clear: both;"></div>
		<div class="single-entry">
			<h2 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
				<?php the_title() ?></a></h2>
			<?php if($thumb != '' && get_option('studioblue_blog_style') == 'false') { ?>
				<div class="thumbnail-div">
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					</a>
				</div>
			<?php }; ?>

			<?php get_template_part('includes/postinfo'); ?>

			<?php if (get_option('studioblue_blog_style') == 'false') truncate_post(310); else the_content(); ?>

			<div style="clear: both;"></div>
			<?php if (get_option('studioblue_blog_style') == 'false') { ?>
				<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>"><?php esc_html_e('Read More','StudioBlue'); ?></a></div>
			<?php }; ?>
		</div>
    </div>
<?php endwhile; ?>
    <div style="clear: both;"></div>
    <?php get_template_part('includes/navigation'); ?>
<?php else : ?>
    <?php get_template_part('includes/no-results'); ?>
<?php endif; ?>