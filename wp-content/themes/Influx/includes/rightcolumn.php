<div class="home-post-wrap" id="unique">
	<?php if (get_option('influx_featured') == 'on') get_template_part('includes/featured'); ?>

	<?php if (get_option('influx_show_popular') == 'on') get_template_part('includes/popular'); ?>

	<?php if (get_option('influx_show_random') == 'on') get_template_part('includes/random'); ?>
</div>