<div id="sidebar">
	<?php if (get_option('elegantestate_listings') == 'on') get_template_part('includes/sidebar-listings'); ?>

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
	<?php endif; ?>
</div> <!-- end #sidebar -->