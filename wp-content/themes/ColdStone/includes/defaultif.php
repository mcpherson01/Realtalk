<?php if (get_option('coldstone_format') == 'Magazine Style') { ?>
	<?php get_template_part('includes/magazine'); ?>
<?php } else { get_template_part('includes/default'); } ?>