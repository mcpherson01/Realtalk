<span class="current-category">
	<?php single_cat_title(esc_html__('Currently Browsing: ','ePhoto'), 'display'); ?>
</span>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="post-wrapper" style="margin-bottom: 15px;">
        <h1 class="post-title" style="margin-top: 0px"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
            <?php the_title(); ?>
            </a></h1>
        <div class="post-info" style="margin-bottom: 15px;"><?php esc_html_e('Posted by','ePhoto') ?>
           <?php the_author_posts_link(); ?>
            <?php esc_html_e('on','ePhoto') ?>
            <?php the_time(get_option('ephoto_date_format')) ?>
            |
            <?php comments_popup_link(esc_html__('no responses','ePhoto'), esc_html__('one response','ePhoto'), esc_html__('% responses','ePhoto')); ?>
		</div>
        <div style="clear: both;"></div>

		<?php $width = 200;
			  $height = 200;
			  $classtext = 'blogthumbnail';
			  $titletext = get_the_title();

			  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
			  $thumb = $thumbnail["thumb"];  ?>

        <?php if($thumb <> '') { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		<?php } ?>

        <?php truncate_post(600); ?>
		<div style="clear: both;"></div>
    </div>

<?php endwhile; ?>
	<?php get_template_part('includes/page-navigation'); ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>