<div id="sidebar">
	<?php if (is_home()) { ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Homepage') ) : ?>
		<?php endif; ?>
	<?php } else { ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
		<?php endif; ?>
	<?php }; ?>
</div> <!-- end #sidebar -->