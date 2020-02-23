<?php
if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';

		$width = 140;
		$height = 140;
		$classtext = 'thumbnail alignleft';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"];
	?>

	<div class="entry clearfix">

		<?php global $post;
			  $page_result = is_search() && ($post->post_type == 'page') ? true : false; ?>

		<h2 class="title<?php if ($page_result) echo(' page_result'); ?>"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'MyProduct'), $titletext) ?>"><?php the_title(); ?></a></h2>

		<?php if ((get_option('myproduct_postinfo1') ) && !($page_result)) { ?>
			<div class="postinfo">
				<p class="tagline">
					<span class="inner">
						<?php esc_html_e('Posted','MyProduct'); ?> <?php if (in_array('author', get_option('myproduct_postinfo1'))) { ?> <?php esc_html_e('by','MyProduct'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('myproduct_postinfo1'))) { ?> <?php esc_html_e('on','MyProduct'); ?> <?php the_time(get_option('myproduct_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('myproduct_postinfo1'))) { ?> <?php esc_html_e('in','MyProduct'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('myproduct_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','MyProduct'), esc_html__('1 comment','MyProduct'), '% '.esc_html__('comments','MyProduct')); ?><?php }; ?>
					</span> <!-- end span.inner-->
				</p> <!-- end p.tagline-->
			</div> <!-- end .postinfo-->
		<?php }; ?>

		<?php if($thumb <> '' && get_option('myproduct_thumbnails_index') == 'on') { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'MyProduct'), $titletext) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			</a>
		<?php }; ?>

		<?php if (get_option('myproduct_blog_style') == 'on') the_content(""); else { ?>
			<p><?php truncate_post(400); ?></p>
		<?php }; ?>
		<a class="readmore" href="<?php the_permalink(); ?>"><span><?php esc_html_e('Read More','MyProduct'); ?></span></a>

	</div> <!-- end .entry -->
<?php endwhile; ?>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		<?php get_template_part('includes/navigation'); ?>
	<?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>