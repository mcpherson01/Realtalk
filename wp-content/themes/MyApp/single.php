<?php the_post(); ?>

<?php get_header(); ?>

<div id="main-content">

	<?php if (get_option('myapptheme_integration_single_top') <> '' && get_option('myapptheme_integrate_singletop_enable') == 'on') echo(get_option('myapptheme_integration_single_top')); ?>

	<div class="entry post clearfix">

		<?php if (get_option('myapptheme_thumbnails') == 'on') { ?>

			<?php $width = (int) get_option('myapptheme_thumbnail_width_posts');
				  $height = (int) get_option('myapptheme_thumbnail_height_posts');
				  $classtext = 'thumb alignleft';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php if($thumb <> '') print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>

		<?php }; ?>

		<h1 class="title"><?php the_title(); ?></h1>

		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','MyAppTheme').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link(esc_html__('Edit this page','MyAppTheme')); ?>

	</div> <!-- end .post -->

	<?php if (get_option('myapptheme_integration_single_bottom') <> '' && get_option('myapptheme_integrate_singlebottom_enable') == 'on') echo(get_option('myapptheme_integration_single_bottom')); ?>
	<?php if (get_option('myapptheme_468_enable') == 'on') { ?>
		<a href="<?php echo esc_url(get_option('myapptheme_468_url')); ?>"><img src="<?php echo esc_attr(get_option('myapptheme_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
	<?php } ?>

	<div class="hr"></div>

	<?php if (get_option('myapptheme_show_postcomments') == 'on') comments_template('', true); ?>



</div> <!-- end #main-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>