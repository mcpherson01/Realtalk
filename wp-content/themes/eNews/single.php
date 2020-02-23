<?php get_header(); ?>
<div id="post-top">
	<?php previous_post_link('<span id="prev-link">%link</span>'); ?>
	<?php if (get_option('enews_posts_share') == 'on') get_template_part('includes/share'); ?>
	<?php next_post_link('<span id="next-link">%link</span>'); ?>
</div> <!-- end post-top -->

<div id="main-area-wrap">
	<div id="wrapper">
		<div id="main" class="noborder">
<?php if (get_option('enews_integration_single_top') <> '' && get_option('enews_integrate_singletop_enable') == 'on') echo(get_option('enews_integration_single_top')); ?>
 <div class="clearfix"></div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<h1 class="post-title"><?php the_title() ?></h1>
			<span class="meta-comments"><?php comments_popup_link(esc_html__('0 comments','eNews'), esc_html__('1 comment','eNews'), '% '.esc_html__('comments','eNews')); ?></span>

			<?php if (get_option('enews_postinfo') ) { ?>
				<div class="post-meta">
					<div class="post-meta-bottom">
						<p><?php esc_html_e('Posted','eNews') ?> <?php if (in_array('author', get_option('enews_postinfo'))) { ?> <?php esc_html_e('by','eNews') ?> <span class="author"><?php the_author() ?></span><?php }; ?><?php if (in_array('date', get_option('enews_postinfo'))) { ?> <?php esc_html_e('on','eNews') ?> <?php the_time(get_option('enews_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('enews_postinfo'))) { ?> <?php esc_html_e('in','eNews') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('enews_postinfo'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eNews'), esc_html__('1 comment','eNews'), '% '.esc_html__('comments','eNews')); ?><?php }; ?></p>
					</div>
				</div>
            <?php }; ?>

            <div style="clear: both;"></div>
			<div id="post-content">

<?php if (get_option('enews_thumbnails') == 'on') { ?>

	<?php $width = (int) get_option('enews_thumbnail_width_posts');
		  $height = (int) get_option('enews_thumbnail_height_posts');
		  $classtext = 'thumbnail alignleft';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

	<?php if($thumb <> '') { ?>
		<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
	<?php }; ?>

<?php }; ?>
				<?php the_content(); ?>
				<?php edit_post_link(esc_html__('Edit this post','eNews')); ?>
			</div> <!-- end post-content -->
			<div class="clearfix"></div>
			<?php if (get_option('enews_integration_single_bottom') <> '' && get_option('enews_integrate_singlebottom_enable') == 'on') echo(get_option('enews_integration_single_bottom')); ?>
            <div class="clearfix"></div>
            <?php if (get_option('enews_468_enable') == 'on') { ?>
			<a href="<?php echo esc_url(get_option('enews_468_url')); ?>"><img src="<?php echo esc_attr(get_option('enews_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
            <div class="clearfix"></div>
            <?php } ?>

			<?php if (get_option('enews_show_postcomments') == 'on') comments_template('', true); ?>

<?php endwhile; ?>

<?php else : ?>
	<!--If no results are found-->
	<div id="post-content">
		<h1><?php esc_html_e('No Results Found','eNews') ?></h1>
		<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eNews') ?></p>
	</div>
	<!--End if no results are found-->
<?php endif; ?>
		</div> <!-- end main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>