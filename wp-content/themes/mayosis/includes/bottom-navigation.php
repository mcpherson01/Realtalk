<?php wp_nav_menu( 
	array( 
	'theme_location' => 'bottom-menu', 
	'container_id' => 'mayosis-menu',
	'fallback_cb' => 'mayosis_menu_walker::fallback',
	'walker'  => new mayosis_menu_walker()
	) 
); ?>