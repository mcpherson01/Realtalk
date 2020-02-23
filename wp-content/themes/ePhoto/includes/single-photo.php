<?php get_header(); ?>

<div id="container2">
<div id="left-div2">
<?php if (get_option('ephoto_integration_single_top') <> '' && get_option('ephoto_integrate_singletop_enable') == 'on') echo(get_option('ephoto_integration_single_top')); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!--Begin Post-->

<?php $video = get_post_meta($post->ID, 'Video', $single = true); ?>
<?php if($video <> '') : ?>
	<div class="thumbnail-single">
		<?php echo $video; ?>
	</div>
<?php elseif (get_option('ephoto_thumbnails_photo') == 'on') : ?>

	<?php $width = 624;
		  $height = 364;
		  $classtext = '';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
		  $thumb = $thumbnail["thumb"]; ?>

	<?php if ($thumb <> '') { ?>
		<div class="thumbnail-single" style="background-image: url('<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, '', true, true); ?>');">
			<div class="sections-overlay">
				<a href="<?php echo esc_url($thumbnail["fullpath"]); ?>" title="<?php the_title() ?>" class="fancybox">
					<img src="<?php echo get_template_directory_uri(); ?>/images/zoom.png" alt="" class="zoom" />
				</a>
			</div>
		</div>
	<?php } ?>

<?php endif; ?>

    <div class="post-wrapper">
        <h1 class="post-title"><?php the_title(); ?></h1>

		<?php if(get_option('ephoto_postinfo1') ) { ?>
			<div class="post-info">
				<?php esc_html_e('Posted','ePhoto') ?> <?php if (in_array('author', get_option('ephoto_postinfo1'))) { ?> <?php esc_html_e('by','ePhoto') ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('ephoto_postinfo1'))) { ?> <?php esc_html_e('on','ePhoto') ?> <?php the_time(get_option('ephoto_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('ephoto_postinfo1'))) { ?> <?php esc_html_e('in','ePhoto') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('ephoto_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','ePhoto'), esc_html__('1 comment','ePhoto'), '% '.esc_html__('comments','ePhoto')); ?><?php }; ?>
			</div>
		<?php }; ?>

            <div class="post-info2">
				<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
            </div>
        <div style="clear: both;"></div>
        <?php the_content(); ?>
		<?php if (get_option('ephoto_integration_single_bottom') <> '' && get_option('ephoto_integrate_singlebottom_enable') == 'on') echo(get_option('ephoto_integration_single_bottom')); ?>
		<br style="clear: both;"/>
		<?php if (get_option('ephoto_show_postcomments_photo') == 'on') { ?>
			<div class="comments-wrapper">
				<?php comments_template('',true); ?>
			</div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/comments-bottom-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.gif" alt="comments-bottom" style="float: left;" />
		<?php }; ?>
        <?php endwhile; ?>
    </div>
    <?php else : ?>
		<?php get_template_part('includes/no-results'); ?>
    <?php endif; ?>
</div>

<?php get_sidebar(); ?>

</div>

	<div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div>


<?php get_footer(); ?>

</body>
</html>