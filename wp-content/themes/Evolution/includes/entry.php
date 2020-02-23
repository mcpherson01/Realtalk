<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="entry post clearfix">
		<h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<div class="entry_content">
			<?php get_template_part('includes/postinfo','entry'); ?>

			<?php
				$thumb = '';
				$width = 147;
				$height = 147;
				$classtext = '';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
				$thumb = $thumbnail["thumb"];
			?>
			<?php if ( $thumb <> '' && get_option('evolution_thumbnails_index') == 'on' ) { ?>
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<span class="post-overlay"></span>
					</a>
				</div> 	<!-- end .post-thumbnail -->
			<?php } ?>

			<?php if (get_option('evolution_blog_style') == 'on') the_content(''); else { ?>
				<p><?php truncate_post(450); ?></p>
			<?php } ?>
			<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('Read More', 'Evolution'); ?></span></a>
		</div> <!-- end .entry_content -->
	</article> 	<!-- end .post-->
<?php
endwhile;
	if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { get_template_part('includes/navigation','entry'); }
else:
	get_template_part('includes/no-results','entry');
endif; ?>