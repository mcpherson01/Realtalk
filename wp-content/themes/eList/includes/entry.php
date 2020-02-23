<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="entry post clearfix">
		<h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<?php get_template_part('includes/postinfo','entry'); ?>

		<?php
			$thumb = '';
			$width = 200;
			$height = 200;
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Blog');
			$thumb = $thumbnail["thumb"];
		?>
		<?php if ( $thumb <> '' && get_option('elist_thumbnails_index') == 'on' ) { ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<span class="post-overlay"></span>
				</a>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>

		<?php if (get_option('elist_blog_style') == 'on') the_content(''); else { ?>
			<p><?php truncate_post(500); ?></p>
		<?php } ?>
		<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More', 'eList'); ?></a>
	</article> 	<!-- end .post-->
	<div class="hr blog-hr"></div>
<?php
endwhile;
	echo '<div id="blog_pagination">';
		if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { get_template_part('includes/navigation','entry'); }
	echo '</div> <!-- end #blog_pagination -->';
else:
	get_template_part('includes/no-results','entry');
endif; ?>