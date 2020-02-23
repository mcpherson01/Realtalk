<?php get_header(); ?>
<!--Begin Feaured Article-->
<?php if (get_option('lightsource_featured') == 'on') { get_template_part('includes/featured'); } ?>
<!--End Feaured Article-->

<div id="container">
<?php if (get_option('lightsource_random') == 'on') { ?>
	<div class="home-box-container"> <span class="heading2"><?php esc_html_e('Random Posts','LightSource') ?></span>
		<div class="prev"></div>
		<div class="home-box">
			<ul>
				<?php $lightsource_random_posts = (int) get_option('lightsource_random_posts');
				$my_query = new WP_Query("orderby=rand&posts_per_page=$lightsource_random_posts");
	  while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>" class="titles-small">
					<?php truncate_title(20); ?>
					</a>
					<div class="post-info"><?php esc_html_e('Posted by','LightSource') ?>
						<?php the_author() ?>
						<?php esc_html_e('on','LightSource') ?>
						<?php the_time('m jS, Y') ?>
					</div>

					<?php $width = 65;
						  $height = 65;

						  $classtext = 'thumbnail-small';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb != '') { ?>
						<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						</a>
					<?php } ?>

					<?php truncate_post(110); ?>
				</li>
	  <?php endwhile; ?>
			</ul>
		</div>
		<div class="next"></div>
	</div>
<?php } ?>
<?php if (get_option('lightsource_recent') == 'on') { ?>
	<div class="home-box-container2"> <span class="heading2"><?php esc_html_e('Recent Comments','LightSource') ?></span>
		<div class="prev"></div>
		<div class="home-box2 home-comments">
			<?php include (get_template_directory() . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */ ?>
			<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(get_option('lightsource_recent_comments'), 55, '', ''); } ?>
		</div>
		<div class="next"></div>
	</div>
<?php } ?>
<div class="home-box-container3"> <span class="heading2"><?php esc_html_e('Lifestream','LightSource') ?></span>
    <div class="prev"></div>
    <div class="home-box3">
        <?php if (function_exists('lifestream')) lifestream(); else echo('Please, activate plugins that come with the theme.'); ?>
    </div>
    <div class="next"></div>
</div>
<div style="clear: both;"></div>
<div id="left-div">
    <div id="left-inside">
        <?php if (get_option('lightsource_format') == 'on') { ?>
			<?php get_template_part('includes/blogstyle'); ?>
        <?php } else { get_template_part('includes/default'); } ?>
    </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>