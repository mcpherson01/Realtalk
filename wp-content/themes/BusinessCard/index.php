<?php get_header(); ?>
			<div class="container-top"></div>
			<div class="container">

				<?php if (have_posts()) : while (have_posts()) : the_post()?>

					<div class="page">
						<div class="heading clearfix">
							<?php $pagetitle = get_the_title( get_the_ID() );
								  $icon = get_post_meta( get_the_ID(), 'Icon', $single = true );
								  $tagline = get_post_meta( get_the_ID(), 'Tagline', $single = true ); ?>

							<?php $arr["thumbnail"][] = get_thumbnail(32,32,'','icon','icon',false,'Icon'); ?>

							<h1 class="pagetitle"> <?php echo esc_html($pagetitle); ?> </h1>

							<?php if ( $tagline <> '' ) { ?>
								<span class="separator">|</span>
								<span class="tagline"><?php echo esc_html( $tagline ); ?></span>
							<?php }; ?>

							<?php $page_titles['title'][] = $pagetitle;
								  $page_titles['icon'][] = $icon; ?>
						</div> <!-- end .heading -->

						<div class="entry">
							<?php $more = 1;
							the_content(); ?>
						</div> <!-- end .entry -->
					</div> <!-- end .page -->

				<?php endwhile; endif; ?>

			</div>	<!-- end .container -->
			<div class="container-bottom"></div>

		</div> <!-- end #main-content -->

		<div id="sidebar">
			<ul id="nav">

				<?php for ($i = 0; $i <= (count($page_titles['title'])-1); $i++) { ?>
					<li class="clearfix"><a href="#">
						<?php if ($arr["thumbnail"][$i]["thumb"] <> '') { ?>
							<?php print_thumbnail($arr["thumbnail"][$i]["thumb"], $arr["thumbnail"][$i]["use_timthumb"], 'icon', 32, 32); ?>
						<?php }; ?>
						<?php echo($page_titles['title'][$i]); ?>
					</a></li>
				<?php }; ?>
			</ul>
		</div>	<!-- end #sidebar -->

</div> <!-- end #page-wrap -->

<?php get_footer(); ?>