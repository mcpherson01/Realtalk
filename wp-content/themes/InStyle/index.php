<?php get_header(); ?>

	<?php get_template_part('includes/top_info'); ?>

	<div id="content-top"></div>
	<div id="content" class="clearfix">
		<div id="content-area">
			<?php get_template_part('includes/breadcrumbs'); ?>

			<?php $i = 1;?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post clearfix">
					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php get_template_part('includes/postinfo'); ?>

					<?php
						$thumb = '';
						$width = 211;
						$height = 211;
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
						$thumb = $thumbnail["thumb"];
					?>

					<?php if($thumb <> '' && get_option('instyle_thumbnails_index') == 'on') { ?>
						<div class="post-thumbnail alignleft">
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								<span class="post-overlay"></span>
							</a>
						</div> 	<!-- end .post-thumbnail -->
					<?php } ?>

					<div class="description">
						<?php if ( get_option('instyle_blog_style') == 'on' ){ ?>
							<?php echo apply_filters('the_content',et_create_dropcaps(get_the_content(''))); ?>
						<?php } else { ?>
							<p><?php echo et_create_dropcaps(truncate_post(775,false)); ?></p>
						<?php } ?>
					</div> 	<!-- end .description-->
					<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','InStyle'); ?></span></a>
				</div> <!-- end .post -->
			<?php endwhile; ?>
				<?php
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
					else { get_template_part('includes/navigation'); }
				?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div> <!-- end #content-area -->

		<?php get_sidebar(); ?>
	</div> <!--end #content-->
	<div id="content-bottom"></div>

<?php get_footer(); ?>