<?php get_header(); ?>
	<div id="content-full">
		<div id="hr">
			<div id="hr-center">
				<div id="intro">
					<div class="center-highlight">

						<div class="container">

							<?php get_template_part('includes/breadcrumbs'); ?>

						</div> <!-- end .container -->
					</div> <!-- end .center-highlight -->
				</div>	<!-- end #intro -->
			</div> <!-- end #hr-center -->
		</div> <!-- end #hr -->

		<div class="center-highlight">
			<div class="container">

				<?php $i = 1; ?>

				<?php $blogcat = (int) get_catId(get_option('deepfocus_blog_cat')); ?>

				<?php if ( (is_category() && in_subcat($blogcat,$cat)) || get_option('deepfocus_blog_style') == 'on' ) { ?>

					<div id="content-area" class="clearfix">

						<div id="left-area">
							<?php get_template_part('includes/entry'); ?>
						</div> <!-- end #left-area -->

						<?php get_sidebar(); ?>

					</div> <!-- end #content-area -->

				<?php } else { ?>
					<div id="gallery">
						<div id="portfolio-items" class="clearfix">
							<?php get_template_part('includes/gallery'); ?>
						</div> <!-- end #portfolio-items -->
					</div> <!-- end #gallery -->
				<?php } ?>


			</div> <!-- end .container -->

			<?php get_footer(); ?>