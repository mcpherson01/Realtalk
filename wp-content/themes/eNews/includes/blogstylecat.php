<div id="post-top">
	<div class="breadcrumb">
		<?php if(function_exists('bcn_display')) { bcn_display(); }
		else { ?>
			<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php single_cat_title("") ?></em>
		<?php }; ?>
	</div> <!-- end breadcrumb -->
</div> <!-- end post-top -->

<div id="main-area-wrap">
	<div id="wrapper">
		<div id="main" class="noborder">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h1 class="post-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php the_title() ?></a></h1>
			<span class="meta-comments"><?php comments_popup_link(esc_html__('0 comments','eNews'), esc_html__('1 comment','eNews'), '% '.esc_html__('comments','eNews')); ?></span>

			<?php if (get_option('enews_postinfo') ) { ?>
				<div class="post-meta">
					<div class="post-meta-bottom">
						<p><?php esc_html_e('Posted','eNews') ?> <?php if (in_array('author', get_option('enews_postinfo'))) { ?> <?php esc_html_e('by','eNews') ?> <span class="author"><?php the_author() ?></span><?php }; ?><?php if (in_array('date', get_option('enews_postinfo'))) { ?> <?php esc_html_e('on','eNews') ?> <?php the_time(get_option('enews_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('enews_postinfo'))) { ?> <?php esc_html_e('in','eNews') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('enews_postinfo'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','eNews'), esc_html__('1 comment','eNews'), '% '.esc_html__('comments','eNews')); ?><?php }; ?></p>
					</div>
				</div>
			<?php }; ?>

			<div id="post-content">

<?php if (get_option('enews_thumbnails') == 'on') { ?>

	<?php $width = 127;
		  $height = 127;
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
			<br class="clearfix"/>
<?php endwhile; ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','eNews')) ?>
	<?php previous_posts_link(esc_html__('Next Entries &raquo;','eNews')) ?>
</p>
<?php } ?>
<?php else : ?>
	<!--If no results are found-->
	<div id="post-content">
		<h1><?php esc_html_e('No Results Found','eNews') ?></h1>
		<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eNews') ?></p>
	</div>
	<!--End if no results are found-->
<?php endif; ?>
		</div> <!-- end main -->