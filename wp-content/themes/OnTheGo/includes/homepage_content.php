<h2 class="title page"><span><?php the_title(); ?></span></h2>
<?php global $more;
	  $more = 0;
the_content(""); ?>
<a class="readmore" href="<?php the_permalink(); ?>"><span><?php esc_html_e('Read More','OnTheGo'); ?></span></a>